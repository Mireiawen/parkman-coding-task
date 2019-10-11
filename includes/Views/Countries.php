<?php
declare(strict_types = 1);

namespace Mireiawen\ParkMan\Views;


use Mireiawen\ParkMan\Models\Country;
use Mireiawen\ParkMan\View;

/**
 * View to show multiple countries
 *
 * @package Mireiawen\ParkMan\Views
 */
class Countries extends AbstractView implements View
{
	/**
	 * Set the data defaults
	 */
	public function __construct()
	{
		$this->data['result'] = FALSE;
		$this->data['countries'] = [];
	}
	
	/**
	 * Set the response countries
	 *
	 * @param Country[] $countries
	 *    The countries to set to the response
	 *
	 * @throws \Exception
	 *    In case of database errors
	 */
	public function SetCountries(iterable $countries) : void
	{
		$this->data['result'] = TRUE;
		foreach ($countries as $country)
		{
			$this->data['countries'][] = [
				'country_id' => $country->GetID(),
				'name' => $country->GetName(),
				'code' => $country->GetCode(),
			];
		}
	}
}