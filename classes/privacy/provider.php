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
 * Privacy Subsystem implementation for quizaccess_totp.
 *
 * @package   quizaccess_totp
 * @copyright 2025, Loïc CRAMPON <loic.crampon@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace quizaccess_totp\privacy;

defined('MOODLE_INTERNAL') || die();

/**
 * Privacy provider for the TOTP access rule.
 *
 * This plugin does not store any personal data. It only uses temporary
 * session data to cache TOTP validation for one hour.
 *
 * @package   quizaccess_totp
 * @copyright 2025, Loïc CRAMPON <loic.crampon@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements \core_privacy\local\metadata\null_provider {

    /**
     * Get the language string identifier with the component's language
     * file to explain why this plugin stores no data.
     *
     * @return string Language string key
     */
    public static function get_reason(): string {
        return 'privacy:metadata';
    }
}
