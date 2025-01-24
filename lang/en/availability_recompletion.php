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
 * @copyright   2025 Tessaro Valentina <valentina.tessaro@unitn.it>>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['description'] = 'Exclude or limit to students who have undone course completion.';
$string['pluginname'] = 'Restriction by recompletion';
$string['title'] = 'Recompletion';
$string['requires_recompletion'] = 'The student <strong>must not</strong> have undone the completion of <strong>{$a}</strong>.';
$string['requires_notrecompletion'] = 'The student must have undone the completion of <strong>{$a}</strong>.';
$string['privacy:metadata'] = 'The Restriction by recompletion plugin does not store any personal data.';
$string['error_selectcmid'] = 'You must select a course for the recompletion condition.';
$string['label'] = ' Must have undone the course completion ';
$string['this_course'] = 'this course';
$string['course_not_found'] = 'The condition refers to a course that no longer exists with ID {$a}, it was probably deleted. This condition needs to be reviewed.';
