<?php
// This file is part of the FilterCodes plugin for Moodle - http://moodle.org/
//
// FilterCodes is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// FilterCodes is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with FilterCodes.  If not, see <http://www.gnu.org/licenses/>.

defined('MOODLE_INTERNAL') || die();

/**
 * Apply filters to Moodle custom menu.
 * @package   filter_filtercodes
 * @copyright 2016-2018 TNG Consulting Inc. (https://tngconsulting.ca)
 * @author    Michael Milette
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
function filter_filtercodes_render_navbar_output() { // Supported as of Moodle 3.2+.
    filtercodesmenu();
    return '';
}

function filtercodesmenu() {
    global $CFG, $PAGE;

    // Don't filter menus on Theme Settings page or it will filter the custommenuitems field in the page and loose the tags.
    if ($PAGE->pagetype != 'admin-setting-themesettings' && stripos($CFG->custommenuitems, '{') !== false) {

        // Don't apply auto-linking filters.
        $filtermanager = filter_manager::instance();
        $filteroptions = array('originalformat' => FORMAT_HTML, 'noclean' => true);
        $skipfilters = array('activitynames', 'data', 'glossary', 'sectionnames', 'bookchapters');

        // Filter Custom Menu.
        $CFG->custommenuitems = $filtermanager->filter_text($CFG->custommenuitems, $PAGE->context, $filteroptions, $skipfilters);

    }
}