<?php
require_once(dirname(__FILE__) . '/../simpletest/autorun.php');


class Suite_CoreClasses extends TestSuite
{
	function __construct() {
		parent::__construct();
		
		$this->addFile(dirname(__FILE__) . '/units/core_class_dbconfig.php');
	}
}


?>