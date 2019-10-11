<?php
declare(strict_types = 1);

namespace Mireiawen\ParkMan\Routes;

use Mireiawen\ParkMan\Models\Country;
use Mireiawen\ParkMan\Models\Garage;
use Mireiawen\ParkMan\Route;
use Mireiawen\ParkMan\Views\Garages;

/**
 * Request GetGaragesByCountry
 *
 * @package Mireiawen\ParkMan\Routes
 */
class GetGaragesByCountry extends AbstractRoute implements Route
{
	/**
	 * Get the garages by country
	 *
	 * @throws \Exception
	 *    In case of database errors
	 */
	public function Run() : void
	{
		try
		{
			$country_id = $this->GetRequestID('country');
		}
		catch (\InvalidArgumentException $exception)
		{
			$this->application->SendError(404, 'Invalid Country Data');
			return;
		}
		
		$country = Country::GetByID($this->application->GetDatabase(), $country_id);
		$garages = Garage::GetByCountry($this->application->GetDatabase(), $country);
		$view = new Garages();
		$view->SetGarages($garages);
		$view->Show();
	}
}