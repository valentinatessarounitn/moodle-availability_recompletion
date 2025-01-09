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
 * Unit tests for the recompletion condition.
 *
 * @package     availability_recompletion
 * @copyright   2024 Tessaro Valentina <valentina.tessaro@unitn.it>>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 namespace availability_recompletion;

 use advanced_testcase;
 use core_availability\{tree, mock_info, info_module, info_section};
 use stdClass;
 use availability_recompletion\condition;

 /**
 * Unit tests for the recompletion condition.
 *
 * @package availability_recompletion
 * @copyright   2024 Tessaro Valentina <valentina.tessaro@unitn.it>>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class condition_test extends advanced_testcase {

    /**
     * Tests the save() function.
     * 
     * @covers \availability_recompletion\condition::save()
     */
    public function test_save() {
        $structure = (object)['cm' => 1];
        $cond = new condition($structure);
        $structure->type = 'recompletion';
        $this->assertEquals($structure, $cond->save());
    }
}
