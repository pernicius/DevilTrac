<?php
require_once(dirname(__FILE__) . '/../simpletest/autorun.php');


require_once(dirname(__FILE__) . '/../../core/includes/class.dbconfig.php');


class Test_CoreClass_DBConfig extends UnitTestCase
{
	function __construct() {
		parent::__construct();
	}

	function setUp() {
		DBConfig::$_configs = array();
	}

	function tearDown() {
		DBConfig::$_configs = array();
	}
	
	// ---------- invalid args
	
	function testInvalidArgs() {
		// no args
		$this->expectException(); $cfg = new DBConfig;
		// empty string
		$this->expectException(); $cfg = new DBConfig('');
		// empty array
		$this->expectException(); $cfg = new DBConfig(array());
		// nonexistent config
		$this->expectException(); $cfg = new DBConfig('foobar');
		// invalid object
		$this->expectException(); $cfg = new DBConfig(new Exception);
		// misc
		$this->expectException(); $cfg = new DBConfig(true);
		$this->expectException(); $cfg = new DBConfig(false);
		$this->expectException(); $cfg = new DBConfig(1);
		$this->expectException(); $cfg = new DBConfig(0);
		$this->expectException(); $cfg = new DBConfig(-1);
	}
	
	// ---------- creating configurations
	
	function testCreateDefault() {
		$cfg = array('name'=>'_default');
		$test = new DBConfig($cfg);
		$this->assertIdentical($test->_cfg, $cfg);
	}
	
	function testCreateNormal() {
		$cfg = array('name'=>'normal');
		$test = new DBConfig($cfg);
		$this->assertIdentical($test->_cfg, $cfg);
	}
	
	function testCreateExiting() {
		$cfg = array('name'=>'normal');
		$test = new DBConfig($cfg);
		
		$this->expectException();
		$test = new DBConfig($cfg);
	}
	
	function testCreateExitingOverride() {
		$cfg = array('name'=>'normal');
		$test = new DBConfig($cfg);
		
		$cfg = array('name'=>'normal', 'override'=>true);
		$test = new DBConfig($cfg);
		$this->assertIdentical($test->_cfg, $cfg);
	}
	
	// ---------- using configurations
	
	function testUseDefaultConfig() {
		// create empty '_default' config
		$dummy = new DBConfig(array('name'=>'_default'));
		// test
		$cfg = new DBConfig;
		$this->assertIdentical($cfg->_cfg, DBConfig::$_configs['_default']);
	}

	function testUseConfigByName() {
		// create empty 'test' config
		$dummy = new DBConfig(array('name'=>'test'));
		// test
		$cfg = new DBConfig('test');
		$this->assertIdentical($cfg->_cfg, DBConfig::$_configs['test']);
	}
	
	function testUseConfigByCloning() {
		// create empty 'test' config
		$dummy = new DBConfig(array('name'=>'test'));
		// test
		$cfg = new DBConfig($dummy);
		$this->assertIdentical($cfg->_cfg, $dummy->_cfg);
	}
	
} // Test_CoreClass_DBConfig


?>