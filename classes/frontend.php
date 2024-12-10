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
        // Should you need strings from another language file, you can also
        // call $PAGE->requires->strings_for_js manually from here.)
        return array();
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
        return array();
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
        return true;
    }
}