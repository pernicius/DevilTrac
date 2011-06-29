<?php
//require_once(dirname(__FILE__) . '/class.dbconfig.php');


class DBConnection_mysqli
{
	public $_conn = null;
	protected $_cfg;
	
	// Set up a mysqli DB connection.
	function __construct($config = null) {
		$this->_cfg = DBConfig::get($config);
		$this->connect();
	}
	
	function reconnect() {
		return $this->connect();
	}
	
	function connect() {
		if (!$this->_conn = @mysqli_connect(
				isset($this->_cfg['persistent']) ? 'p:'.$this->_cfg['host'] : $this->_cfg['host'],
				$this->_cfg['user'],
				$this->_cfg['pass'],
				$this->_cfg['db'],
				isset($this->_cfg['port']) ? ((int)$this->_cfg['port']) : null
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
	
	function close() {
		if(is_null($this->_conn)) return true;
		$res = $this->_conn->close();
		$this->_conn = null;
		return $res;
	}
	
	// Return the connection id for this connection. Used for connection specific commands.
	function get() {
		return $this->_conn;
	}
	
} // DBConnection_mysqli


?>