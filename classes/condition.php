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
 * Condition main class.
 *
 * @package availability_recompletion
 * @copyright 2024 Tessaro Valentina <valentina.tessaro@unitn.it>>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class condition extends \core_availability\condition {
    // Any data associated with the condition can be stored in member
    // variables. Here's an example variable:
    //protected $allow;

    /**
     * Constructor.
     *
     * @param \stdClass $structure Data structure from JSON decode
     */
    public function __construct($structure) {
        // Retrieve any necessary data from the $structure here. The
        // structure is extracted from JSON data stored in the database
        // as part of the tree structure of conditions relating to an
        // activity or section.
        // For example, you could obtain the 'allow' value:
        //$this->allow = $structure->allow;

        // It is also a good idea to check for invalid values here and
        // throw a coding_exception if the structure is wrong.
    }

    /**
     * save the plugin configuration to an activity.
     */
    public function save() {
        //$result = (object)array('type' => 'recompletion', 'allow' => $this->allow);
        $result = (object)array('type' => 'recompletion');
        return $result;
    }

     /**
     * verifies whether a student has already completed the corse and then removed or not.
     *
     * @param boolval $not - whether or not to negate the result
     * @param \core_availability\info $info
     * @param \stdClass $grabthelot
     * @param int $userid
     */
    public function is_available(
        $not,
        \core_availability\info $info,
        $grabthelot,
        $userid
    ) {
        $course = $info->get_course();
        $context = \context_course::instance($course->id);
        // $allow = is_enrolled($context, $userid, '', true);  //todo fix this

        // The NOT condition applies before accessallgroups (i.e. if you
        // set something to be available to those NOT in group X,
        // people with accessallgroups can still access it even if
        // they are in group X).

        return $not;
    }

    public function get_description(
        $full,
        $not,
        \core_availability\info $info
    ) {
        // This function returns the information shown about the
        // condition on editing screens.
        // Usually it is similar to the information shown if the
        // user doesn't meet the condition.
        // Note: it does not depend on the current user.
        //$allow = $not ? !$this->allow : $this->allow;

        $name = 'this course'; // todo change course name

        // $not is true if in Access restrictions the condition is set to 'Student must not match the following'.

        $requireornot = $not ? 'requires_recompletion' : 'requires_notrecompletion';
        return get_string($requireornot, 'availability_recompletion', $name);
    }

    protected function get_debug_string() {
        // This function is only normally used for unit testing and
        // stuff like that. Just make a short string representation
        // of the values of the condition, suitable for developers.
        //return $this->allow ? 'YES' : 'NO';
        return 'todo';
    }
}