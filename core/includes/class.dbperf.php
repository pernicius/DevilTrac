<?php
/**
 * page level docblock
 * 
 * @package DevilTrac
 * @subpackage Core-Classes-Database
 */


/**
 * class DBPerf
 * 
 * DB performance storage.
 */
class DBPerf
{
	/**
	 * global performance storage
	 */
	protected static $_perf = array();
	
	/**
	 * dummy contructor
	 */
	public function __construct() {
		throw new Exception(get_class($this) . ': this class may only be invoked statically.');
	} // __construct()
	
	/**
	 * Return the count of all (uncached) result fetches performed.
	 * @param string $config
	 * @param bool $increase
	 * @return int
	 */
	static function fetchCount($config, $increase = false) {
		if (!is_string($config))
			throw new Exception(get_class() . ': wrong param type.');
		if (!is_bool($increase))
			throw new Exception(get_class() . ': wrong param type.');
		if (!isset(self::$_perf[$config]))
			self::$_perf[$config] = array();
		if (!isset(self::$_perf[$config]['fc']))
			self::$_perf[$config]['fc'] = 0;
		if ($increase) {
			self::$_perf[$config]['fc']++;
			self::fetchTotalCount($config, true);
		}
		return self::$_perf[$config]['fc'];
	} // fetchCount()
	
	/**
	 * Return the count of all (cached) result fetches performed.
	 * @param string $config
	 * @param bool $increase
	 * @return int
	 */
	static function fetchCachedCount($config, $increase = false) {
		if (!is_string($config))
			throw new Exception(get_class() . ': wrong param type.');
		if (!is_bool($increase))
			throw new Exception(get_class() . ': wrong param type.');
		if (!isset(self::$_perf[$config]))
			self::$_perf[$config] = array();
		if (!isset(self::$_perf[$config]['fcc']))
			self::$_perf[$config]['fcc'] = 0;
		if ($increase) {
			self::$_perf[$config]['fcc']++;
			self::fetchTotalCount($config, true);
		}
		return self::$_perf[$config]['fcc'];
	} // fetchCachedCount()
	
	/**
	 * Return the count of all (cached and uncached) result fetches performed.
	 * @param string $config
	 * @param bool $increase
	 * @return int
	 */
	static function fetchTotalCount($config, $increase = false) {
		if (!is_string($config))
			throw new Exception(get_class() . ': wrong param type.');
		if (!is_bool($increase))
			throw new Exception(get_class() . ': wrong param type.');
		if (!isset(self::$_perf[$config]))
			self::$_perf[$config] = array();
		if (!isset(self::$_perf[$config]['ftc']))
			self::$_perf[$config]['ftc'] = 0;
		if ($increase)
			self::$_perf[$config]['ftc']++;
		return self::$_perf[$config]['ftc'];
	} // fetchTotalCount()
	
	/**
	 * Return the count of all (uncached) queries performed.
	 * @param string $config
	 * @param bool $increase
	 * @return int
	 */
	static function queryCount($config, $increase = false) {
		if (!is_string($config))
			throw new Exception(get_class() . ': wrong param type.');
		if (!is_bool($increase))
			throw new Exception(get_class() . ': wrong param type.');
		if (!isset(self::$_perf[$config]))
			self::$_perf[$config] = array();
		if (!isset(self::$_perf[$config]['qc']))
			self::$_perf[$config]['qc'] = 0;
		if ($increase) {
			self::$_perf[$config]['qc']++;
			self::queryTotalCount($config, true);
		}
		return self::$_perf[$config]['qc'];
	} // queryCount()
		
	/**
	 * Return the count of all (cached) queries performed.
	 * @param string $config
	 * @param bool $increase
	 * @return int
	 */
	static function queryCachedCount($config, $increase = false) {
		if (!is_string($config))
			throw new Exception(get_class() . ': wrong param type.');
		if (!is_bool($increase))
			throw new Exception(get_class() . ': wrong param type.');
		if (!isset(self::$_perf[$config]))
			self::$_perf[$config] = array();
		if (!isset(self::$_perf[$config]['qcc']))
			self::$_perf[$config]['qcc'] = 0;
		if ($increase) {
			self::$_perf[$config]['qcc']++;
			self::queryTotalCount($config, true);
		}
		return self::$_perf[$config]['qcc'];
	} // queryCachedCount()
	
	/**
	 * Return the count of all (cached and uncached) queries performed.
	 * @param string $config
	 * @param bool $increase
	 * @return int
	 */
	static function queryTotalCount($config, $increase = false) {
		if (!is_string($config))
			throw new Exception(get_class() . ': wrong param type.');
		if (!is_bool($increase))
			throw new Exception(get_class() . ': wrong param type.');
		if (!isset(self::$_perf[$config]))
			self::$_perf[$config] = array();
		if (!isset(self::$_perf[$config]['qtc']))
			self::$_perf[$config]['qtc'] = 0;
		if ($increase)
			self::$_perf[$config]['qtc']++;
		return self::$_perf[$config]['qtc'];
	} // queryTotalCount()
	
	/**
	 * Return the execution time of the last query.
	 * @param string $config
	 * @param int $time2add
	 * @return int
	 */
	static function execTime($config, $time2add = 0) {
		if (!is_string($config))
			throw new Exception(get_class() . ': wrong param type.');
		if (!is_int($time2add))
			throw new Exception(get_class() . ': wrong param type.');
		if (!isset(self::$_perf[$config]))
			self::$_perf[$config] = array();
		if (!isset(self::$_perf[$config]['et']))
			self::$_perf[$config]['et'] = 0;
		if ($time2add > 0) {
			self::$_perf[$config]['et'] = $time2add;
			self::execTotalTime($config, $time2add);
		}
		return self::$_perf[$config]['et'];
	} // execTime()
		
	/**
	 * Return the execution time of all queries.
	 * @param string $config
	 * @param int $time2add
	 * @return int
	 */
	static function execTotalTime($config, $time2add = 0) {
		if (!is_string($config))
			throw new Exception(get_class() . ': wrong param type.');
		if (!is_int($time2add))
			throw new Exception(get_class() . ': wrong param type.');
		if (!isset(self::$_perf[$config]))
			self::$_perf[$config] = array();
		if (!isset(self::$_perf[$config]['ett']))
			self::$_perf[$config]['ett'] = 0;
		self::$_perf[$config]['ett'] += $time2add;
		return self::$_perf[$config]['ett'];
	} // execTotalTime()
	
}


?>