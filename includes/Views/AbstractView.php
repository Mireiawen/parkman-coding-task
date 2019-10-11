<?php
declare(strict_types = 1);

namespace Mireiawen\ParkMan\Views;

use Mireiawen\ParkMan\View;

/**
 * Abstract base for views
 *
 * @package Mireiawen\ParkMan\Views
 */
abstract class AbstractView implements View
{
	/**
	 * The data to send out as JSON
	 *
	 * @var array
	 */
	protected $data = [];
	
	/**
	 * Send out the JSON data
	 */
	public function Show() : void
	{
		echo \json_encode($this->data, \JSON_THROW_ON_ERROR);
	}
}