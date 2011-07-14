<?php
require_once(dirname(__FILE__) . '/../simpletest/autorun.php');


class Suite_CoreClasses_DB_mysqli extends TestSuite
{
	function __construct() {
		parent::__construct();
		
		$this->addFile(dirname(__FILE__) . '/core_class_dbconnection_mysqli.php');
	}
}


?>