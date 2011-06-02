<?php


class DBConfig
{
	// config storrage
	static $_configs = array();
	// used config in this object
	var $_cfg; 

	function __construct($config = null) {
		// if no args try default config
		if (!isset($config))
			$config = '_default';
			
		// try to use...
		if (is_string($config)) {
			if (!isset(self::$_configs[$config]))
				throw new Exception(get_class($this) . ': no configuration (named:\'' . $config . '\') found.');
			// use as current config
			$this->_cfg = self::$_configs[$config];
			return;
		}
		
		// try to clone...
		elseif (is_object($config)) {
			if (!isset($config->_cfg['name']))
				throw new Exception(get_class($this) . ': object has no initialized configuration.');
			// clone config
			$this->_cfg = $config->_cfg;
//			$this->_cfg['name'] = 'cloned_' . $this->_cfg['name'];
			return;
		}
		
		// try to create...
		elseif (is_array($config)) {
			if (!isset($config['name']))
				throw new Exception(get_class($this) . ': missing configuration name.');
			if (isset(self::$_configs[$config['name']]) && !isset($config['override']))
				throw new Exception(get_class($this) . ': configuration (named:\'' . $config['name'] . '\') already exists.');
			// store as new config
			self::$_configs[$config['name']] = $config;
			$this->_cfg = self::$_configs[$config['name']];
			return;
		}
		
		// fatal error...
		throw new Exception(get_class($this) . ': no matching configuration found.');
	} // __construct()
	
} // class DBConfig
