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

 use core_availability\info;

/**
 * Condition main class.
 *
 * @package availability_recompletion
 * @copyright 2025 Tessaro Valentina <valentina.tessaro@unitn.it>>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class condition extends \core_availability\condition {

    /** @var int ID of course that this condition requires */
    protected $courseid;

    /** @var bool whether the user has already completed the course and then removed it */
    protected $courserecompletion;

    /**
     * Constructor.
     *
     * @param \stdClass $structure Data structure from JSON decode
     * @throws \coding_exception If invalid data structure.
     */
    public function __construct($structure) {
        // Retrieve any necessary data from the $structure here. The
        // structure is extracted from JSON data stored in the database
        // as part of the tree structure of conditions relating to an
        // activity or section.

        // It is also a good idea to check for invalid values here and
        // throw a coding_exception if the structure is wrong.

        // Get courseid.
        if (isset($structure->cm) && is_number($structure->cm)) {
            $this->courseid = (int)$structure->cm;
        } else {
            throw new \coding_exception('Invalid course ID: null or non-integer value');
        }
    }

    /**
     * Save.
     *
     * @return object|\stdClass $result
     */
    public function save() {

        $result = (object)['type' => 'recompletion'];
        if ($this->courseid) {
            $result->cm = $this->courseid;
        }
        return $result;
    }

    /**
     * Verifies whether a student has already completed the corse and then removed or not.
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
    ): bool {
        global $DB;
        $course = $this->courseid;

        // The plugin local_recompletion store in the DB table local_recompletion_cc the information
        // about the user who has completed the course and then removed it.
        $filter = 'userid = ? and course = ? and timecompleted IS NOT NULL';
        $this->courserecompletion = $DB->record_exists_select('local_recompletion_cc', $filter, [$userid, $course]);
        // Bool $courserecompletion is true if the user with id === userid has already completed
        // the course with id === $course in the past and then removed it.
        $allow = $this->courserecompletion;
        if ($not) {
            $allow = !$allow;
        }
        return $allow;
    }

    /**
     * Retrieve the description for the restriction.
     *
     * @param bool                    $full
     * @param bool                    $not
     * @param \core_availability\info $info
     *
     * @return string
     */
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

        global $DB;

        // Default value is 'this course'.
        $name = get_string('this_course', 'availability_recompletion');

        // When the condition is set on a course different from the current one,
        // instead of using 'this course' I use the name of the course on which the constraint was applied.
        if ($info->get_course()->id != $this->courseid && $this->courseid != null) {

            $sqlcourseobj = "SELECT * FROM {course} WHERE id = $this->courseid LIMIT 1";
            $courseobj = $DB->get_record_sql($sqlcourseobj);

            // Print the id of the course if the course is not found.
            $name = $courseobj != null && $courseobj->fullname != null ? $courseobj->fullname : $this->courseid;
        }

        // If $not == true => in Access restrictions the condition is set to 'Student must not match the following'.
        $requireornot = $not ? 'requires_recompletion' : 'requires_notrecompletion';
        return get_string($requireornot, 'availability_recompletion', $name);
    }

    /**
     * Retrieve debugging string.
     *
     * @return string
     */
    protected function get_debug_string() {
        // This function is only normally used for unit testing and
        // stuff like that. Just make a short string representation
        // of the values of the condition, suitable for developers.
        return $this->courseid . ' : ' . ($this->courserecompletion ? 'YES' : 'NO');
    }
}
