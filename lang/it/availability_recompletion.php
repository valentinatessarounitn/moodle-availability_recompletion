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

$string['description'] = 'Escludi o limita agli studenti che hanno già completato il corso e sono stati rimossi a causa della scadenza del certificato.';
$string['pluginname'] = 'Restrizione per ricompletamento';
$string['title'] = 'Ricompletamento';
$string['requires_recompletion'] = 'Lo studente <strong>non</strong> ha completato <strong>{$a}</strong> in passato.';
$string['requires_notrecompletion'] = 'Lo studente ha già completato <strong>{$a}</strong> in passato.';
$string['privacy:metadata'] = 'Il plugin Restrizione per ricompletamento non memorizza alcun dato personale.';
$string['error_selectcmid'] = 'Devi selezionare un corso per la condizione di ricompletamento.';
$string['label_start'] = 'Lo studente ha completato ';
$string['label_end'] = 'e il certificato è scaduto';
$string['this_course'] = 'questo corso';
