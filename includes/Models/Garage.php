<?php
declare(strict_types = 1);

namespace Mireiawen\ParkMan\Models;

/**
 * Garage data model
 *
 * @package Mireiawen\ParkMan\Models
 */
class Garage extends AbstractData
{
	/**
	 * The database connection
	 *
	 * @var \mysqli
	 */
	protected $database;
	
	/**
	 * The company object
	 *
	 * @var Company|null
	 */
	protected $company = NULL;
	
	/**
	 * The company ID
	 *
	 * @var int
	 */
	protected $company_id = 0;
	
	/**
	 * The price
	 *
	 * @var float
	 */
	protected $price = 0.0;
	
	/**
	 * The currency object
	 *
	 * @var Currency|null
	 */
	protected $currency = NULL;
	
	/**
	 * The currency ID
	 *
	 * @var int
	 */
	protected $currency_id = 0;
	
	/**
	 * The country object
	 *
	 * @var Country|null
	 */
	protected $country = NULL;
	
	/**
	 * The country ID
	 *
	 * @var int
	 */
	protected $country_id = 0;
	
	/**
	 * Latitude
	 *
	 * @var float
	 */
	protected $latitude = 0.0;
	
	/**
	 * Longitude
	 *
	 * @var float
	 */
	protected $longitude = 0.0;
	
	/**
	 * Garage constructor, sets the database so the other objects can be fetched when needed
	 *
	 * @param \mysqli $database
	 */
	protected function __construct(\mysqli $database)
	{
		parent::__construct();
		$this->database = $database;
	}
	
	/**
	 * Get a garage by its ID
	 *
	 * @param \mysqli $database
	 *    The database connection
	 *
	 * @param int $id
	 *    The garage ID to look for
	 *
	 * @return Garage
	 *    The garage found
	 *
	 * @throws \Exception
	 *    In case garage is not found or invalid data
	 */
	public static function GetByID(\mysqli $database, int $id) : self
	{
		$garage = new self($database);
		$row = $garage->GetDatabaseRowByInt($database, 'Garage', 'ID', $id);
		
		$garage->SetData($row);
		
		return $garage;
	}
	
	/**
	 * Get a garage by its name
	 *
	 * @param \mysqli $database
	 *    The database connection
	 *
	 * @param string $name
	 *    The garage name to look for
	 *
	 * @return Garage
	 *    The garage found
	 *
	 * @throws \Exception
	 *    In case garage is not found or invalid data
	 */
	public static function GetByName(\mysqli $database, string $name) : self
	{
		$garage = new self($database);
		$row = $garage->GetDatabaseRowByString($database, 'Currency', 'Name', $name);
		
		$garage->SetData($row);
		
		return $garage;
	}
	
	/**
	 * Get all garages for a company
	 *
	 * @param \mysqli $database
	 *    The database connection
	 *
	 * @param Company $company
	 *    The company to look from
	 *
	 * @return Garage[]
	 *    The garages found for the company
	 *
	 * @throws \Exception
	 *    In case of invalid data
	 */
	public static function GetByCompany(\mysqli $database, Company $company) : iterable
	{
		$garage = new self($database);
		$rows = $garage->GetDatabaseRowsByInt($database, 'Garage', 'Company', $company->GetID());
		
		foreach ($rows as $row)
		{
			$garage = new self($database);
			$garage->SetData($row);
			yield $garage;
		}
	}
	
	/**
	 * Get all garages within specified coordinates
	 *
	 * @param \mysqli $database
	 *    The database connection
	 *
	 * @param float $latitude1
	 * @param float $longitude1
	 * @param float $latitude2
	 * @param float $longitude2
	 *
	 * @return Garage[]
	 *    The garages found inside the coordinates
	 *
	 * @throws \Exception
	 *    In case of invalid data
	 */
	public static function GetByLocation(\mysqli $database, float $latitude1, float $longitude1, float $latitude2, float $longitude2) : iterable
	{
		$sql = 'SELECT * FROM `Garage` WHERE `Latitude` >= ? AND `Longitude` >= ? AND `Latitude` <= ? AND `Longitude` <= ?';
		$statement = $database->prepare($sql);
		if ($statement === FALSE)
		{
			throw new \Exception(\sprintf('Unable to prepare the SQL statement "%s": %d %s', $sql, $database->errno, $database->error));
		}
		
		if ($statement->bind_param('dddd', $latitude1, $longitude1, $latitude2, $longitude2) === FALSE)
		{
			throw new \Exception(\sprintf('Unable to bind the the SQL parameters for "%s": %d %s', $sql, $database->errno, $database->error));
		}
		
		$garage = new self($database);
		$rows = $garage->FetchAssoc($statement);
		
		foreach ($rows as $row)
		{
			$garage = new self($database);
			$garage->SetData($row);
			yield $garage;
		}
	}
	
	/**
	 * Get all garages from a country
	 *
	 * @param \mysqli $database
	 *    The database connection
	 *
	 * @param Country $country
	 *    The country to look from
	 *
	 * @return Garage[]
	 *    The garages found in the country
	 *
	 * @throws \Exception
	 *    In case of invalid data
	 */
	public static function GetByCountry(\mysqli $database, Country $country) : iterable
	{
		$garage = new self($database);
		$rows = $garage->GetDatabaseRowsByInt($database, 'Garage', 'Country', $country->GetID());
		
		foreach ($rows as $row)
		{
			$garage = new self($database);
			$garage->SetData($row);
			yield $garage;
		}
	}
	
	/**
	 * Get the company data
	 *
	 * @return Company
	 *    The company object
	 *
	 * @throws \Exception
	 *    In case the company cannot be fetched
	 */
	public function GetCompany() : Company
	{
		if ($this->company === NULL)
		{
			$this->company = Company::GetByID($this->database, $this->company_id);
		}
		
		return $this->company;
	}
	
	/**
	 * Get the price
	 *
	 * @return float
	 *    The price data
	 */
	public function GetPrice() : float
	{
		return $this->price;
	}
	
	/**
	 * Get the currency data
	 *
	 * @return Currency
	 *    The currency object
	 *
	 * @throws \Exception
	 *    In case the currency cannot be fetched
	 */
	public function GetCurrency() : Currency
	{
		if ($this->currency === NULL)
		{
			$this->currency = Currency::GetByID($this->database, $this->currency_id);
		}
		
		return $this->currency;
	}
	
	/**
	 * Get the country data
	 *
	 * @return Country
	 *    The country object
	 *
	 * @throws \Exception
	 *    In case the country cannot be fetched
	 */
	public function GetCountry() : Country
	{
		if ($this->country === NULL)
		{
			$this->country = Country::GetByID($this->database, $this->country_id);
		}
		
		return $this->country;
	}
	
	/**
	 * Get the latitude data
	 *
	 * @return float
	 *    The latitude
	 */
	public function GetLatitude() : float
	{
		return $this->latitude;
	}
	
	/**
	 * Get the longitude data
	 *
	 * @return float
	 *    The longitude
	 */
	public function GetLongitude() : float
	{
		return $this->longitude;
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
		if (!isset($row['Company']) || (!\is_int($row['Company'])))
		{
			throw new \Exception('Invalid input, expected to have integer Company');
		}
		
		if (!isset($row['Price']) || (!\is_float($row['Price'])))
		{
			throw new \Exception('Invalid input, expected to have float Price');
		}
		
		if (!isset($row['Currency']) || (!\is_int($row['Currency'])))
		{
			throw new \Exception('Invalid input, expected to have integer Currency');
		}
		
		if (!isset($row['Country']) || (!\is_int($row['Country'])))
		{
			throw new \Exception('Invalid input, expected to have integer Country');
		}
		
		if (!isset($row['Latitude']) || (!\is_float($row['Latitude'])))
		{
			throw new \Exception('Invalid input, expected to have float Latitude');
		}
		
		if (!isset($row['Longitude']) || (!\is_float($row['Longitude'])))
		{
			throw new \Exception('Invalid input, expected to have float Longitude');
		}
		
		$this->company_id = $row['Company'];
		$this->price = $row['Price'];
		$this->currency_id = $row['Currency'];
		$this->country_id = $row['Country'];
		$this->latitude = $row['Latitude'];
		$this->longitude = $row['Longitude'];
	}
}