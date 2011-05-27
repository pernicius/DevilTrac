<?php
require_once(dirname(__FILE__) . '/../simpletest/autorun.php');


require_once(dirname(__FILE__) . '/../../core/includes/class.dbconfig.php');


class Test_CoreClass_DBConfig extends UnitTestCase {
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
	
	function testNoConfigsNoArgs() {
		$this->expectException();
		$cfg = new DBConfig;
	}
	
	// TODO: ...
	// TODO: ...
	// TODO: ...
	
	// ---------- creating configurations
	
	// TODO: ...
	// TODO: ...
	// TODO: ...
	
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
	
	function testConfigCloning() {
		// create empty 'test' config
		$dummy = new DBConfig(array('name'=>'test'));
		// test
		$cfg = new DBConfig($dummy);
		$this->assertIdentical($cfg->_cfg, $dummy->_cfg);
	}
}
?>