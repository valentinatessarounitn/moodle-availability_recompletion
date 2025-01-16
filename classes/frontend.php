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

 namespace availability_recompletion;

/**
 * Front-end class.
 *
 * @package availability_recompletion
 * @copyright 2025 Tessaro Valentina <valentina.tessaro@unitn.it>>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class frontend extends \core_availability\frontend {

    /**
     * Gets a list of string identifiers (in the plugin's language file) that are required in JavaScript for this plugin.
     *
     * @return Array of required string identifiers
     */
    protected function get_javascript_strings() {
        // You can return a list of names within your language file and the
        // system will include them here.
        return ['label_end', 'label_start', 'title', 'this_course'];
    }

    /**
     * Delivers parameters to the javascript part of the plugin.
     * The returned array consists of id and shortname of the course that can be recompleted.
     *
     * @param  \stdClass $course Course object
     * @param  ?\cm_info $cm Course-module currently being edited (null if none)
     * @param  ?\section_info $section Section currently being edited (null if none)
     * @return array Array of parameters for the JavaScript function
     */
    protected function get_javascript_init_params(
        $course,
        \cm_info $cm = null,
        \section_info $section = null
    ) {
        // If you want, you can add some parameters here which will be
        // passed into your JavaScript init method. If you don't include
        // this function, there will be no parameters.
        global $DB;
        $context = \context_course::instance($course->id);

        // Get all course names that are present in the recompletion table.
        $datcms = [];

        // Get the list of all courses with at least one user who has
        // completed the course and has the possibility to recomplete it.
        $sql = "SELECT DISTINCT id, category, shortname FROM {course}
                WHERE id IN (SELECT course FROM {local_recompletion_cc} WHERE timecompleted IS NOT NULL)
                ORDER BY fullname ASC";
        // Retrieve the list of courses.
        $other = $DB->get_records_sql($sql);
        foreach ($other as $othercm) {

            if (($othercm->category > 0) && ($othercm->id == $course->id)) {
                // Add the current course to the list with as 'this course'.
                $thiscourse = get_string('this_course', 'availability_recompletion');
                $datcms[] = (object)[
                    'id' => $course->id,
                    'name' => format_string($thiscourse, true, ['context' => $context]),
                ];
            }

            // Disable not created course and default course.
            if (($othercm->category > 0) && ($othercm->id != $course->id)) {
                    $datcms[] = (object)[
                        'id' => $othercm->id,
                        'name' => format_string($othercm->shortname, true, ['context' => $context]),
                    ];
            }
        }
        return [$datcms];
    }

    /**
     * Check if the condition can be added.
     * Can only be added if there's at least one course with recompletion info.
     *
     * @param \stdClass $course
     * @param \cm_info|null $cm
     * @param \section_info|null $section
     * @return bool
     */
    protected function allow_add(
        $course,
        \cm_info $cm = null,
        \section_info $section = null
    ) {
        // This function lets you control whether the 'add' button for your
        // plugin appears. For example, the grouping plugin does not appear
        // if there are no groupings on the course. This helps to simplify
        // the user interface. If you don't include this function, it will
        // appear.

        // Check if there's at least one course with recompletion info.
        $params = $this->get_javascript_init_params($course, $cm, $section);
        return ((array)$params[0]) != false;
    }
}
