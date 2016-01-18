<?php
/*
 ex: set tabstop=4 shiftwidth=4 autoindent:
 +-------------------------------------------------------------------------+
 | Copyright (C) 2011 The Cacti Group                                      |
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
 | Cacti: The Complete RRDTool-based Graphing Solution                     |
 +-------------------------------------------------------------------------+
 | This code is designed, written, and maintained by the Cacti Group. See  |
 | about.php and/or the AUTHORS file for specific developer information.   |
 +-------------------------------------------------------------------------+
 | http://www.cacti.net/                                                   |
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