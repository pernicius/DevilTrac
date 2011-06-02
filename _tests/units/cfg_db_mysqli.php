<?php


require_once(dirname(__FILE__) . '/../../core/includes/class.dbconfig.php');


function DBSetupTestConfig_mysqli() {
	$cfg = new DBConfig(array(
		'name'	=> 'testconfig',
		'type'	=> 'mysqli',
	
		'host'	=> 'localhost',
		'db'	=> 'testdb',
		'user'	=> 'testuser',
		'pass'	=> 'testpass',
		
		'override' => true
	));
}


?>