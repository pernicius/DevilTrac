<?php
require_once(dirname(__FILE__) . '/../simpletest/autorun.php');


require_once(dirname(__FILE__) . '/cfg_db_mysqli.php');
require_once(dirname(__FILE__) . '/../../core/includes/class.dbconfig.php');
require_once(dirname(__FILE__) . '/../../core/includes/class.dbconnection_mysqli.php');


class Test_CoreClass_DBConnection_mysqli extends UnitTestCase
{
	function __construct() {
		parent::__construct();
	}

	function setUp() {
		DBSetupTestConfig_mysqli();
	}

	function tearDown() {
	}
	
	function testServerSupport() {
		// extension check...
		$this->skipIf(!extension_loaded('mysqli'), 'Extension not Supported!');
	}
	
	function testConnectOnConstruction() {
		$test = new DBConnection_mysqli('testconfig');
		$this->assertTrue(is_object($test->_conn));
	}
	
	function testClose() {
		$test = new DBConnection_mysqli('testconfig');
		$this->assertTrue($test->close());
		$this->assertTrue(is_null($test->_conn));
	}
	
	function testConnectAfterClose() {
		$test = new DBConnection_mysqli('testconfig');
		$test->close();
		$this->assertTrue($test->connect());
	}
	
	function testReconnect() {
		$test = new DBConnection_mysqli('testconfig');
		$test->close();
		$this->assertTrue($test->reconnect());
	}
	
}


?>