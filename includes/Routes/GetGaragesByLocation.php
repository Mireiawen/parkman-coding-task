<?php
declare(strict_types = 1);

namespace Mireiawen\ParkMan\Routes;

use Mireiawen\ParkMan\Models\Garage;
use Mireiawen\ParkMan\Route;
use Mireiawen\ParkMan\Views\Garages;

/**
 * Request GetGaragesByLocation
 *
 * @package Mireiawen\ParkMan\Routes
 */
class GetGaragesByLocation extends AbstractRoute implements Route
{
	/**
	 * Get the garages by location
	 *
	 * @throws \Exception
	 *    In case of database errors
	 */
	public function Run() : void
	{
		try
		{
			$latitude1 = $this->GetRequestFloat('latitude1');
			$longitude1 = $this->GetRequestFloat('longitude1');
			$latitude2 = $this->GetRequestFloat('latitude2');
			$longitude2 = $this->GetRequestFloat('longitude2');
		}
		catch (\InvalidArgumentException $exception)
		{
			$this->application->SendError(404, 'Invalid Location Data');
			return;
		}
		
		$garages = Garage::GetByLocation($this->application->GetDatabase(), $latitude1, $longitude1, $latitude2, $longitude2);
		$view = new Garages();
		$view->SetGarages($garages);
		$view->Show();
	}
	
	/**
	 * Get float value from the GET request
	 *
	 * @param string $field
	 *    The field to read from
	 *
	 * @return float
	 *    The value of the requested field
	 *
	 * @throws \InvalidArgumentException
	 *    In case the requested  field is not available or float
	 */
	protected function GetRequestFloat(string $field) : float
	{
		$value = \filter_input(\INPUT_GET, $field, \FILTER_VALIDATE_FLOAT);
		if ($value === FALSE || $value === NULL)
		{
			throw new \InvalidArgumentException();
		}
		
		return $value;
	}
}