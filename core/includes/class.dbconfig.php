<?php
/**
 * page level docblock
 * 
 * @package DevilTrac
 * @subpackage Core-Classes-Database
 */


/**
 * class DBConfig
 * 
 * The base class for (mostly) all DB classes.
 * Some configuration names are reserved:
 *  - "_default"  this one is used if none is spezified
 *  - "_global"   this is an incomplete set with global parameters
 */
class DBConfig
{
	/**
	 * configuration used if none is spezified
	 */
	const CONFIG_DEFAULT = "_default";
	
	/**
	 * configuration used for global parameters
	 */
	const CONFIG_GLOBAL = "_global";
	
	/**
	 * global config storrage
	 */
	protected static $_configs = array();
	
	/**
	 * dummy contructor
	 */
	public function __construct() {
		throw new Exception(get_class($this) . ': this class may only be invoked statically.');
	} // __construct()
	
	/**
	 * setup a new configuration
	 * @param array $config
	 */
	public static function set($config) {
		// param check
		if (!is_array($config))
			throw new Exception(get_class() . ': wrong param type.');
		if (!isset($config['name']))
			throw new Exception(get_class() . ': missing configuration name.');
		if (isset(self::$_configs[$config['name']]) && (!isset($config['override']) || $config['override'] != true))
			throw new Exception(get_class() . ': configuration (named:\'' . $config['name'] . '\') already exists.');
		// TODO: more checks based on type
		// store as new config
		self::$_configs[$config['name']] = $config;
	} // set()
	
	/**
	 * set/update a single parameter in a configuration
	 * @param string $config
	 * @param string $key
	 * @param mixed $value
	 */
	public static function setParam($config = self::CONFIG_DEFAULT, $key, $value) {
		// param check
		if (!is_string($config))
			throw new Exception(get_class() . ': wrong param type.');
		if (!is_string($key))
			throw new Exception(get_class() . ': wrong param type.');
		if (!isset($value))
			throw new Exception(get_class() . ': wrong param type.');
		// create new configuration if requested doesn't exits
		if (!isset(self::$_configs[$config]))
			self::set(array('name' => $config));
		// update the parameter
		self::$_configs[$config][$key] = $value;
	}
	
	/**
	 * request a configuration
	 * @param string $config
	 * @return array
	 */
	public static function get($config = self::CONFIG_DEFAULT) {
		// param check
		if (!is_string($config))
			throw new Exception(get_class() . ': wrong param type.');
		if (!isset(self::$_configs[$config]))
			throw new Exception(get_class() . ': requested configuration (named:\'' . $config . '\') not found.');
		// return requested config
		return self::$_configs[$config];
	} // get()
	
	/**
	 * get a single parameter in a configuration
	 * @param string $config
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	public static function getParam($config = self::CONFIG_DEFAULT, $key, $default = null) {
		// param check
		if (!is_string($config))
			throw new Exception(get_class() . ': wrong param type.');
		if (!is_string($key))
			throw new Exception(get_class() . ': wrong param type.');
		// return requested param if exists
		if (!isset(self::$_configs[$config]))
			return $default;
		if (!isset(self::$_configs[$config][$key]))
			return $default;
		return self::$_configs[$config][$key];
	}
	
	/**
	 * clear the requested or all configurations
	 * @param string|null $config
	 */
	public static function clear($config = null) {
		// param check
		if (isset($config) && !is_string($config))
			throw new Exception(get_class() . ': wrong param type.');
		// clear all configs
		if (!isset($config)) {
			self::$_configs = array();
			return;
		}
		// clear spezific config
		if (is_string($config) && isset(self::$_configs[$config])) {
			unset(self::$_configs[$config]);
			return;
		}
		// config not found
		throw new Exception(get_class() . ': requested configuration (named:\'' . $config . '\') not found.');
	} // clear()
	
} // class DBConfig
