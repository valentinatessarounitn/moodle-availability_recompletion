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

use core_availability\info;
use core_availability\info_module;
use core_availability\info_section;
use availability_recompletion\condition;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the recompletion condition.
 *
 * @package     availability_recompletion
 * @copyright   2024 Tessaro Valentina <valentina.tessaro@unitn.it>>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class condition_test extends advanced_testcase {

    /**
     * Setup to ensure that fixtures are loaded.
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
        $this->setAdminUser();
        $CFG->enablecompletion = true;
        $CFG->enableavailability = true;
        set_config('enableavailability', true);
        $dg = $this->getDataGenerator();
        $now = time();
        $this->course = $dg->create_course(['startdate' => $now, 'enddate' => $now + 7 * WEEKSECS, 'enablecompletion' => 1]);
        $this->user = $dg->create_user(['timezone' => 'UTC']);
        $dg->enrol_user($this->user->id, $this->course->id, 5, time());
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
}
