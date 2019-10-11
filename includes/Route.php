<?php
declare(strict_types = 1);

namespace Mireiawen\ParkMan;

/**
 * Interface for routes
 *
 * @package Mireiawen\ParkMan
 */
interface Route
{
	/**
	 * Route constructor
	 *
	 * @param Application $application
	 *    The application itself
	 */
	public function __construct(Application $application);
	
	/**
	 * Execute the route
	 */
	public function Run() : void;
}