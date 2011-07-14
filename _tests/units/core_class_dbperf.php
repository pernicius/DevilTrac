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
		$this->expectException(); DBPerf::fetchCount(1);
		$this->expectException(); DBPerf::fetchCount(0);
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
		$y1 = DBPerf::fetchTotalCount('test');
		$y2 = DBPerf::fetchTotalCount('test');
		$this->assertEqual($y1, $y2);
		
		$x1 = DBPerf::fetchCount('test');
		$x2 = DBPerf::fetchCount('test');
		$this->assertEqual($x1, $x2);
		$x3 = DBPerf::fetchCount('test', true);
		$this->assertEqual($x3, DBPerf::fetchCount('test'));
		
		$x4 = DBPerf::fetchCachedCount('test');
		$x5 = DBPerf::fetchCachedCount('test');
		$this->assertEqual($x4, $x5);
		$x6 = DBPerf::fetchCachedCount('test', true);
		$this->assertEqual($x6, DBPerf::fetchCachedCount('test'));
		
		$this->assertEqual($y1 + 2, DBPerf::fetchTotalCount('test'));
	}
	
	function testIncrementQueryCount() {
		$y1 = DBPerf::queryTotalCount('test');
		$y2 = DBPerf::queryTotalCount('test');
		$this->assertEqual($y1, $y2);
		
		$x1 = DBPerf::queryCount('test');
		$x2 = DBPerf::queryCount('test');
		$this->assertEqual($x1, $x2);
		$x3 = DBPerf::queryCount('test', true);
		$this->assertEqual($x3, DBPerf::queryCount('test'));
		
		$x4 = DBPerf::queryCachedCount('test');
		$x5 = DBPerf::queryCachedCount('test');
		$this->assertEqual($x4, $x5);
		$x6 = DBPerf::queryCachedCount('test', true);
		$this->assertEqual($x6, DBPerf::queryCachedCount('test'));
		
		$this->assertEqual($y1 + 2, DBPerf::queryTotalCount('test'));
	}
	
	function testIncrementTimeCount() {
		$y1 = DBPerf::execTotalTime('test');
		$y2 = DBPerf::execTotalTime('test');
		$this->assertEqual($y1, $y2);
		
		$x1 = DBPerf::execTime('test');
		$x2 = DBPerf::execTime('test');
		$this->assertEqual($x1, $x2);
		$x3 = DBPerf::execTime('test', 10);
		$this->assertEqual($x3, DBPerf::execTime('test'));
		
		$this->assertEqual($y1 + 10, DBPerf::execTotalTime('test'));
	}
	
} // Test_CoreClass_DBPerf


?>