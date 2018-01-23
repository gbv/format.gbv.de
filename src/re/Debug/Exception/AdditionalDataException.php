<?php
namespace Re\Debug\Exception;

/**
 * Represents a exception with additional information.
 * 
 * Can be use for database, http or other exception types with more needed information like
 * database version, http version or so on.
 * 
 * @package Teralios Web Publisher
 * @author Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license GPLv3
 */
class AdditionalDataException extends \Exception {
	/**
	 * Contains additional information.
	 * 
	 * @var	string[]
	 */
	protected $additionalData = [];
	
	/**
	 * Return additional data.
	 * 
	 * @return	string[]
	 */
	public function getAdditionalData() {
		return $this->additionalData;
	}
}
