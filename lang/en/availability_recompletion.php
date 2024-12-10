<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin version and other meta-data are defined here.
 *
 * @package     availability_recompletion
 * @copyright   2024 Tessaro Valentina <valentina.tessaro@unitn.it>>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['description'] = 'Exclude students who have already completed this course and have been removed due to certificate expiration.';
$string['error_selectrecompletion'] = 'Need local/recompletion plugin.';
$string['error_recompletion'] = '';
$string['error_database'] = '';
$string['course'] = 'this course';
$string['missing'] = '(missing)';
$string['pluginname'] = 'Restriction by recompletion';
$string['title'] = 'Recompletion';

// todo: replace 'this course' with course name (<strong>{$a}</strong>)
$string['short_description'] = 'Student has completed this course and the certification has expired';

$string['requires_recompletion'] = 'The student has <strong>not</strong> completed <strong>{$a}</strong> in the past'; 
$string['requires_notrecompletion'] = 'The student has already completed <strong>{$a}</strong> in the past';
$string['privacy:metadata'] = 'The Restriction by recompletion plugin does not store any personal data.';
