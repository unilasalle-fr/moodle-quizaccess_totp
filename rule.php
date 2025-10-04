<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Quiz access rule requiring TOTP verification.
 *
 * @package   quizaccess_totp
 * @copyright 2025, Loïc CRAMPON <loic.crampon@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

use mod_quiz\local\access_rule_base;
use mod_quiz\quiz_settings;
use mod_quiz\form\preflight_check_form;

/**
 * Quiz access rule requiring TOTP code validation.
 *
 * Students must enter a valid TOTP code provided by the teacher
 * before they can start a quiz attempt. The validation is cached
 * in session for 1 hour per course+quiz combination.
 *
 * @package   quizaccess_totp
 * @copyright 2025, Loïc CRAMPON <loic.crampon@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class quizaccess_totp extends access_rule_base {

    /**
     * Return an appropriately configured instance of this rule.
     *
     * @param quiz_settings $quizobj The quiz settings object
     * @param int $timenow The current time
     * @param bool $canignoretimelimits Whether time limits can be ignored
     * @return quizaccess_totp|null The rule instance or null if TOTP is not configured or enabled
     */
    public static function make(quiz_settings $quizobj, $timenow, $canignoretimelimits) {
        // Check if TOTP is configured globally.
        if (!\local_totp\totp_generator::is_configured()) {
            return null;
        }

        // Check if TOTP is enabled for this specific quiz.
        if (empty($quizobj->get_quiz()->requiretotp)) {
            return null;
        }

        return new self($quizobj, $timenow);
    }

    /**
     * Add form fields for TOTP settings to the quiz settings form.
     *
     * @param mod_quiz_mod_form $quizform The quiz settings form
     * @param MoodleQuickForm $mform The form to add fields to
     */
    public static function add_settings_form_fields(
            mod_quiz_mod_form $quizform, MoodleQuickForm $mform) {

        $mform->addElement('select', 'requiretotp',
                get_string('requiretotp', 'quizaccess_totp'),
                [
                    0 => get_string('no'),
                    1 => get_string('yes'),
                ]);
        $mform->addHelpButton('requiretotp', 'requiretotp', 'quizaccess_totp');
        $mform->setDefault('requiretotp', 0);
    }

    /**
     * Save the settings from the quiz form to the database.
     *
     * @param \stdClass $quiz The quiz settings
     */
    public static function save_settings($quiz) {
        global $DB;

        if (empty($quiz->requiretotp)) {
            $DB->delete_records('quizaccess_totp', ['quizid' => $quiz->id]);
        } else {
            $record = $DB->get_record('quizaccess_totp', ['quizid' => $quiz->id]);
            if (!$record) {
                $record = new \stdClass();
                $record->quizid = $quiz->id;
                $record->requiretotp = 1;
                $DB->insert_record('quizaccess_totp', $record);
            } else {
                $record->requiretotp = 1;
                $DB->update_record('quizaccess_totp', $record);
            }
        }
    }

    /**
     * Delete any saved settings when the quiz is deleted.
     *
     * @param \stdClass $quiz The quiz being deleted
     */
    public static function delete_settings($quiz) {
        global $DB;
        $DB->delete_records('quizaccess_totp', ['quizid' => $quiz->id]);
    }

    /**
     * Return the SQL query and parameters needed to load the settings.
     *
     * @param int $quizid The quiz ID
     * @return array Array with two elements: the SQL fragment and parameters array
     */
    public static function get_settings_sql($quizid) {
        return [
            'requiretotp',
            'LEFT JOIN {quizaccess_totp} totp ON totp.quizid = quiz.id',
            [],
        ];
    }

    /**
     * Whether the user should be blocked from starting a new attempt.
     *
     * @param int $numprevattempts Number of previous attempts
     * @param object $lastattempt Last attempt object
     * @return bool False - this rule doesn't prevent new attempts
     */
    public function prevent_new_attempt($numprevattempts, $lastattempt) {
        return false;
    }

    /**
     * Whether the user should be blocked from continuing this attempt.
     *
     * @return bool False - this rule doesn't prevent access after TOTP validation
     */
    public function prevent_access() {
        return false;
    }

    /**
     * Information that this access rule requires.
     *
     * @return string Description of the rule
     */
    public function description() {
        return get_string('requiretotp', 'quizaccess_totp');
    }

    /**
     * Checks if a preflight check is required.
     *
     * Returns false if the user has already validated a TOTP code
     * for this quiz (stored in session).
     *
     * @param int|null $attemptid The attempt ID if continuing an attempt
     * @return bool True if TOTP code needs to be entered
     */
    public function is_preflight_check_required($attemptid) {
        global $SESSION;
        return empty($SESSION->quizaccess_totp_checked[$this->quiz->id]);
    }

    /**
     * Add fields to the preflight check form.
     *
     * Adds a text field for entering the TOTP code along with
     * instructions for students.
     *
     * @param preflight_check_form $quizform The preflight check form
     * @param MoodleQuickForm $mform The form to add fields to
     * @param int|null $attemptid The attempt ID if continuing an attempt
     */
    public function add_preflight_check_form_fields(preflight_check_form $quizform,
            MoodleQuickForm $mform, $attemptid) {

        $mform->addElement('header', 'totpheader', get_string('entercode', 'quizaccess_totp'));

        $mform->addElement('static', 'totpdescription', '',
            get_string('totpdescription', 'quizaccess_totp'));

        $mform->addElement('text', 'totp_code', get_string('code', 'quizaccess_totp'),
            ['size' => '10', 'maxlength' => '8']);
        $mform->setType('totp_code', PARAM_ALPHANUM);
        $mform->addRule('totp_code', get_string('required'), 'required', null, 'client');
    }

    /**
     * Validate the preflight check.
     *
     * Validates the TOTP code entered by the user using the local_totp plugin.
     *
     * @param array $data Form data
     * @param array $files Uploaded files
     * @param array $errors Array of errors to add to
     * @param int|null $attemptid The attempt ID if continuing an attempt
     * @return array Updated errors array
     */
    public function validate_preflight_check($data, $files, $errors, $attemptid) {
        $code = clean_param($data['totp_code'], PARAM_ALPHANUM);
        $courseid = $this->quiz->course;

        if (!\local_totp\totp_generator::validate($code, $courseid, 0)) {
            $errors['totp_code'] = get_string('invalidcode', 'quizaccess_totp');
        }

        return $errors;
    }

    /**
     * This is called when the current attempt at the quiz is finished.
     *
     * Clears the flag in the session that says the user has already
     * entered the TOTP code for this quiz.
     */
    public function current_attempt_finished() {
        global $SESSION;
        if (!empty($SESSION->quizaccess_totp_checked[$this->quiz->id])) {
            unset($SESSION->quizaccess_totp_checked[$this->quiz->id]);
        }
    }

    /**
     * Called when the preflight check has passed.
     *
     * This is called after the user has successfully entered the TOTP code.
     * We store a flag in the session to remember they have already been checked.
     *
     * @param int|null $attemptid The attempt ID
     */
    public function notify_preflight_check_passed($attemptid) {
        global $SESSION;
        $SESSION->quizaccess_totp_checked[$this->quiz->id] = true;
    }
}