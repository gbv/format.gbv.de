<?php
namespace Re\Debug;

// imports
use Psr\Log\LoggerInterface;
use Re\Util\StringUtil;

/**
 * Set a special exception and error handler.
 * 
 * @package Teralios Web Publisher
 * @author Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license GPLv3
 */
class Debug {
	/**
	 * @var	string
	 */
	protected static $called = false;
	
	/**
	 * @var	\Psr\Log\LoggerInterface;
	 */
	protected static $logger = null;
	
	/**
	 * @var	string
	 */
	protected static $showFull = true;
	
	/**
	 * @var	\Re\Debug\Language
	 */
	protected static $language = null;
	
	/**
	 * @var	array
	 */
	protected static $cleanArgs = [];
	
	/**
	 * @var	string
	 */
	protected static $baseDir = '';
	
	/**
	 * This is only a static class.
	 */
	protected function __construct() { }
	
	/**
	 * Catch error and exception handlers.
	 *
	 * @param	bool	$showFull
	 * @param	string	$languageCode
	 */
	public static function catchTrapHandlers(bool $showFull = true, string $languageCode = 'en') {
		if (static::$called === true) {
			return;
		}
		
		static::$called = true;
		static::$showFull = ($showFull == true) ? true : false;
		static::$language = new Language($languageCode);
		
		// set a simple error handler to cast an error to an exception.
		set_error_handler([static::class, 'handleError']);
		
		// set a exception handler
		$handler = new ExceptionHandler();
		set_exception_handler([$handler, 'handle']);
	}
	
	/**
	 * Set flag for show full description or return current value.
	 * 
	 * @param	boolean	fullView
	 * @return	boolean
	 */
	public static function showFull(bool $showFull = null) {
		if ($showFull !== null) {
			static::$showFull = ($showFull == true) ? true : false;
		}
		
		return static::$showFull;
	}
	
	/**
	 * Set language or return language object.
	 * 
	 * @param	boolean $code
	 * @return	\Re\Debug\Language
	 */
	public static function language(bool $code = null) {
		if ($code !== null) {
			static::$language = new Language($code);
		}
		
		return static::$language;
	}
	
	/**
	 * Set a class and/or function to remove arguments from it.
	 * 
	 * @param	string	$function
	 * @param	string	$class
	 */
	public static function cleanArgsFrom(string $function, string $class = '') {
		static::$cleanArgs[] = [StringUtil::trim($class), StringUtil::trim($function)];
	}
	
	/**
	 * Return array with class, functions to remove arguments from it.
	 * 
	 * @return	array
	 */
	public static function getCleanArgs() {
		return static::$cleanArgs;
	}

	/**
	 * Set a base dir to make paths relative.
	 *
	 * @param	string
	 */
	public static function setBaseDir(string $baseDir) {
		static::$baseDir = $baseDir;
	}

	/**
	 * Return base path.
	 *
	 * @return	string
	 */
	public static function getBaseDir() {
		return static::$baseDir;
	}
	
	/**
	 * Set a dir for the log.
	 * 
	 * @param	\Psr\Log\LoggerInterface
	 */
	public static function setLogger(LoggerInterface $logger) {
		static::$logger = $logger;
	}
	
	/**
	 * Return the dir for the log.
	 * 
	 * @return	\Psr\Log\LoggerInterface
	 */
	public static function getLogger() {
		return static::$logger;
	}

	/**
	 * Handle php errors and cast them to an exception.
	 * 
	 * @param	integer	$severity
	 * @param	string	$message
	 * @param	string	$file
	 * @param	integer	$line
	 * @throws	\ErrorException
	 */
	public static function handleError(int $severity, string $message, string $file, int $line) {
		if (error_reporting() == 0) return;
		
		throw new \ErrorException($message, 0, $severity, $file, $line);
	}
}
