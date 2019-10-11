<?php
declare(strict_types = 1);

namespace Mireiawen\ParkMan\Models;

/**
 * Abstract base for data models
 *
 * @package Mireiawen\ParkMan\Models
 */
abstract class AbstractData
{
	/**
	 * The unique ID
	 *
	 * @var int
	 */
	protected $id = 0;
	
	/**
	 * The name
	 *
	 * @var string
	 */
	protected $name = '';
	
	/**
	 * Get the unique ID
	 *
	 * @return int
	 */
	public function GetID() : int
	{
		return $this->id;
	}
	
	/**
	 * Get the name
	 *
	 * @return string
	 */
	public function GetName() : string
	{
		return $this->name;
	}
	
	/**
	 * The data object constructor
	 */
	protected function __construct()
	{
	}
	
	/**
	 * Fetch all rows from the database
	 *
	 * @param \mysqli $database
	 *    The database connection to use
	 *
	 * @param string $table
	 *    The table to read from
	 *
	 * @return array
	 *    The database rows
	 *
	 * @throws \Exception
	 *    On errors
	 */
	public function GetAllDatabaseRows(\mysqli $database, string $table) : array
	{
		$sql = \sprintf('SELECT * FROM `%s`', $table);
		$statement = $database->prepare($sql);
		if ($statement === FALSE)
		{
			throw new \Exception(\sprintf('Unable to prepare the SQL statement "%s": %d %s', $sql, $database->errno, $database->error));
		}
		
		return $this->FetchAssoc($statement);
	}
	
	/**
	 * Fetch rows from the database by int key
	 *
	 * @param \mysqli $database
	 *    The database connection to use
	 *
	 * @param string $table
	 *    The table to read from
	 *
	 * @param string $key
	 *    The index key to read from
	 *
	 * @param int $value
	 *    The value for the index key
	 *
	 * @return array
	 *    The database rows
	 *
	 * @throws \Exception
	 *    On errors
	 */
	protected function GetDatabaseRowsByInt(\mysqli $database, string $table, string $key, int $value) : array
	{
		$sql = \sprintf('SELECT * FROM `%s` WHERE `%s` = ?', $table, $key);
		$statement = $database->prepare($sql);
		if ($statement === FALSE)
		{
			throw new \Exception(\sprintf('Unable to prepare the SQL statement "%s": %d %s', $sql, $database->errno, $database->error));
		}
		
		if ($statement->bind_param('i', $value) === FALSE)
		{
			throw new \Exception(\sprintf('Unable to bind the the SQL parameters for "%s": %d %s', $sql, $database->errno, $database->error));
		}
		
		return $this->FetchAssoc($statement);
	}
	
	/**
	 * Fetch rows from the database by string key
	 *
	 * @param \mysqli $database
	 *    The database connection to use
	 *
	 * @param string $table
	 *    The table to read from
	 *
	 * @param string $key
	 *    The index key to read from
	 *
	 * @param string $value
	 *    The value for the index key
	 *
	 * @return array
	 *    The database rows
	 *
	 * @throws \Exception
	 *    On errors
	 */
	protected function GetDatabaseRowsByString(\mysqli $database, string $table, string $key, string $value) : array
	{
		$sql = \sprintf('SELECT * FROM `%s` WHERE `%s` = ?', $table, $key);
		$statement = $database->prepare($sql);
		if ($statement === FALSE)
		{
			throw new \Exception(\sprintf('Unable to prepare the SQL statement "%s": %d %s', $sql, $database->errno, $database->error));
		}
		
		if ($statement->bind_param('s', $value) === FALSE)
		{
			throw new \Exception(\sprintf('Unable to bind the the SQL parameters for "%s": %d %s', $sql, $database->errno, $database->error));
		}
		
		return $this->FetchAssoc($statement);
	}
	
	/**
	 * Fetch a single row from the database by int key
	 *
	 * @param \mysqli $database
	 *    The database connection to use
	 *
	 * @param string $table
	 *    The table to read from
	 *
	 * @param string $key
	 *    The index key to read from
	 *
	 * @param int $value
	 *    The value for the index key
	 *
	 * @return array
	 *    The database row
	 *
	 * @throws \Exception
	 *    On errors
	 */
	protected function GetDatabaseRowByInt(\mysqli $database, string $table, string $key, int $value) : array
	{
		$rows = $this->GetDatabaseRowsByInt($database, $table, $key, $value);
		if (\count($rows) !== 1)
		{
			throw new \Exception(\sprintf('Expected to get only a single row.'));
		}
		
		return $rows[0];
	}
	
	/**
	 * Fetch a single row from the database by string key
	 *
	 * @param \mysqli $database
	 *    The database connection to use
	 *
	 * @param string $table
	 *    The table to read from
	 *
	 * @param string $key
	 *    The index key to read from
	 *
	 * @param string $value
	 *    The value for the index key
	 *
	 * @return array
	 *    The database row
	 *
	 * @throws \Exception
	 *    On errors
	 */
	protected function GetDatabaseRowByString(\mysqli $database, string $table, string $key, string $value) : array
	{
		$rows = $this->GetDatabaseRowsByString($database, $table, $key, $value);
		if (\count($rows) !== 1)
		{
			throw new \Exception(\sprintf('Expected to get only a single row.'));
		}
		
		return $rows[0];
	}
	
	/**
	 * Fetch associative array of all rows from the database statement
	 *
	 * @param \mysqli_stmt $statement
	 *    The statement to fetch from
	 *
	 * @return array[]
	 *    The array of the database rows
	 *
	 * @throws \Exception
	 *    On database errors
	 */
	protected function FetchAssoc(\mysqli_stmt $statement) : array
	{
		// Execute the query itself
		if ($statement->execute() === FALSE)
		{
			throw new \Exception(\sprintf('Unable to execute SQL query": %d %s', $statement->errno, $statement->error));
		}
		
		// Get result
		$result = $statement->get_result();
		if ($result === FALSE && $statement->errno !== 0)
		{
			throw new \Exception(\sprintf('Unable to fetch SQL result for query: %d %s', $statement->errno, $statement->error));
		}
		
		// Tried to execute query that does not return data
		if ($result === FALSE)
		{
			throw new \Exception(\sprintf('Unable to fetch SQL result for query that does not return data'));
		}
		
		// Get all rows
		$rows = $result->fetch_all(\MYSQLI_ASSOC);
		
		// Free the result and return the rows
		$result->free();
		return $rows;
	}
	
	/**
	 * Set the ID and name from input array
	 *
	 * @param array $row
	 *    The array from where to look for input data
	 *
	 * @throws \Exception
	 *    In case of missing data or data type mismatch
	 */
	protected function SetData(array $row) : void
	{
		if (!isset($row['ID']) || (!\is_int($row['ID'])))
		{
			throw new \Exception('Invalid input, expected to have integer ID');
		}
		
		if (!isset($row['Name']) || (!\is_string($row['Name'])))
		{
			throw new \Exception('Invalid input, expected to have string Name');
		}
		
		$this->id = $row['ID'];
		$this->name = $row['Name'];
	}
}