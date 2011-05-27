<?php


class DBConfig
{
	// config storrage
	static $_configs = array();
	// used config in this object
	var $_cfg; 

	function __construct($cfg = null) {
		// if no args try default config
		if (!isset($cfg))
			$cfg = '_default';
			
		// try to use...
		if (is_string($cfg)) {
			if (!isset(self::$_configs[$cfg]))
				throw new Exception(get_class($this) . ': no configuration (named:\''.$cfg.'\') found.');
			// use as current config
			$this->_cfg = self::$_configs[$cfg];
			return;
		}
		
		// try to clone...
		elseif (is_object($cfg)) {
			if (!isset($cfg->_cfg['name']))
				throw new Exception(get_class($this) . ': object has no initialized configuration.');
			// clone config
			$this->_cfg = $cfg->_cfg;
//			$this->_cfg['name'] = 'cloned_' . $this->_cfg['name'];
			return;
		}
		
		// try to create...
		elseif (is_array($cfg)) {
			if (!isset($cfg['name']))
				throw new Exception(get_class($this) . ': missing configuration name.');
			if (isset(self::$_configs[$cfg['name']]))
				throw new Exception(get_class($this) . ': configuration (named:\''.$cfg['name'].'\') already exists.');
			// store as new config
			self::$_configs[$cfg['name']] = $cfg;
			$this->_cfg = self::$_configs[$cfg['name']];
			return;
		}
		
		// fatal error...
		throw new Exception(get_class($this) . ': no matching configuration found.');
	} // __construct()
	
} // class DBConfig
