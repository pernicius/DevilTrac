<?php
/**
 * page level docblock
 * 
 * @package DevilTrac
 * @subpackage Core-Classes
 */


require_once(dirname(__FILE__) . '/class.dbfactory.php');


/**
 * class Config
 */
class Config
{
	protected static $_loaded = array();
	protected static $_cache = array();
	protected static $_profile;
	
	/**
	 * dummy contructor
	 */
	public function __construct() {
		throw new Exception(get_class($this) . ': this class may only be invoked statically.');
	} // __construct()
	
	/**
	 * load a configuration profile
	 * @param string|null $profile
	 */
	public static function load($profile = null) {
		// param check
		if (isset($profile) && !is_string($profile))
			throw new Exception(get_class() . ': wrong param type.');
		if (!isset($profile) && isset(self::$_profile))
			$profile = self::$_profile;
		// only load once
		if (isset(self::$_loaded[$profile])) {
			self::$_profile = $profile;
			return true;
		}
		// load config from database
		$db = DBFactory::get();
		if (!$db->execute("SELECT * FROM %%prefix%%config WHERE cfg_profile='".$profile."';")) {
			// table does not exist .. try to create
			$sql_create  = "CREATE TABLE `%%prefix%%config` (";
			$sql_create .= "  `cfg_profile` char(16) NOT NULL,";
			$sql_create .= "  `cfg_key` char(32) NOT NULL,";
			$sql_create .= "  `cfg_value` text NOT NULL,";
			$sql_create .= "  PRIMARY KEY (`cfg_profile`,`cfg_key`)";
			$sql_create .= ") Type=MyISAM  DEFAULT CHARSET=utf8;";
			if (!$db->execute($sql_create))
				throw new Exception(get_class() . ': configuration can\'t be loaded/created.');
			if (!$db->execute("SELECT * FROM %%prefix%%config WHERE cfg_profile='".$profile."';"))
				throw new Exception(get_class() . ': configuration can\'t be loaded.');
		}
		self::$_profile = $profile;
		while ($row = $db->fetch()) {
			self::$_cache[self::$_profile][$row['cfg_key']] = unserialize($row['cfg_value']);
		}
		self::$_loaded[$profile] = true;
		return true;
	} // load()
	
	/**
	 * unload a configuration profile
	 * @param string $profile
	 */
	public static function unload($profile = null) {
		// param check
		if(isset($profile) && !is_string($profile))
			throw new Exception(get_class() . ': wrong param type.');
		$p = self::$_profile;
		if(isset($profile) && is_string($profile))
			$p = $profile;
		if(isset(self::$_loaded[$p]) && self::$_profile == $p) {
			self::$_loaded[$p] = false;
			self::$_profile = null;
		}
		unset(self::$_cache[$p]);
	} // unload()
	
	/**
	 * set active profile
	 * @param string $profile
	 */
	public static function setProfile($profile) {
		// param check
		if (!is_string($profile))
			throw new Exception(get_class() . ': wrong param type.');
		self::load($profile);
	} // setProfile()
	
	/**
	 * get active profile
	 */
	public static function getProfile() {
		return self::$_profile;
	} // getProfile()
	
	/**
	 * set a configuration key
	 * @param string $key
	 * @param mixed $value
	 */
	public static function set($key, $value) {
		// param check
		if (!is_string($key))
			throw new Exception(get_class() . ': wrong param type.');
		
		self::load();
		// only update the database when the old value differs
		if (isset(self::$_cache[self::$_profile][$key]) && self::$_cache[self::$_profile][$key] === $value) {
			return true;
		}
		// store config
		self::$_cache[self::$_profile][$key] = $value;
		
		// update database
		$value = serialize($value);
		$qry = DBFactory::get();
		$sql = "INSERT INTO %%prefix%%config (cfg_profile, cfg_key, cfg_value) VALUES ('".self::$_profile."','{$key}','{$value}') ON DUPLICATE KEY UPDATE cfg_value = '{$value}'";
		return $qry->execute($sql);
	} // set()
	
	/**
	 * get a configuration key
	 * @param string $key
	 * @param mixed|null $default
	 */
	public static function get($key, $default = null) {
		// param check
		if (!is_string($key))
			throw new Exception(get_class() . ': wrong param type.');
		// get the config
		self::load();
		if(!isset(self::$_cache[self::$_profile][$key]))
			return $default;
		return self::$_cache[self::$_profile][$key];
	} // get()
	
	/**
	 * delete a configuration key
	 * @param string $key
	 */
	public static function del($key) {
		// param check
		if (!is_string($key))
			throw new Exception(get_class() . ': wrong param type.');
		// delete the config
		self::load();
		unset(self::$_cache[self::$_profile][$key]);
		// update database
		$qry = DBFactory::get();
		$qry->execute("DELETE FROM %%prefix%%config WHERE cfg_key = '{$key}' AND cfg_profile = '".self::$_profile."'");
	} // del()
	
} // Config


?>