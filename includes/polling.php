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
    $time_start = microtime(true);
    
    // Get Mirage Method
    $mirage_log_type = read_config_option('mirage_log_type');
    if($mirage_log_type=='') $mirage_log_type='kv';
    cacti_log("[mirage] output method: ".$mirage_log_type);

    // Execute Mirage Method
    if($mirage_log_type == 'kv') {
        mirage_kv_output($rrd_update_array);
    }

    // End Mirage and log performance
    $time_end = microtime(true);
    $time = $time_end - $time_start;
    cacti_log("[mirage] processing completed in ".round($time,3)." seconds");
    return $rrd_update_array;
}

function mirage_kv_output(&$rrd_update_array) {
    $count_updates_processed = 0;
	// Fetch Mirage configuration options relevant to KV output
    $mirage_rotation = read_config_option('mirage_rotation');
    $mirage_rotation_size = read_config_option('mirage_rotation_size');
    $mirage_rotation_files = read_config_option('mirage_rotation_files');
    $mirage_log_path = read_config_option('mirage_log_path');
    $mirage_log_filename = read_config_option('mirage_log_filename');

    // Is log file rotation enabled?
	if($mirage_rotation == 'on' || $mirage_rotation == '') {
        $mirage_rotation = true;
        cacti_log("[mirage] mirage_rotation=on");
    } else {
        $mirage_rotation = false;
        cacti_log("[mirage] mirage_rotation=off");
    }

    // Set log file rotation defaults (only relevant if enabled)
    if($mirage_rotation_size=='') $mirage_rotation_size=104857600;
    if($mirage_rotation_files=='') $mirage_rotation_files=5;
    if($mirage_rotation) cacti_log("[mirage] rotation size=$mirage_rotation_size files=$mirage_rotation_files");
    
    // Set log file defaults
    if($mirage_log_path=='') $mirage_log_path=$config['base_path'] . '/log/';
    if(substr($mirage_log_path,-1)!='/') $mirage_log_path .= '/';
    if($mirage_log_filename=='') $mirage_log_filename='mirage_poller_output.log';

    //check if path is available
    if(file_exists($mirage_log_path)) {
        cacti_log("[mirage] [ERROR] path does not exist: $mirage_log_path");
    } else {
        if(mkdir($mirage_log_path,0770,true)) {
            cacti_log("[mirage] [WARNING] created new path: $mirage_log_path");
        } else {
            cacti_log("[mirage] [ERROR] failed to create log path: $mirage_log_path");
            return;
        }
    }

    // Set log file name
    $mirage_log = $mirage_log_path.$mirage_log_filename;
    cacti_log("[mirage] logfile='$mirage_log'");
    if(!touch($mirage_log)) {
        cacti_log("[mirage] [ERROR] failed to write to log file: $mirage_log");
        return;
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
                $count_updates_processed++;
			}
		}
		file_put_contents($mirage_log,$filedata,FILE_APPEND);
	}
	cacti_log("[mirage] kv output processed $count_updates_processed updates");
	return $rrd_update_array;
}

function mirage_sql_output(&$rrd_update_array) {
    //TODO: not implemented
    /* Copy values from rrd_update_array into mirage_data TABLE*/
    /*if(is_numeric($m_output) {
        $sql_insert = 
        "INSERT INTO mirage_data (output, time, local_data_id, rrd_path, rrd_name, rrd_num)
         VALUES (".$m_output.",".$m_time.",".$_local_data_id.",'".$m_rrd_path."','".$m_rrd_name."','".$m_rrd_num."')";
        db_execute($sql_insert);
    }*/
}

?>
