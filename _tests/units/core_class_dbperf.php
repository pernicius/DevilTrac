<?php
require_once(dirname(__FILE__) . '/../simpletest/autorun.php');


require_once(dirname(__FILE__) . '/../../core/includes/class.dbperf.php');


class Test_CoreClass_DBPerf extends UnitTestCase
{
	function __construct() {
		parent::__construct();
	}

	function setUp() {
	}

	function tearDown() {
	}
	
	// ---------- invalid args
	
	function testInvalidArgsOnFetchCount() {
		// p1
		$this->expectException(); DBPerf::fetchCount('');
		$this->expectException(); DBPerf::fetchCount(array());
		$this->expectException(); DBPerf::fetchCount(true);
		$this->expectException(); DBPerf::fetchCount(false);
		$this->expectException(); DBPerf::fetchCount(1);
		$this->expectException(); DBPerf::fetchCount(0);
		$this->expectException(); DBPerf::fetchCount(-1);
		// p2
		$this->expectException(); DBPerf::fetchCount('test', '');
		$this->expectException(); DBPerf::fetchCount('test', array());
		$this->expectException(); DBPerf::fetchCount('test', -1);
	}
	
	// TODO
	// TODO
	// TODO
	
	// ---------- static class
	
	function testStaticConstructor() {
		$this->expectException(); $test = new DBPerf();
	}
	
	// ---------- counter
	
	function testIncrementFetchCount() {
		$x1 = DBPerf::fetchCount('test');
		$x2 = DBPerf::fetchCount('test');
		$this->assertEqual($x1, $x2);
		$x3 = DBPerf::fetchCount('test', true);
		$this->assertEqual($x3, DBPerf::fetchCount('test'));
	}
	
	// TODO
	// TODO
	// TODO
	
} // Test_CoreClass_DBPerf


?>