<?php
declare(strict_types = 1);

namespace Mireiawen\ParkMan\Routes;

use Mireiawen\ParkMan\Models\Company;
use Mireiawen\ParkMan\Route;
use Mireiawen\ParkMan\Views\Companies;

/**
 * Request GetCompanies
 *
 * @package Mireiawen\ParkMan\Routes
 */
class GetCompanies extends AbstractRoute implements Route
{
	/**
	 * Get all companies
	 *
	 * @throws \Exception
	 *    In case of database errors
	 */
	public function Run() : void
	{
		$companies = Company::GetAll($this->application->GetDatabase());
		$view = new Companies();
		$view->SetCompanies($companies);
		$view->Show();
	}
}