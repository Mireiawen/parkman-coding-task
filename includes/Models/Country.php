<?php
declare(strict_types = 1);

namespace Mireiawen\ParkMan\Models;

/**
 * Country data model
 *
 * @package Mireiawen\ParkMan\Models
 */
class Country extends AbstractData
{
	/**
	 * The 3-letter country code
	 *
	 * @var string
	 */
	protected $code = '';
	
	/**
	 * Get all known countries
	 *
	 * @param \mysqli $database
	 *    The database connection
	 *
	 * @return Country[]
	 *    The known countries
	 *
	 * @throws \Exception
	 *    In case of invalid data
	 */
	public static function GetAll(\mysqli $database) : iterable
	{
		$country = new self();
		$rows = $country->GetAllDatabaseRows($database, 'Country');
		
		foreach ($rows as $row)
		{
			$country = new self();
			$country->SetData($row);
			yield $country;
		}
	}
	
	/**
	 * Get a country by its ID
	 *
	 * @param \mysqli $database
	 *    The database connection
	 *
	 * @param int $id
	 *    The country ID to look for
	 *
	 * @return Country
	 *    The country found
	 *
	 * @throws \Exception
	 *    In case country is not found or invalid data
	 */
	public static function GetByID(\mysqli $database, int $id) : self
	{
		$country = new self();
		$row = $country->GetDatabaseRowByInt($database, 'Country', 'ID', $id);
		
		$country->SetData($row);
		
		return $country;
	}
	
	/**
	 * Get a country by its name
	 *
	 * @param \mysqli $database
	 *    The database connection
	 *
	 * @param string $name
	 *    The country name to look for
	 *
	 * @return Country
	 *    The country found
	 *
	 * @throws \Exception
	 *    In case country is not found or invalid data
	 */
	public static function GetByName(\mysqli $database, string $name) : self
	{
		$country = new self();
		$row = $country->GetDatabaseRowByString($database, 'Country', 'Name', $name);
		
		$country->SetData($row);
		
		return $country;
	}
	
	/**
	 * Get a country by its 3-letter code
	 *
	 * @param \mysqli $database
	 *    The database connection
	 *
	 * @param string $code
	 *    The country code to look for
	 *
	 * @return Country
	 *    The country found
	 *
	 * @throws \Exception
	 *    In case country is not found or invalid data
	 */
	public static function GetByCode(\mysqli $database, string $code) : self
	{
		$country = new self();
		$row = $country->GetDatabaseRowByString($database, 'Country', 'Code', $code);
		
		$country->SetData($row);
		
		return $country;
	}
	
	/**
	 * Get the country ISO-3166-1 3-letter country code
	 *
	 * @return string
	 *    The country code
	 */
	public function GetCode() : string
	{
		return $this->code;
	}
	
	/**
	 * Set the class properties from the input data
	 *
	 * @param array $row
	 *    The array from where to look for input data
	 *
	 * @throws \Exception
	 *    In case of missing data or data type mismatch
	 */
	protected function SetData(array $row) : void
	{
		parent::SetData($row);
		if (!isset($row['Code']) || (!\is_string($row['Code'])))
		{
			throw new \Exception('Invalid input, expected to have string Code');
		}
		
		$this->code = $row['Code'];
	}
}