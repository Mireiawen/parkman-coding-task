<?php
declare(strict_types = 1);

namespace Mireiawen\ParkMan\Models;

/**
 * Currency data model
 *
 * @package Mireiawen\ParkMan\Models
 */
class Currency extends AbstractData
{
	/**
	 * The 3-letter currency code
	 *
	 * @var string
	 */
	protected $code = '';
	
	/**
	 * The currency symbol
	 *
	 * @var string
	 */
	protected $symbol = '';
	
	/**
	 * Get a currency by its ID
	 *
	 * @param \mysqli $database
	 *    The database connection
	 *
	 * @param int $id
	 *    The currency ID to look for
	 *
	 * @return Currency
	 *    The currency found
	 *
	 * @throws \Exception
	 *    In case currency is not found or invalid data
	 */
	public static function GetByID(\mysqli $database, int $id) : self
	{
		$currency = new self();
		$row = $currency->GetDatabaseRowByInt($database, 'Currency', 'ID', $id);
		
		$currency->SetData($row);
		
		return $currency;
	}
	
	/**
	 * Get a currency by its name
	 *
	 * @param \mysqli $database
	 *    The database connection
	 *
	 * @param string $name
	 *    The currency name to look for
	 *
	 * @return Currency
	 *    The currency found
	 *
	 * @throws \Exception
	 *    In case currency is not found or invalid data
	 */
	public static function GetByName(\mysqli $database, string $name) : self
	{
		$currency = new self();
		$row = $currency->GetDatabaseRowByString($database, 'Currency', 'Name', $name);
		
		$currency->SetData($row);
		
		return $currency;
	}
	
	/**
	 * Get a currency by its 3-letter code
	 *
	 * @param \mysqli $database
	 *    The database connection
	 *
	 * @param string $code
	 *    The currency code to look for
	 *
	 * @return Currency
	 *    The currency found
	 *
	 * @throws \Exception
	 *    In case currency is not found or invalid data
	 */
	public static function GetByCode(\mysqli $database, string $code) : self
	{
		$currency = new self();
		$row = $currency->GetDatabaseRowByString($database, 'Currency', 'Code', $code);
		
		$currency->SetData($row);
		
		return $currency;
	}
	
	/**
	 * Get the currency ISO-3166-1 3-letter currency code
	 *
	 * @return string
	 *    The currency code
	 */
	public function GetCode() : string
	{
		return $this->code;
	}
	
	/**
	 * Get the currency symbol
	 *
	 * @return string
	 *    The currency symbol
	 */
	public function GetSymbol() : string
	{
		return $this->symbol;
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
		
		if (!isset($row['Symbol']) || (!\is_string($row['Symbol'])))
		{
			throw new \Exception('Invalid input, expected to have string Symbol');
		}
		
		$this->code = $row['Code'];
		$this->symbol = $row['Symbol'];
	}
}
