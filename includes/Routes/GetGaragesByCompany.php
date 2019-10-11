<?php
declare(strict_types = 1);

namespace Mireiawen\ParkMan\Routes;

use Mireiawen\ParkMan\Models\Company;
use Mireiawen\ParkMan\Models\Garage;
use Mireiawen\ParkMan\Route;
use Mireiawen\ParkMan\Views\Garages;

/**
 * Request GetGaragesByCompany
 *
 * @package Mireiawen\ParkMan\Routes
 */
class GetGaragesByCompany extends AbstractRoute implements Route
{
	/**
	 * Get the garages by company
	 *
	 * @throws \Exception
	 *    In case of database errors
	 */
	public function Run() : void
	{
		try
		{
			$company_id = $this->GetRequestID('company');
		}
		catch (\InvalidArgumentException $exception)
		{
			$this->application->SendError(404, 'Invalid Company Data');
			return;
		}
		
		$company = Company::GetByID($this->application->GetDatabase(), $company_id);
		$garages = Garage::GetByCompany($this->application->GetDatabase(), $company);
		$view = new Garages();
		$view->SetGarages($garages);
		$view->Show();
	}
}