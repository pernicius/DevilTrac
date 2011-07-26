<?php


require_once(dirname(__FILE__) . '/../../core/includes/class.dbconfig.php');
require_once(dirname(__FILE__) . '/../../core/includes/class.dbperf.php');
require_once(dirname(__FILE__) . '/../../core/includes/class.dbconnection_mysqli.php');
require_once(dirname(__FILE__) . '/../../core/includes/class.dbquerynormal_mysqli.php');


function DBSetupTestConfig_mysqli() {
	DBConfig::set(array(
		'name'	=> 'testconfig',
		'type'	=> 'mysqli',
	
		'host'	=> 'localhost',
		'db'	=> 'testdb',
		'user'	=> 'testuser',
		'pass'	=> 'testpass',
		
		'override' => true
	));
}


function DBSetupDefaultConfig_mysqli() {
	DBConfig::set(array(
		'name'	=> DBConfig::CONFIG_DEFAULT,
		'type'	=> 'mysqli',
	
		'host'	=> 'localhost',
		'db'	=> 'testdb',
		'user'	=> 'testuser',
		'pass'	=> 'testpass',
		
		'override' => true
	));
}


function DBSetupTestConfig_mysqli_persistent() {
	DBConfig::set(array(
		'name'	=> 'testconfig',
		'type'	=> 'mysqli',
	
		'host'	=> 'localhost',
		'db'	=> 'testdb',
		'user'	=> 'testuser',
		'pass'	=> 'testpass',
		
		'override'		=> true,
		'persistent'	=> true
	));
}


?>