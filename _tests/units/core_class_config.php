<?php
require_once(dirname(__FILE__) . '/../simpletest/autorun.php');


require_once(dirname(__FILE__) . '/cfg_db_mysqli.php');
require_once(dirname(__FILE__) . '/../../core/includes/class.config.php');


class Test_CoreClass_Config extends UnitTestCase
{
	function __construct() {
		parent::__construct();
	}

	function setUp() {
		DBSetupDefaultConfig_mysqli();
	}

	function tearDown() {
		DBConfig::clear();
	}
	
	// ---------- invalid args
	
	function testInvalidArgsOnLoad() {
		// empty string
		$this->expectException(); Config::load('');
		// empty array
		$this->expectException(); Config::load(array());
		// misc
		$this->expectException(); Config::load(true);
		$this->expectException(); Config::load(false);
		$this->expectException(); Config::load(1);
		$this->expectException(); Config::load(0);
		$this->expectException(); Config::load(-1);
	}
	
	function testInvalidArgsOnUnload() {
		// empty string
		$this->expectException(); Config::unload('');
		// empty array
		$this->expectException(); Config::unload(array());
		// misc
		$this->expectException(); Config::unload(true);
		$this->expectException(); Config::unload(false);
		$this->expectException(); Config::unload(1);
		$this->expectException(); Config::unload(0);
		$this->expectException(); Config::unload(-1);
	}
	
	function testInvalidArgsOnSetprofile() {
		// empty string
		$this->expectException(); Config::setProfile('');
		// empty array
		$this->expectException(); Config::setProfile(array());
		// misc
		$this->expectException(); Config::setProfile(true);
		$this->expectException(); Config::setProfile(false);
		$this->expectException(); Config::setProfile(1);
		$this->expectException(); Config::setProfile(0);
		$this->expectException(); Config::setProfile(-1);
	}
	
	function testInvalidArgsOnSet() {
		// empty string
		$this->expectException(); Config::set('', 1);
		// empty array
		$this->expectException(); Config::set(array(), 1);
		// misc
		$this->expectException(); Config::set(true, 1);
		$this->expectException(); Config::set(false, 1);
		$this->expectException(); Config::set(1, 1);
		$this->expectException(); Config::set(0, 1);
		$this->expectException(); Config::set(-1, 1);
	}
	
	function testInvalidArgsOnGet() {
		// empty string
		$this->expectException(); Config::get('');
		// empty array
		$this->expectException(); Config::get(array());
		// misc
		$this->expectException(); Config::get(true);
		$this->expectException(); Config::get(false);
		$this->expectException(); Config::get(1);
		$this->expectException(); Config::get(0);
		$this->expectException(); Config::get(-1);
	}
	
	function testInvalidArgsOnDel() {
		// empty string
		$this->expectException(); Config::del('');
		// empty array
		$this->expectException(); Config::del(array());
		// misc
		$this->expectException(); Config::del(true);
		$this->expectException(); Config::del(false);
		$this->expectException(); Config::del(1);
		$this->expectException(); Config::del(0);
		$this->expectException(); Config::del(-1);
	}
	
	// ---------- static class
	
	function testStaticConstructor() {
		$this->expectException(); $test = new Config();
	}
	
	// ---------- TODO
	
} // Test_CoreClass_Config


?>