<?php
/**
 * page level docblock
 * 
 * @package DevilTrac
 * @subpackage Core-Classes-Database
 */


require_once(dirname(__FILE__) . '/class.dbperf.php');
require_once(dirname(__FILE__) . '/class.dbbasequery.php');
require_once(dirname(__FILE__) . '/class.dbconnection_mysqli.php');


/**
 * class DBQueryNormal_mysqli
 */
class DBQueryNormal_mysqli extends DBBaseQuery
{
	/**
	 * mysqli query result
	 * @var object
	 */
	private $_resid = null;
	
	/**
	 * 
	 * @param string|null $config
	 */
	public function __construct($config = DBConfig::CONFIG_DEFAULT) {
		// save the config name
		$this->_cfgname = $config;
		// create the connection
		$this->_dbconn = new DBConnection_mysqli($this->_cfgname);
	} // __construct()
	
	
	/**
	 * Return the number of rows affected by the last query.
	 * 
	 * Returns the number of rows from the last query, including those by other objects.
	 * @return int
	 */
	public function affectedRows() {
		return $this->_dbconn->get()->affected_rows;
	}
	
	/**
	 * Execute an SQL string.
	 * @param string $sql
	 */
	public function execute($sql) {
		// param check
		if (!is_string($sql))
			throw new Exception(get_class() . ': wrong param type.');
		
		// replace table prefix
		// TODO...
		
		// store start of exec
		$t1 = strtok(microtime(), ' ') + strtok('');
		
		// exec query
		$this->_resid = mysqli_query($this->_dbconn->get(), $sql);
		if ($this->_resid === false || $this->_dbconn->get()->errno)
			throw new Exception('DBError(' . $this->_dbconn->get()->errno . '): ' . $this->_dbconn->get()->error);
		
		// save status
		DBPerf::execTime($this->_cfgname, strtok(microtime(), ' ') + strtok('') - $t1);
		$this->executed_ = true;
		DBPerf::queryCount($this->_cfgname, true);
		
		return true;
	}
	
	/**
	 * Return the number of rows returned by the last query.
	 * @return int|false
	 */
	public function recordCount() {
		if ($this->_resid !== false)
			return $this->_resid->num_rows;
		return false;
	}
	
	/**
	 * Return the next row of results from the last query.
	 * @return array|false
	 */
	public function fetch() {
		if ($this->_resid !== false) {
			DBPerf::fetchCount($this->_cfgname, true);
			return $this->_resid->fetch_assoc();
		}
		return false;
	}
	
	/**
	 * Reset list of results to return the first row from the last query.
	 */
	public function rewind() {
		if ($this->_resid !== false)
			@mysqli_data_seek($this->_resid, 0);
	}
	
	/**
	 * Return the auto-increment ID from the last insert operation.
	 * @return int
	 */
	public function getInsertID() {
		return $this->_dbconn->get()->insert_id;
	}
	
	/**
	 * Return an escaped string for use in a query.
	 * @param string $string
	 * @param bool $escapeall Set true to also escape _ and % for LIKE queries.
	 * @return string
	 */
//	public function escape($string, $escapeall = false);
	
	/**
	 * Return the most recent error message for the DB connection.
	 * @return string
	 */
	public function getErrorMsg() {
		mysqli_error($this->_dbconn->get());
	}
	
	/**
	 * Set the autocommit status.
	 * 
	 * The default of true commits after every query.
     * If set to false the queries will not be commited until autocommit is set to true.
     * @param bool $commit
     * @return bool
	 */
	public function autocommit($commit = true) {
		return $this->_dbconn->get()->autocommit($commit);
	}
	
	/**
	 * Rollback all queries in the current transaction.
	 */
	public function rollback() {
		return mysqli_rollback($this->_dbconn->get());
	}
	
	/**
	 * Return a list of all accessable tables.
	 * @return array
	 */
//	public function showTables();
	
} // DBQueryNormal_mysqli


?>