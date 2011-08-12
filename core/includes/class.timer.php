<?php
/**
 * page level docblock
 * 
 * @package DevilTrac
 * @subpackage Core-Classes
 */


/**
 * class Timer
 */
class Timer
{
	/**
	 * internal start/stop commands
	 */
	const START	= 0;
	const STOP	= 1;
	
	/**
	 * format id's
	 */
	const SECONDS	= 0;
	const MSEC		= 1;
	const USEC		= 2;
	
	/**
	 * timer storage
	 */
//	protected static $_timer = array();
static $_timer = array();
	
	/**
	 * dummy contructor
	 */
	public function __construct() {
		throw new Exception(get_class($this) . ': this class may only be invoked statically.');
	} // __construct()
	
	/**
	 * Start a new timer.
	 * @param string $id
	 */
	public static function start($id = '_default') {
		self::pushTime($id, Timer::START);
	} // start()
	
	/**
	 * Stop a running timer.
	 * @param string $id
	 */
	public static function stop($id = '_default') {
		self::pushTime($id, Timer::STOP);
	} // stop()
	
	/**
	 * Remove a timer.
	 * @param string $id
	 */
	public static function reset($id = '_default') {
		if(isset(self::$_timer[$id]))
			unset(self::$_timer[$id]);
	} // reset()
	
	/**
	 * Return the formatted timer value.
	 * @param mixed $p1
	 * @param mixed $p2
	 * @return mixed
	 */
	public static function get($p1 = null, $p2 = null) {
		$id = '_default';
		if (is_string($p1)) $id = $p1;
		if (is_string($p2)) $id = $p2;
		$format = self::SECONDS;
		if (is_int($p1)) $format = $p1;
		if (is_int($p2)) $format = $p2;
		
		// param check
		// TODO
		
		// error handling
		// TODO
		
		// stop timer if not done yet
		if (isset(self::$_timer[$id]['running']))
			self::stop($id);
		
		// sum all timer values
		$time = 0.0;
		foreach(self::$_timer[$id] as $entry) {
			$time += $entry[self::STOP] - $entry[self::START];
		}
		
		// return formatted value
		switch($format) {
			case self::MSEC:
				return (int)($time * 1000);
			case self::USEC:
				return (int)($time * 1000000);
			default:
				return $time;
		}
	} // get()
	
	/**
	 * Store a timer value.
	 * @param string $id
	 * @param int $cmd
	 */
	protected static function pushTime($id, $cmd) {
		// save early time
		$mt_stop = microtime(true);
		
		// param check
		// TODO
		
		// error handling
		// TODO
		
		// create timerstorage
		if (!isset(self::$_timer[$id]))
			self::$_timer[$id] = array();
		
		// start new timer
		if ($cmd == self::START) {
			self::$_timer[$id]['running'] = true;
			self::$_timer[$id][] = array($cmd => microtime(true));
			return;
		}
		
		// stop timer
		if ($cmd == self::STOP) {
			unset(self::$_timer[$id]['running']);
			$count = count(self::$_timer[$id]);
			self::$_timer[$id][$count-1] = array_merge(
				self::$_timer[$id][$count-1],
				array($cmd => $mt_stop)
			);
			return;
		}
	} // pushTime()
	
}


?>