<?php
declare(strict_types = 1);

namespace Mireiawen\ParkMan\Routes;

use Mireiawen\ParkMan\Models\Country;
use Mireiawen\ParkMan\Route;
use Mireiawen\ParkMan\Views\Countries;

/**
 * Request GetCountries
 *
 * @package Mireiawen\ParkMan\Routes
 */
class GetCountries extends AbstractRoute implements Route
{
	/**
	 * Get all countries
	 *
	 * @throws \Exception
	 *    In case of database errors
	 */
	public function Run() : void
	{
		$countries = Country::GetAll($this->application->GetDatabase());
		$view = new Countries();
		$view->SetCountries($countries);
		$view->Show();
	}
}