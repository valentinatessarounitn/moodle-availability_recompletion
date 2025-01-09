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
 use core_availability\info;

/**
 * Condition main class.
 *
 * @package availability_recompletion
 * @copyright 2024 Tessaro Valentina <valentina.tessaro@unitn.it>>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class condition extends \core_availability\condition {

    // @var int ID of course that this condition requires
    protected $courseid;

    // @var bool whether the user has already completed the course and then removed it
    protected $courserecompletion;

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

        // Get courseid.
        if (isset($structure->cm) && is_number($structure->cm)) {
            $this->courseid = (int)$structure->cm;
        } else {
            throw new \coding_exception('Invalid course ID: null or non-integer value');
        }

        // Debug print
        // debugging('structure: ' . print_r($structure, true), DEBUG_NONE);
        // echo '<br>inside init<br>';
        // echo 'courseid: ' . $this->courseid;
        // debugging('Course ID: ' . $this->courseid, DEBUG_NORMAL);
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
    ): bool {
        global $DB;

        $course = $this->courseid;

        // Debug print
        // echo '<br>inside is_available';
        // echo '<br> courseid: ' . $course;
        // echo '<br> userid ' . $userid;

        // $courserecompletion is true if the user with id === userid has already completed the course with id === $course in the past and then removed it.
        $this->courserecompletion = $DB->record_exists_select('local_recompletion_cc', 'userid = ? and course = ? and timecompleted IS NOT NULL', array($userid, $course));
        
        $allow = $this->courserecompletion;

        if ($not) {
            $allow = !$allow;
        }
        
        // Debug print
        //debugging('Checking recompletion condition for user ' . $userid . ' has already completed in the past the course ' . $course . ': ' . ($this->courserecompletion ? 'YES' : 'NO'), DEBUG_NONE);

        // echo '<br> User ' . $userid . ' has already completed in the past the course ' . $course . '? ';
        // echo '<br> ' . ($this->courserecompletion ? 'YES' : 'NO');
        
        return $allow;
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

        global $DB;

        $name = get_string('this_course', 'availability_recompletion'); // default value is 'this course'

        // when the condition is set on a course different from the current one, 
        // instead of using 'this course' I use the name of the course on which the constraint was applied.
        if($info->get_course()->id != $this->courseid && $this->courseid != NULL) {

            $sqlcourseobj = "SELECT * FROM {course} WHERE id = $this->courseid LIMIT 1";
            $courseobj = $DB->get_record_sql($sqlcourseobj);
            $name = $courseobj->fullname;
        }

        // $not == true => in Access restrictions the condition is set to 'Student must not match the following'.
        $requireornot = $not ? 'requires_recompletion' : 'requires_notrecompletion';
        return get_string($requireornot, 'availability_recompletion', $name);
    }

    protected function get_debug_string() {
        // This function is only normally used for unit testing and
        // stuff like that. Just make a short string representation
        // of the values of the condition, suitable for developers.
        //return $this->allow ? 'YES' : 'NO';
        return $this-> courseid . ' : ' . ($this->courserecompletion ? 'YES' : 'NO');
    }

     /**
     * Returns a JSON object which corresponds to a condition of this type.
     *
     * Intended for unit testing, as normally the JSON values are constructed
     * by JavaScript code.
     *
     * @param int $courseid Course id of other activity
     */
    /*
    public static function get_json($courseid) {
        return (object)array('type' => 'recompletion', 'cm' => (int)$courseid);
    }*/
    
}