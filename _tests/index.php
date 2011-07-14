<?php
require_once(dirname(__FILE__) . '/simpletest/autorun.php');


class FullTestSuite extends TestSuite
{
	function __construct() {
		parent::__construct();
		
		$this->addFile(dirname(__FILE__) . '/core_classes.php');
	}
}


?>