<?php
declare(strict_types = 1);

namespace Mireiawen\ParkMan;

use Mireiawen\ParkMan\Routes\GetCompanies;
use Mireiawen\ParkMan\Routes\GetCountries;
use Mireiawen\ParkMan\Routes\GetGaragesByCompany;
use Mireiawen\ParkMan\Routes\GetGaragesByCountry;
use Mireiawen\ParkMan\Routes\GetGaragesByLocation;

/**
 * Main Application class
 *
 * @package Mireiawen\ParkMan
 */
class Application
{
	/**
	 * @var \mysqli
	 */
	protected $database;
	
	/**
	 * Set up the application
	 *
	 * @param \mysqli $database
	 *    The database connection
	 */
	public function __construct(\mysqli $database)
	{
		$this->database = $database;
	}
	
	/**
	 * The main application handler
	 */
	public function Run() : void
	{
		$request = \filter_input(\INPUT_GET, 'request', \FILTER_SANITIZE_STRING, \FILTER_FLAG_STRIP_HIGH | \FILTER_FLAG_STRIP_LOW);
		if ($request === NULL)
		{
			$request = '';
		}
		
		switch ($request)
		{
		case 'GetAllCompanies':
			$route = new GetCompanies($this);
			break;
		
		case 'GetAllCountries':
			$route = new GetCountries($this);
			break;
		
		case 'GetGaragesByCompany':
			$route = new GetGaragesByCompany($this);
			break;
		
		case 'GetGaragesByCountry':
			$route = new GetGaragesByCountry($this);
			break;
		
		case 'GetGaragesByLocation':
			$route = new GetGaragesByLocation($this);
			break;
		
		default:
			$this->SendError(404, 'Invalid request');
			return;
		}
		
		try
		{
			$route->Run();
		}
		catch (\Exception $exception)
		{
			$this->SendError(500, $exception->getMessage());
		}
	}
	
	/**
	 * Get the database connection
	 *
	 * @return \mysqli
	 */
	public function GetDatabase() : \mysqli
	{
		return $this->database;
	}
	
	/**
	 * Send JSON error message with HTTP status code
	 *
	 * @param int $code
	 *    HTTP status code to set
	 *
	 * @param string $message
	 *    The message to send
	 */
	public function SendError(int $code, string $message) : void
	{
		\http_response_code($code);
		echo \json_encode(['result' => FALSE, 'error' => $message], \JSON_THROW_ON_ERROR);
	}
}