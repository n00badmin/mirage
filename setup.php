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

function plugin_mirage_install () {
	global $config;
	api_plugin_register_hook('mirage', 'poller_output', 'mirage_poller_output', 'includes/polling.php');
	//api_plugin_register_hook('mirage', 'api_device_save', 'mirage_api_device_save', 'setup.php');
	//include_once($config['base_path'] . '/plugins/mirage/includes/database.php');
	//mirage_setup_database();
}

function plugin_mirage_uninstall () {
	// Do any extra Uninstall stuff here
}

function plugin_mirage_check_config () {
	// Here we will check to ensure everything is configured
	return true;
}

function mirage_version () {
	return plugin_mirage_version();
}

function plugin_mirage_version () {
	return array(
			'name'		=> 'mirage',
			'version' 	=> '1.0',
			'longname'	=> 'Mirage',
			'author'	=> 'Matthew Modestino, Patrick Best, Philippe Tang, Menno Vanderlist',
			'homepage'	=> 'http://docs.cacti.net/plugin:mirage',
			'email'	=> 'xxx@gmail.com',
			'url'		=> 'http://docs.cacti.net/plugin:mirage'
			);
}

?>