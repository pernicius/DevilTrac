<?php
require_once(dirname(__FILE__) . '/../simpletest/autorun.php');


require_once(dirname(__FILE__) . '/../../core/includes/class.classloader.php');


class Test_CoreClass_ClassLoader extends UnitTestCase
{
	function __construct() {
		parent::__construct();
	}

	function setUp() {
	}

	function tearDown() {
	}
	
	// ---------- invalid args
	
/*
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
*/
	
	// ---------- static class
	
	function testStaticConstructor() {
		$this->expectException(); $test = new Timer();
	}
	
	// ---------- TODO
	
} // Test_CoreClass_ClassLoader


?>