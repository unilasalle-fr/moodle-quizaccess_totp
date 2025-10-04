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
 * Language strings for quizaccess_totp.
 *
 * @package   quizaccess_totp
 * @copyright 2025, Loïc CRAMPON <loic.crampon@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'TOTP access rule';
$string['requiretotp'] = 'Require TOTP code';
$string['requiretotp_help'] = 'If enabled, students must enter a valid TOTP (Time-based One-Time Password) code before they can start a quiz attempt. The teacher must display the current TOTP code during the quiz session.';
$string['entercode'] = 'Enter TOTP code';
$string['totpdescription'] = 'Ask your teacher for the current TOTP code to access this quiz.';
$string['code'] = 'TOTP Code';
$string['invalidcode'] = 'Invalid TOTP code. Please try again.';
$string['privacy:metadata'] = 'The TOTP access rule plugin does not store any personal data. It only uses temporary session data to cache TOTP validation.';