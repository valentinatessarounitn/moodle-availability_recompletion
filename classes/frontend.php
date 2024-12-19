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

 namespace availability_recompletion;

 defined('MOODLE_INTERNAL') || die();

/**
 * Front-end class.
 *
 * @package availability_recompletion
 * @copyright 2024 Tessaro Valentina <valentina.tessaro@unitn.it>>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 class frontend extends \core_availability\frontend {

    /**
     * returns frontend strings
     */
    protected function get_javascript_strings() {
        // You can return a list of names within your language file and the
        // system will include them here.
        return array('label_end', 'label_start', 'title', 'this_course');
    }

    /**
     * dummy function to make moodle happy
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

        // get all course names that are present in the recompletion table
        $datcms = array();

        // get the list of all courses with at least one user who has completed the course and has the possibility to recomplete it
        $sql = "SELECT DISTINCT id, category, shortname FROM {course} 
                WHERE id IN (SELECT course FROM {local_recompletion_cc} WHERE timecompleted IS NOT NULL)
                ORDER BY fullname ASC";

        $other = $DB->get_records_sql($sql);



        foreach ($other as $othercm) {

            if(($othercm->category > 0) && ($othercm->id == $course->id)){
                // add the current course to the list with as 'this course'
                $thiscourse = get_string('this_course', 'availability_recompletion');
                $datcms[] = (object)array(
                    'id' => $course->id,
                    'name' => format_string($thiscourse, true, array('context' => $context))
                );
            }

            // disable not created course and default course
            if(($othercm->category > 0) && ($othercm->id != $course->id)){
                    $datcms[] = (object)array(
                        'id' => $othercm->id,
                        'name' => format_string($othercm->shortname, true, array('context' => $context))
                    );
            }
        }

        // Debug print
        debugging('Frontend course available ' . print_r($datcms, true), DEBUG_NONE);

        return array($datcms);
    }

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

        // Check if there's at least one other module with recompletion info.
        $params = $this->get_javascript_init_params($course, $cm, $section);
        return ((array)$params[0]) != false;        
    }
}