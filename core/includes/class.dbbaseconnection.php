<?php
/**
 * page level docblock
 * 
 * @package DevilTrac
 * @subpackage Core-Classes-Database
 */


/**
 * class DBBaseConnection
 * 
 * The base class for (mostly) all DBConnection classes.
 */
abstract class DBBaseConnection
{
	/**
	 * DB configuration name
	 * @var string
	 */
	protected $_cfgname = null;
	
	/**
	 * connection handle/object
	 */
	protected $_conn = null;
	
	/**
	 * Reconnect to a DB.
	 */
	abstract public function reconnect();
	
	/**
	 * Connect to a DB.
	 */
	abstract public function connect();
	
	/**
	 * Close the DB connection.
	 */
	abstract public function close();
	
	/**
	 * Return the connection id for this connection. Used for connection specific commands.
	 * @return object
	 */
	public function get() {
		return $this->_conn;
	}
	
} // DBBaseConnection


?>