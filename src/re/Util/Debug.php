<?php
namespace Re\Util;

/**
 * Contains some helpfully functions for debugging the code.
 * 
 * @package Teralios Web Publisher
 * @author Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license GPLv3
 */
final class Debug {
	const MESSAGE = "Variable: %d (%s):\n";
	protected static $memoryLimit = null;
	
	/**
	 * Prints given variables in a readable format.
	 * 
	 * @param	mixed ...$vars
	 */
	public static function printVar(... $vars) {
		$num = 1;
		echo "<pre>\n";
		foreach ($vars as $var) {
			printf(static::MESSAGE, $num, gettype($var));

			if (is_object($var) || is_array($var)) {
				print_r($var);
			} else {
				var_dump($var);
			}

			echo "\n\n-----\n";
			$num++;
		}
		echo "</pre>\n";
	}

	/**
	 * Returns formatted memory usage.
	 *
	 * @param	bool	$usePeak
	 * @return	string
	 */
	public static function formatMemoryUsage(bool $usePeak = false) {
		$bytes = ($usePeak) ? memory_get_usage() : memory_get_peak_usage();

		return File::formatFileSize($bytes, true);
	}

	/**
	 * Returns memory limit in bytes.
	 *
	 * @return	integer
	 */
	public static function getMemoryLimit() {
		if (static::$memoryLimit !== null) {
			return static::$memoryLimit;
		}

		$memoryLimit = ini_get('memory_limit');

		preg_match('#^([\d]+)([KMkm]?)$#', $memoryLimit, $matches);
		$memoryLimit = intval($matches[1]);

		if (!empty($matches[2])) {
			$matches[2] = strtolower($matches[2]);
			switch ($matches[2]) {
				case 'm':
					$memoryLimit *= 1024 * 1024;
					break;
				case 'k':
					$memoryLimit *= 1024;
					break;
			}
		}

		static::$memoryLimit = $memoryLimit;

		return static::$memoryLimit;
	}
}
