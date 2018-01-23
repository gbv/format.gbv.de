<?php
namespace Re\Database\Driver;

// imports
use Re\Debug\Debug;

/**
 * Contains some standard calls for each driver.
 * 
 * @package Teralios Web Publisher
 * @author Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license GPLv3
 */
trait DatabaseDriverTrait {

	/**
	 * Standard construct method for all database drivers.
	 */
	public function __construct() {
		// Remove arguments from method connect in a exception.
		Debug::cleanArgsFrom('connect', static::class);
	}
}
