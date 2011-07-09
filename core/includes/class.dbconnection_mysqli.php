<?php
/**
 * page level docblock
 * 
 * @package DevilTrac
 * @subpackage Core-Classes-Database
 */


require_once(dirname(__FILE__) . '/class.dbbaseconnection.php');
//require_once(dirname(__FILE__) . '/class.dbconfig.php');


/**
 * class DBConnection_mysqli
 */
class DBConnection_mysqli extends DBBaseConnection
{
	/**
	 * Set up a mysqli DB connection.
	 * @param string $config
	 */
	public function __construct($config = null) {
		// save the config name
		$this->_cfgname = $config;
		// establish the connection
		$this->connect();
	}
	
	/**
	 * Reconnect to a DB.
	 */
	public function reconnect() {
		return $this->connect();
	}
	
	/**
	 * Connect to a DB.
	 */
	public function connect() {
		if (!is_null($this->_conn))
			return true;
		if (!$this->_conn = @mysqli_connect(
				DBConfig::getParam($this->_cfgname, 'persistent', false) ? ('p:'.DBConfig::getParam($this->_cfgname, 'host')) : (DBConfig::getParam($this->_cfgname, 'host')),
				DBConfig::getParam($this->_cfgname, 'user'),
				DBConfig::getParam($this->_cfgname, 'pass'),
				DBConfig::getParam($this->_cfgname, 'db'),
				(DBConfig::getParam($this->_cfgname, 'port') != null) ? ((int)DBConfig::getParam($this->_cfgname, 'port')) : null
				)) {
			if (mysqli_connect_error() != null) {
				throw new Exception('DBError('.mysqli_connect_errno().'): '.mysqli_connect_error());
			} else {
				throw new Exception('DBError: Unable to connect to mysqli database.');
			}
		}
		// TODO: do we really need this? ... further info: http://www.php.net/manual/en/mysqli.set-charset.php
		if (method_exists($this->_conn, 'set_charset')) $this->_conn->set_charset('utf8');
		
		return true;
	}
	
	/**
	 * Close the DB connection.
	 */
	public function close() {
		if (is_null($this->_conn))
			return true;
		$res = $this->_conn->close();
		$this->_conn = null;
		return $res;
	}
	
} // DBConnection_mysqli


?>