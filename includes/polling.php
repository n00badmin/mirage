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

function mirage_poller_output ($rrd_update_array) {
    /* Interception of poller_output via $rrd_update_array Array variable */
	global $config, $debug;
	//include_once($config['base_path'] . '/plugins/mirage/mirage_functions.php');
    //TODO: make this a config setting
    
	// log filetype setting
	if(read_config_option('mirage_log_type') == '0') {
		$log_filetype = ".log";
	} else {
		// default to .log if not set in settings
		$log_filetype = ".log"; 
	}
	
	/* mirage rotation setting */
	$log_rotation = FALSE;
	if(read_config_option('mirage_rotation') == 'on') {
		$log_rotation = TRUE;
		$log_rotation_size = read_config_option('mirage_rotation_size');
		$log_rotation_n = read_config_option('mirage_rotation_files');
	}
	
	/* file path + filename */
	if(read_config_option('mirage_log_path') != '' && read_config_option('mirage_log_filename') != '' && read_config_option('mirage_log_type') != '') {
		$mirage_log_path = read_config_option('mirage_log_path');
		$mirage_log_filename = read_config_option('mirage_log_filename');
		//$log_filetype = read_config_option('mirage_log_type');
		$mirage_log = $mirage_log_path . $mirage_log_filename . $log_filetype;
	} else {
		// default if not set in settings
		$mirage_log = $config['base_path'] . '/log/mirage_poller_output.log';
	}
	
    /* manage mirage log file rotation */
	/*
	Example for $log_rotation_size = 5
		0 mirage.log  --> mirage.log1
		1 mirage.log1 --> mirage.log2
		2 mirage.log2 --> mirage.log3
		3 mirage.log3 --> mirage.log4
	*/ 
	if($log_rotation) {
		if(filesize($mirage_log)>$log_rotation_size) {
			for($i=$log_rotation_n-1 ; $i>=0; $i--) {
				if($i>0) {
					rename($mirage_log.'.'.$i,$mirage_log.'.'.($i+1));
				} else {
					rename($mirage_log,$mirage_log.'.'.($i+1));
				}
			}
		}
	}  

	/* loop through rrd_update_array */
	foreach($rrd_update_array as $rrd_file=>$rrd_data) {
        // new $filedata for each chuck of rrd_data (equivalent to rrd file)
		$filedata='';
		$local_data_id = $rrd_data['local_data_id'];
		foreach($rrd_data['times'] as $time=>$values) {
            //for each $time there are multiple value updates.  $time is epoch
			foreach($values as $rrd_name=>$rrd_value) {
                //excluding RRD filename
				//$filedata .= 'rrd="'.$rrd_file.'" ';
				$filedata .= 'local_data_id="'.$local_data_id.'" ';
				$filedata .= 'time="'.$time.'" ';
				$filedata .= 'rrd_name="'.$rrd_name.'" ';
                //finalize each line and get ready for the next RRD update line
				$filedata .= 'rrd_value="'.$rrd_value."\"\n";
			}
		}
		file_put_contents($mirage_log,$filedata,FILE_APPEND);
	}
	
    // Orignal code to generate mirror table in mysql.  Removed for file updating
	/* Copy values from rrd_update_array into mirage_data TABLE*/
	//file_put_contents("/tmp/cacti","output=".$m_output.",time=".$m_time.",local_data_id=".$m_local_data_id.",rrd_path=\"".$m_rrd_path."\",rrdname=\"".$m_rrd_name."\",rrd_num=".$m_rrd_num."\n",FILE_APPEND);
	/*if(is_numeric($m_output) {
		$sql_insert = 
			"INSERT INTO mirage_data (output, time, local_data_id, rrd_path, rrd_name, rrd_num)
			 VALUES (".$m_output.",".$m_time.",".$_local_data_id.",'".$m_rrd_path."','".$m_rrd_name."','".$m_rrd_num."')";
		db_execute($sql_insert);
	}*/
	
	return $rrd_update_array;
}

?>
