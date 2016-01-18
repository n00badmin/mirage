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
    $mirage_log = $config['base_path'] . '/log/mirage.log';

    /* manage mirage log file rotation */
    if(filesize($mirage_log)>104857600) {
        rename($mirage_log . '.3',$mirage_log .'.4');
        rename($mirage_log . '.2',$mirage_log .'.3');
        rename($mirage_log . '.1',$mirage_log .'.2');
        rename($mirage_log,$mirage_log .'.1');
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
