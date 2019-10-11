<?php
declare(strict_types = 1);

namespace Mireiawen\ParkMan\Models;


/**
 * Company data model
 *
 * @package Mireiawen\ParkMan\Models
 */
class Company extends AbstractData
{
	/**
	 * The company contact email address
	 *
	 * @var string
	 */
	protected $email = '';
	
	/**
	 * Get all known companies
	 *
	 * @param \mysqli $database
	 *    The database connection
	 *
	 * @return Company[]
	 *    The known companies
	 *
	 * @throws \Exception
	 *    In case of invalid data
	 */
	public static function GetAll(\mysqli $database) : iterable
	{
		$company = new self();
		$rows = $company->GetAllDatabaseRows($database, 'Company');
		
		foreach ($rows as $row)
		{
			$company = new self();
			$company->SetData($row);
			yield $company;
		}
	}
	
	/**
	 * Get a company by its ID
	 *
	 * @param \mysqli $database
	 *    The database connection
	 *
	 * @param int $id
	 *    The company ID to look for
	 *
	 * @return Company
	 *    The company found
	 *
	 * @throws \Exception
	 *    In case company is not found or invalid data
	 */
	public static function GetByID(\mysqli $database, int $id) : self
	{
		$company = new self();
		$row = $company->GetDatabaseRowByInt($database, 'Company', 'ID', $id);
		
		$company->SetData($row);
		
		return $company;
	}
	
	/**
	 * Get a company by its name
	 *
	 * @param \mysqli $database
	 *    The database connection
	 *
	 * @param string $name
	 *    The company name to look for
	 *
	 * @return Company
	 *    The company found
	 *
	 * @throws \Exception
	 *    In case company is not found or invalid data
	 */
	public static function GetByName(\mysqli $database, string $name) : self
	{
		$company = new self();
		$row = $company->GetDatabaseRowByString($database, 'Company', 'Name', $name);
		
		$company->SetData($row);
		
		return $company;
	}
	
	/**
	 * Get the company email address
	 *
	 * @return string
	 */
	public function GetEmail() : string
	{
		return $this->email;
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
		if (!isset($row['Email']) || (!\is_string($row['Email'])))
		{
			throw new \Exception('Invalid input, expected to have string Email');
		}
		
		$this->email = $row['Email'];
	}
}