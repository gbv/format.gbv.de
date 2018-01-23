<?php
namespace Re\Database\Table\Writer;

// imports
use Re\Database\Table\Table;

/**
 * Interface for table writers.
 *
 * @package Teralios' Web Publisher
 * @author Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license GPLv3
 */
interface TableWriterInterface {
	/**
	 * Set version information for writer.
	 *
	 * @param	string	$version
	 * @param	string	$type
	 */
	public function setVersion(string $version, string $type);

	/**
	 * Build sql commands.
	 *
	 * @param	\Re\Database\Table\Table $table
	 */
	public function buildCommands(Table $table);

	/**
	 * Return sql commands.
	 *
	 * @return	string[]
	 */
	public function getCommands();

	/**
	 * Return sql limits for tables.
	 *
	 * @return	array
	 */
	public function getLimits();
}
