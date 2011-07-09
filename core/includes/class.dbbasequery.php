<?php
/**
 * page level docblock
 * 
 * @package DevilTrac
 * @subpackage Core-Classes-Database
 */


/**
 * class DBBaseQuery
 * 
 * The base class for (mostly) all DBQuery classes.
 */
abstract class DBBaseQuery
{
	/**
	 * DB configuration name
	 * @var string
	 */
	protected $_cfgname = null;
	
	/**
	 * Execution status.
	 * @var bool
	 */
	protected $_executed = false;
	
	/**
	 * DBConnection object
	 * @var object
	 */
	protected $_dbconn = null;
	
	/**
	 * Return the number of rows affected by the last query.
	 * 
	 * Returns the number of rows from the last query, including those by other objects.
	 * @return int
	 */
	abstract public function affectedRows();
	
	/**
	 * Execute an SQL string.
	 * @param string $sql
	 */
	abstract public function execute($sql);
	
	/**
	 * Return the number of rows returned by the last query.
	 * @return int|false
	 */
	abstract public function recordCount();
	
	/**
	 * Return the next row of results from the last query.
	 * @return array|false
	 */
	abstract public function fetch();
	
	/**
	 * Reset list of results to return the first row from the last query.
	 */
	abstract public function rewind();
	
	/**
	 * Return the auto-increment ID from the last insert operation.
	 * @return int
	 */
	abstract public function getInsertID();
	
	/**
	 * Return true if a query has been executed or false if none has been.
	 * @return bool
	 */
	public function executed() {
		return $this->_executed;
	}
	
	/**
	 * Return an escaped string for use in a query.
	 * @param string $string
	 * @param bool $escapeall Set true to also escape _ and % for LIKE queries.
	 * @return string
	 */
//	abstract public function escape($string, $escapeall = false);
	
	/**
	 * Return the most recent error message for the DB connection.
	 * @return string
	 */
	abstract public function getErrorMsg();
	
	/**
	 * Set the autocommit status.
	 * 
	 * The default of true commits after every query.
     * If set to false the queries will not be commited until autocommit is set to true.
     * @param bool $commit
     * @return bool
	 */
	abstract public function autocommit($commit = true);
	
	/**
	 * Rollback all queries in the current transaction.
	 */
	abstract public function rollback();
	
	/**
	 * Return a list of all accessable tables.
	 * @return array
	 */
//	abstract public function showTables();
	
} // DBBaseQuery


?>