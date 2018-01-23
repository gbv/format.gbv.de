<?php
namespace Re\Database\Exception;

// imports
use Re\Debug\Exception\AdditionalDataException;

/**
 * Exception class for database errors.
 * 
 * @package Teralios Web Publisher
 * @author Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license GPLv3
 */
class DatabaseException extends AdditionalDataException {
	
	/**
	 * Creates database exception.
	 * @param	string						$message
	 * @param	\Re\Database\Exception\DatabaseErrorInformation	$information
	 * @param	\Exception					$prev
	 */
	public function __construct(string $message, DatabaseErrorInformation $information, \Exception $prev = null) {
		parent::__construct($message, $information->getCode(), $prev);

		$this->additionalData['SQL Dialect'] = $information->getDialect();
		$this->additionalData['SQL Database'] = $information->getType();
		$this->additionalData['SQL Database Driver'] = $information->getDriverName();
		$this->additionalData['SQL Database Version'] = $information->getVersion();
		if ($information->getSQLState()) {
			$this->additionalData['SQL State'] = $information->getSQLState();
		}
		$this->additionalData['SQL Error'] = $information->getMessage();
		
		if ($information->getQuery()) {
			$this->additionalData['SQL Query'] = $information->getQuery();
		}
	}
}
