<?php
/**
 * page level docblock
 * 
 * @package DevilTrac
 * @subpackage Core-Classes-Database
 */


require_once(dirname(__FILE__) . '/class.dbconfig.php');


/**
 * class DBFactory
 * 
 * Class factory for (mostly) all DBQuery classes.
 */
class DBFactory
{
	/**
	 * dummy contructor
	 */
	public function __construct() {
		throw new Exception(get_class($this) . ': this class may only be invoked statically.');
	} // __construct()
	
	/**
	 * Return the DBQuery object.
	 * @param string $config
	 * @return object
	 */
	public static function get($config = DBConfig::CONFIG_DEFAULT) {
		$dbtype = strtolower(DBConfig::getParam($config, 'type'));
		$is_cached = DBConfig::getParam($config, 'cached', false);
		$is_prepared = DBConfig::getParam($config, 'prepared', false);
		// check config params
		if (empty($dbtype))
			throw new Exception(get_class() . ': DB type not found.');
		if ($is_cached && $is_prepared)
			throw new Exception(get_class() . ': cached prepared connections not supported.');
		// create DBQuery object
		if ($is_cached) {
			$classname = 'DBQueryCached_'.$dbtype;
		} elseif ($is_prepared) {
			$classname = 'DBQueryPrepared_'.$dbtype;
		} else {
			$classname = 'DBQueryNormal_'.$dbtype;
		}
		return new $classname($config);
	}
	
} // DBFactory


?>