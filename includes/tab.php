<?php
/*
 ex: set tabstop=4 shiftwidth=4 autoindent:
 +-------------------------------------------------------------------------+
 | Copyright (C) 2016 Matthew Modestino, Philippe Tang, Menno Vanderlist   |
 |                                                                         |
 | This program is free software; you can redistribute it and/or           |
 | modify it under the terms of the GNU General Public License             |
 | as published by the Free Software Foundation; either version 2          |
 | of the License, or (at your option) any later version.                  |
 |                                                                         |
 | This program is distributed in the hope that it will be useful,         |
 | but WITHOUT ANY WARRANTY; without even the implied warranty of          |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           |
 | GNU General Public License for more details.                            |
 +-------------------------------------------------------------------------+
 | https://github.com/n00badmin/mirage                                     |
 | http://docs.cacti.net/plugin:mirage                                     |
 +-------------------------------------------------------------------------+
*/

function mirage_show_tab () {
	global $config;
	if (api_user_realm_auth('mirage_graph.php')) {
		$cp = false;
		if (basename($_SERVER['PHP_SELF']) == 'mirage_graph.php')
			$cp = true;

		print '<a href="' . $config['url_path'] . 'plugins/mirage/mirage_graph.php"><img src="' . $config['url_path'] . 'plugins/mirage/images/tab_mirage' . ($cp ? '_down': '') . '.gif" alt="mirage" align="absmiddle" border="0"></a>';
	}
}
