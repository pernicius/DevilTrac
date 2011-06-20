<?php
require_once(dirname(__FILE__) . '/../simpletest/autorun.php');


require_once(dirname(__FILE__) . '/../../core/includes/class.dbconfig.php');


class Test_CoreClass_DBConfig extends UnitTestCase
{
	function __construct() {
		parent::__construct();
	}

	function setUp() {
		DBConfig::clear();
	}

	function tearDown() {
		DBConfig::clear();
	}
	
	// ---------- invalid args
	
	function testInvalidArgsOnGet() {
		// no args
		$this->expectException(); DBConfig::get();
		// empty string
		$this->expectException(); DBConfig::get('');
		// empty array
		$this->expectException(); DBConfig::get(array());
		// nonexistent config
		$this->expectException(); DBConfig::get('foobar');
		// misc
		$this->expectException(); DBConfig::get(true);
		$this->expectException(); DBConfig::get(false);
		$this->expectException(); DBConfig::get(1);
		$this->expectException(); DBConfig::get(0);
		$this->expectException(); DBConfig::get(-1);
	}
	
	function testInvalidArgsOnSet() {
		// no args
//		$this->expectException(); DBConfig::set();
		// empty string
		$this->expectException(); DBConfig::set('');
		// empty array
		$this->expectException(); DBConfig::set(array());
		// misc
		$this->expectException(); DBConfig::set(true);
		$this->expectException(); DBConfig::set(false);
		$this->expectException(); DBConfig::set(1);
		$this->expectException(); DBConfig::set(0);
		$this->expectException(); DBConfig::set(-1);
	}
	
	function testInvalidArgsOnClear() {
		// empty string
		$this->expectException(); DBConfig::clear('');
		// misc
		$this->expectException(); DBConfig::clear(array());
		$this->expectException(); DBConfig::clear(true);
		$this->expectException(); DBConfig::clear(false);
		$this->expectException(); DBConfig::clear(1);
		$this->expectException(); DBConfig::clear(0);
		$this->expectException(); DBConfig::clear(-1);
	}
	
	// ---------- static class
	
	function testStaticConstructor() {
		$this->expectException(); $test = new DBConfig();
	}
	
	// ---------- creating configurations
	
	function testCreateDefault() {
		$cfg = array('name'=>'_default');
		DBConfig::set($cfg);
		$res = DBConfig::get();
		$this->assertIdentical($res, $cfg);
	}
	
	function testCreateNormal() {
		$cfg = array('name'=>'normal');
		DBConfig::set($cfg);
		$res = DBConfig::get('normal');
		$this->assertIdentical($res, $cfg);
	}
	
	function testCreateExisting() {
		$cfg = array('name'=>'normal');
		DBConfig::set($cfg);
		
		$this->expectException();
		DBConfig::set($cfg);
	}
	
	function testCreateExistingOverride() {
		$cfg = array('name'=>'normal');
		DBConfig::set($cfg);
		
		$cfg = array('name'=>'normal', 'override'=>true);
		DBConfig::set($cfg);
		$res = DBConfig::get('normal');
		$this->assertIdentical($res, $cfg);
	}
	
	// ---------- requesting configurations
	
	function testGetDefault() {
		// create empty '_default' config
		$cfg = array('name'=>'_default');
		DBConfig::set($cfg);
		// test
		$res = DBConfig::get();
		$this->assertIdentical($res, $cfg);
	}

	function testGetByName() {
		// create empty 'test' config
		$cfg = array('name'=>'test');
		DBConfig::set($cfg);
		// test
		$res = DBConfig::get('test');
		$this->assertIdentical($res, $cfg);
	}
	
	// ---------- clear configurations
	
	function testClearByName() {
		// create dummy configs
		DBConfig::set(array('name'=>'foo'));
		DBConfig::set(array('name'=>'bar'));
		// test
		DBConfig::clear('foo');
		$this->expectException();
		DBConfig::get('foo');
		$this->assertIsA(DBConfig::get('bar'), 'array');
	}
	
	function testClearAll() {
		// create dummy configs
		DBConfig::set(array('name'=>'foo'));
		DBConfig::set(array('name'=>'bar'));
		// test
		DBConfig::clear();
		$this->expectException();
		DBConfig::get('foo');
		$this->expectException();
		DBConfig::get('bar');
	}
	
} // Test_CoreClass_DBConfig


?>