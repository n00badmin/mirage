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
 +-------------------------------------------------------------------------+
*/

function mirage_config_settings () {
	global $tabs, $settings, $item_rows, $config;
	if (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) != 'settings.php') return;
	/*
	File Output Path (relative to cacti) = /log/mirage.log
	Max file size in bytes = 104857600
	Files to rotate = 5
	*/
	//include_once("./plugins/mirage/mirage_functions.php");
	//$mirage_log_path = $config['base_path'];
	$mirage_log_path = $config['base_path'] . '/log/';
	$tabs['mirage'] = 'Mirage';
	$settings['mirage'] = array(
		'mirage_output_header' => array(	
			'friendly_name' => 'Mirage Output Options',
			'method' => 'spacer',
			),
		'mirage_log_type' => array(
			'friendly_name' => 'Mirage output format',
			'description' => 'This is the output format in the log file',
			'method' => 'drop_array',
			'array' => array("kv" => "logfile (kv pairs)"),
			'default' => "kv"
			),	
		'mirage_log_path' => array(
			'friendly_name' => 'Mirage output path',
			'description' => 'This is the path location to output the logs',
			'method' => 'textbox',
			'default' => $mirage_log_path,
			'max_length' => 255
			),
		'mirage_log_filename' => array(
			'friendly_name' => 'Mirage log filename',
			'description' => 'This is the filename which will contain the Poller Output data. (ie: mirage_poller_output.log)',
			'method' => 'textbox',
			'default' => 'mirage_poller_output.log',
			'max_length' => 255
			),
		'mirage_hostname_filename' => array(
			'friendly_name' => 'Mirage hostname filename',
			'description' => 'This is the filename which will contain the hostnames details data. (ie: mirage_hostname_output.log)',
			'method' => 'textbox',
			'default' => 'mirage_hostname_output.log',
			'max_length' => 255
			),
		'mirage_rotation_header' => array(	
			'friendly_name' => 'Mirage File Output Rotation',
			'method' => 'spacer',
			),
		'mirage_rotation' => array(
			'friendly_name' => 'Enable file rotation',
			'description' => 'Checking this box will enable file rotation. (default: ON)',
			'method' => 'drop_array',
            'array' => array("on" => "Turn On - Log Rotation (Default)",
                             "off" => "Turn Off"),
			'default' => 'on'
			),
		'mirage_rotation_size' => array(
			'friendly_name' => 'File rotation max file size',
			'description' => 'Set the max file size in bytes. (default: 104857600 bytes)',
			'method' => 'textbox',
			'default' => '104857600'
			),
		'mirage_rotation_files' => array(
			'friendly_name' => 'Number of files to rotate',
			'description' => 'Set the number of files to rotate. (default: 5)',
			'method' => 'textbox',
			'default' => '5'
			),
        'mirage_debug_header' => array(
            'friendly_name' => 'Mirage Debug',
            'method' => 'spacer',
            ),
        'mirage_debug' => array(
            'friendly_name' => 'Enable Mirage Debug',
            'description' => 'debug logs outputted into cacti.log',
            'method' => 'checkbox'
            ),
		);
}

?>
