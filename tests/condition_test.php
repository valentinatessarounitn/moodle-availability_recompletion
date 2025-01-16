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

namespace availability_recompletion;

use core_availability\info;
use core_availability\info_module;
use core_availability\info_section;
use availability_recompletion\condition;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * Unit tests for the recompletion condition.
 *
 * @package     availability_recompletion
 * @copyright   2025 Tessaro Valentina <valentina.tessaro@unitn.it>>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class condition_test extends \advanced_testcase {

    /** @var stdClass inpersoncourse. */
    private $inpersoncourse;

    /** @var stdClass renewalcourse. */
    private $renewalcourse;

    /** @var stdClass inpersonuser. */
    private $inpersonuser;

    /** @var stdClass renewaluser. */
    private $renewaluser;

    /**
     * Create course and page.
     */
    public function setUp(): void {
        global $CFG;
        parent::setUp();

        // Load the mock info class so that it can be used.
        require_once($CFG->dirroot . '/availability/tests/fixtures/mock_info.php');
        require_once($CFG->dirroot . '/availability/tests/fixtures/mock_info_module.php');
        require_once($CFG->dirroot . '/availability/tests/fixtures/mock_info_section.php');
        require_once($CFG->libdir . '/completionlib.php');
        $this->resetAfterTest();
        $CFG->enableavailability = true;
        set_config('enableavailability', true);
        $dg = $this->getDataGenerator();

        // Create two courses.
        $this->inpersoncourse = $dg->create_course();
        $this->renewalcourse = $dg->create_course();

        // Create two users as students.
        $this->inpersonuser = $dg->create_user();
        $this->renewaluser = $dg->create_user();
    }

    /**
     * Tests the save() function.
     *
     * @covers \availability_recompletion\condition::save()
     */
    public function test_save_equals() {
        $structure = (object)['cm' => 1];
        $cond = new condition($structure);
        $structure->type = 'recompletion';
        $this->assertEquals($structure, $cond->save());

        $cond1 = new condition($structure);
        $cond1->cm = '1';
        $this->assertEquals($structure, $cond1->save());
    }

    /**
     * Tests the save() function.
     *
     * @covers \availability_recompletion\condition::save()
     */
    public function test_save_not_equals() {
        $structure = (object)['cm' => 1];
        $cond = new condition($structure);
        $cond->cm = 3;
        $this->assertNotEquals($structure, $cond->save());
    }

    /**
     * Tests the constructor error conditions.
     *
     * @covers \availability_recompletion\condition::__construct($structure)
     */
    public function test_constructor_exception() {
        $msg = 'Coding error detected, it must be fixed by a programmer: Invalid course ID: null or non-integer value';

        // No parameters.
        $structure = new \stdClass();
        try {
            $cond = new condition($structure);
            $this->fail();
        } catch (\coding_exception $exception) {
            $this->assertEquals(0, $exception->getCode());
            $this->assertEquals($msg, $exception->getMessage());
        }

        // Invalid $cm.
        $structure = (object)['cm' => 'a'];
        try {
            $cond = new condition($structure);
            $this->fail();
        } catch (\coding_exception $exception) {
            $this->assertEquals(0, $exception->getCode());
            $this->assertEquals($msg, $exception->getMessage());
        }
    }

    /**
     * Tests the constructor and the string conversion feature (intended for debugging only).
     *
     * @covers \availability_recompletion\condition::__construct($structure)
     * @covers \availability_recompletion\condition::get_debug_string()
     */
    public function test_constructor() {

        $structure = (object)['cm' => 10242];
        $cond = new condition($structure);
        $this->assertEquals('{recompletion:10242 : NO}', (string)$cond);

        $structure->cm = 4562;
        $cond = new condition($structure);
        $this->assertEquals('{recompletion:4562 : NO}', (string)$cond);
    }

    /**
     * Tests whether description is correct
     * @covers \availability_recompletion\condition::get_description()
     * @return void
     */
    public function test_get_description(): void {
        $info = new \core_availability\mock_info();

        // Test course inpersoncourse.
        $requiresrecompletion = '~has <strong>not</strong> completed <strong>'.$this->inpersoncourse->fullname.'</strong>~';
        $notrequiresrecompletion = '~has already completed <strong>'.$this->inpersoncourse->fullname.'</strong>~';
        $structure = (object)['type' => 'recompletion', 'cm' => $this->inpersoncourse->id];
        $cond = new condition($structure);
        $description = $cond->get_description(true, false, $info);
        $this->assertMatchesRegularExpression($notrequiresrecompletion, $description);
        $description = $cond->get_description(true, true, $info);
        $this->assertMatchesRegularExpression($requiresrecompletion, $description);

        // Test course inpersoncourse.
        $requiresrecompletion = '~has <strong>not</strong> completed <strong>'.$this->renewalcourse->fullname.'</strong>~';
        $notrequiresrecompletion = '~has already completed <strong>'.$this->renewalcourse->fullname.'</strong>~';
        $structure = (object)['type' => 'recompletion', 'cm' => $this->renewalcourse->id];
        $cond = new condition($structure);
        $description = $cond->get_description(true, false, $info);
        $this->assertMatchesRegularExpression($notrequiresrecompletion, $description);
        $description = $cond->get_description(true, true, $info);
        $this->assertMatchesRegularExpression($requiresrecompletion, $description);
    }

    /**
     * Tests whether activity is available or not
     * @covers \availability_dedicationtime\condition
     * @return void
     */
    public function test_is_available(): void {
        global $DB;

        // Write in DB that the user inpersonuser has completed the course and then removed it.
        $data = new stdClass();
        $data->userid = $this->inpersonuser->id;
        $data->course = $this->inpersoncourse->id;
        $data->timecompleted = time();
        $DB->insert_record('local_recompletion_cc', $data);

        $rec = ['course' => $data->course];
        $page = $this->getDataGenerator()->get_plugin_generator('mod_page')->create_instance($rec);
        $info = new \core_availability\mock_info($this->inpersoncourse, $this->inpersonuser->id);

        // Create the condition access.
        $structure = (object)['type' => 'recompletion', 'cm' => $this->inpersoncourse->id];
        $cond = new condition($structure);

        // User inpersonuser has completed the course inpersoncourse and was removed.
        $this->assertTrue($cond->is_available(false, $info, false, $this->inpersonuser->id));

        // User renewaluser never completed the course inpersoncourse.
        $this->assertFalse($cond->is_available(false, $info, false, $this->renewaluser->id));

         // Test "this course": the condition is set for the course inperson and the user is inside the same course.
        $description = $cond->get_description(true, false, $info);
        $this->assertMatchesRegularExpression('~already completed <strong>this course</strong>~', $description);
    }
}
