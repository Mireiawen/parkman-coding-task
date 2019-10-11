<?php
declare(strict_types = 1);

namespace Mireiawen\ParkMan\Views;

use Mireiawen\ParkMan\Models\Company;
use Mireiawen\ParkMan\View;

/**
 * View to show multiple companies
 *
 * @package Mireiawen\ParkMan\Views
 */
class Companies extends AbstractView implements View
{
	/**
	 * Set the data defaults
	 */
	public function __construct()
	{
		$this->data['result'] = FALSE;
		$this->data['companies'] = [];
	}
	
	/**
	 * Set the response companies
	 *
	 * @param Company[] $companies
	 *    The companies to set to the response
	 *
	 * @throws \Exception
	 *    In case of database errors
	 */
	public function SetCompanies(iterable $companies) : void
	{
		$this->data['result'] = TRUE;
		foreach ($companies as $company)
		{
			$this->data['companies'][] = [
				'company_id' => $company->GetID(),
				'name' => $company->GetName(),
				'email' => $company->GetEmail(),
			];
		}
	}
	
}