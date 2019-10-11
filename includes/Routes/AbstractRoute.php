<?php
declare(strict_types = 1);

namespace Mireiawen\ParkMan\Routes;

use Mireiawen\ParkMan\Application;
use Mireiawen\ParkMan\Route;

/**
 * Abstract base for routes
 *
 * @package Mireiawen\ParkMan\Routes
 */
abstract class AbstractRoute implements Route
{
	/**
	 * The application
	 *
	 * @var Application
	 */
	protected $application;
	
	/**
	 * The default constructor for routes
	 *
	 * @param Application $application
	 *    The application
	 */
	public function __construct(Application $application)
	{
		$this->application = $application;
	}
	
	/**
	 * Execute the route
	 */
	abstract function Run() : void;
	
	/**
	 * Get integer ID from the GET request
	 *
	 * @param string $field
	 *    The field to read from
	 *
	 * @return int
	 *    The value of the requested field
	 *
	 * @throws \InvalidArgumentException
	 *    In case the requested  field is not available or integer
	 */
	protected function GetRequestID(string $field) : int
	{
		$value = \filter_input(\INPUT_GET, $field, \FILTER_VALIDATE_INT);
		if ($value === FALSE || $value === NULL)
		{
			throw new \InvalidArgumentException();
		}
		
		return $value;
	}
}