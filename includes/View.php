<?php
declare(strict_types = 1);

namespace Mireiawen\ParkMan;

/**
 * Interface for the views
 *
 * @package Mireiawen\ParkMan
 */
interface View
{
	/**
	 * Show the contents of the view
	 */
	public function Show() : void;
}