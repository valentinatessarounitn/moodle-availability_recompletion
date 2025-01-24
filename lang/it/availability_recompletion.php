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

$string['description'] = 'Escludi o limita agli studenti che hanno un completamento corso annullato.';
$string['pluginname'] = 'Criterio basato sul ricompletamento';
$string['title'] = 'Ricompletamento';
$string['requires_recompletion'] = 'Lo studente <strong>non</strong> deve avere il completamento annullato di <strong>{$a}</strong>.';
$string['requires_notrecompletion'] = 'Lo studente deve avere il completamento annullato di <strong>{$a}</strong>.';
$string['privacy:metadata'] = 'Il plugin Restrizione per ricompletamento non memorizza alcun dato personale.';
$string['error_selectcmid'] = 'Devi selezionare un corso per la condizione di ricompletamento.';
$string['label'] = ' Deve aver annullato il completamento del corso ';
$string['this_course'] = 'questo corso';
$string['course_not_found'] = 'La condizione si riferisce ad un corso che non esiste più con ID {$a}, probabilmente è stato eliminato. Serve rivedere questa condizione.';
