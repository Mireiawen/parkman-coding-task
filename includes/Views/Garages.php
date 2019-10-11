<?php
declare(strict_types = 1);

namespace Mireiawen\ParkMan\Views;

use Mireiawen\ParkMan\Models\Garage;
use Mireiawen\ParkMan\View;

/**
 * View to show multiple garages
 *
 * @package Mireiawen\ParkMan\Views
 */
class Garages extends AbstractView implements View
{
	/**
	 * Set the data defaults
	 */
	public function __construct()
	{
		$this->data['result'] = FALSE;
		$this->data['garages'] = [];
	}
	
	/**
	 * Set the response garages
	 *
	 * @param Garage[] $garages
	 *    The garages to set to the response
	 *
	 * @throws \Exception
	 *    In case of database errors
	 */
	public function SetGarages(iterable $garages) : void
	{
		$this->data['result'] = TRUE;
		foreach ($garages as $garage)
		{
			$this->data['garages'][] = [
				'garage_id' => $garage->GetID(),
				'name' => $garage->GetName(),
				'hourly_price' => $garage->GetPrice(),
				'currency' => $garage->GetCurrency()->GetSymbol(),
				'contact_email' => $garage->GetCompany()->GetEmail(),
				'point' => \sprintf('%f %f', $garage->GetLatitude(), $garage->GetLongitude()),
				'country' => $garage->GetCountry()->GetName(),
				'owner_id' => $garage->GetCompany()->GetID(),
				'garage_owner' => $garage->GetCompany()->GetName(),
			];
		}
	}
}