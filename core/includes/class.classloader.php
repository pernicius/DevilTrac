<?php


class ClassLoader
{
	protected static $_rootDir = '';
	protected static $_classes = array();
	
	/**
	 * dummy contructor
	 */
	public function __construct() {
		throw new Exception(get_class($this) . ': this class may only be invoked statically.');
	} // __construct()
	
	/**
	 * set/get root dir
	 * @param string|null $dir
	 * @return string
	 */
	public static function rootDir($dir = null) {
		// set new root dir
		if (isset($dir) && is_dir($dir)) {
			if (substr($dir, -1) != '/')
				$dir .= '/';
			self::$_rootDir = $dir;
		}
		// use default root dir
		if (empty(self::$_rootDir)) {
			$dir = str_replace('\\', '/', __FILE__);
			$dir = substr($dir, 0, strpos($dir, 'core/includes/class.classloader.php'));
			self::$_rootDir = $dir;
		}
		// return stored root dir
		return self::$_rootDir;
	} // rootDir()
	
	/**
	 * register a file to load if class is requested
	 * @param string $class
	 * @param string $file
	 */
	public static function register($class, $file) {
		if (!is_file($file))
			throw new Exception(get_class($this) . ': the file "'.$file.'" doesn\'t exit.');
		if (isset(self::$_classes[strtolower($class)])) {
			trigger_error(get_class($this) . ': the class "'.$class.'" is already registered.', E_USER_WARNING);
			return;
		}
		self::$_classes[strtolower($class)] = $file;
	} // register()
	
	/**
	 * delete a classregistration
	 * @param string $class
	 */
	public static function unregister($class) {
		unset(self::$_classes[strtolower($class)]);
	} // unregister()
	
	/**
	 * load a class file
	 * @param string $class
	 */
	public static function load($class) {
		// try to load registered class
		if (isset(self::$_classes[strtolower($class)])) {
			require_once(self::$_classes[strtolower($class)]);
			if (is_callable(array($class, 'onLoad')))
				call_user_func(array($class, 'onLoad'));
			return true;
		}
		// try to load core class
		$root = self::rootDir();
		if (file_exists($root.'core/includes/class.'.strtolower($class).'.php')) {
			require_once($root.'core/includes/class.'.strtolower($class).'.php');
			if (is_callable(array($class, 'onLoad')))
				call_user_func_array(array($class, 'onLoad'));
			return true;
		}
		/* TODO:
		 * subdir test
		 * EveAPI_ServerStatus => .../class.eveapiserverstatus.php
		 *                     => .../eveapi/class.serverstatus.php
		 */
	} // load()
	
} // class ClassLoader


spl_autoload_register('ClassLoader::load');


?>