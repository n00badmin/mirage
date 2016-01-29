# mirage
Mirage is a Cacti plugin designed to mirror SNMP polling data to file, prior to writting RRD files.

Default destination for log files is **CACTI_HOME/log/mirage.log**

##Current Release
 * Version 1.2.0 

##Purpose
 * To enable Cacti Users to export their polling data into other systems prior to writing RRD files.

##Features
 * Mirror poller collection to logfile
 * Custom output log path
 * Output poller data in KV pairs (key-value pairs)
 * Enable logfile rotation
 * Enable Mirage Debug logs (writes to cacti.log)

##Prerequisites
 * Cacti version 0.8.8+ [It may work on previous versions, but we haven't tested against them.]
 * PIA version 3.1

##Installation
 * Untar plugin file into **CACTI_HOME/plugins/**
 * Ensure permission are correct (**CACTI_HOME/plugins/mirage**)
 * Install Mirage through Cacti Plugin Management
 * Review and save Mirage settings
 * Enable Mirage pluging through Cacti Plugin Management

##Usage
 * Once Mirage plugin is enabled, you can retrieve the polling logs in the configured Mirage Output Path/Filename.
 * ie: **CACTI_HOME/log/**

##Additional Help?
 * Feel free to submit any question on the Git.

##Possible Bugs?
 * Feel free to submit any bug related issue on the Git.

## Copyright
Copyright 2016 Matthew Modestino, Philippe Tang, Menno Vanderlist
