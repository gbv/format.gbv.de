<?php
namespace Re\Debug\Exception;

// imports
use Re\Debug\Debug;
use Re\Util\File;
use Re\Util\StringUtil;

/**
 * Unify Exception and Throwable object.
 * 
 * @package Teralios Web Publisher
 * @author Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license GPLv3
 */
class ExceptionContainer {
	/**
	 * @var	\Exception
	 */
	protected $e = null;
	
	/**
	 * @var	string
	 */
	protected $type = '';
	
	/**
	 * @var	\Re\Debug\Exception\ExceptionContainer
	 */
	protected $previous = null;
	
	/**
	 * @var	array
	 */
	protected $trace = [];
	
	/**
	 * @var	array
	 */
	protected $data = [];
	
	/**
	 * @var	string
	 */
	protected $id = '';
	
	/**
	 * @param	\Exception $e
	 */
	public function __construct(\Exception $e) {
		// set normal data.
		$this->e = $e;

		// set type.
		if ($e instanceof ThrowableException) {
			$this->type = $e->getType();
		}
		else {
			$this->type = get_class($this->e);
		}
		
		// remove namespace
		if (($position = strrpos($this->type, '\\'))) {
			$position++;
			$this->type = substr($this->type, $position);
		}
		
		// set previous
		$prev = $e->getPrevious();
		if ($prev instanceof \Exception) {
			$this->previous = new static($prev);
		}
		else if ($prev instanceof \Throwable) {
			$this->previous = new static(new ThrowableException($prev));
		}
		
		// set trace
		$this->trace = ($e instanceof ThrowableException) ? $e->getOriginTrace() : $e->getTrace();

		// set additional data
		if ($e instanceof AdditionalDataException) {
			$this->data = $e->getAdditionalData();
		}
		
		// set an id
		$this->id = sha1(microtime()); // this must only be »unique« not random. ;)
	}
	
	/**
	 * Returns type of the exception.
	 * 
	 * @return	string
	 */
	public function getType() {
		return $this->type;
	}
	
	/**
	 * @see	\Throwable::getMessage()
	 */
	public function getMessage() {
		return $this->e->getMessage();
	}
	
	/**
	 * @see	\Throwable::getCode()
	 */
	public function getCode() {
		return $this->e->getCode();
	}
	
	/**
	 * @see	\Throwable::getFile()
	 */
	public function getFile() {
		return $this->removePath($this->e->getFile());
	}
	
	/**
	 * @see	\Throwable::getLine()
	 */
	public function getLine() {
		return $this->e->getLine();
	}
	
	/**
	 * Returns additional data for the exception.
	 * 
	 * @return	array
	 */
	public function getAdditionalData() {
		return $this->data;
	}
	
	/**
	 * @see	\Throwable::getPrevious()
	 * @return	\Re\Debug\Exception\ExceptionContainer
	 */
	public function getPrev() {
		return $this->previous;
	}
	
	/**
	 * @see	\Throwable::getTrace()
	 */
	public function getTrace() {
		return $this->santizieTrace($this->trace);
	}
	
	/**
	 * Return id of the exception to find them in a log.
	 * 
	 * @return	string
	 */
	public function getID() {
		return $this->id;
	}
	
	/**
	 * Remove confidential data from stack trace.
	 * @param	array	$trace
	 * @return	array
	 */
	protected function santizieTrace(array $trace) {
		// replace args with a string.
		$removeArgs = function () {
			return '[privat]';
		};
		
		// remove paths form args.
		$removePaths = function($item) {
			if (!is_string($item)) {
				return $item;
			}
			
			return $this->removePath($item);
		};
		
		// build a full data set for each line of stack trace.
		$buildStack = function ($item) use ($removeArgs, $removePaths) {
			// set standard vars
			if (!isset($item['file'])) $item['file'] = '[internal function]';
			if (!isset($item['line'])) $item['line'] = '?';
			if (!isset($item['class'])) $item['class'] = '';
			if (!isset($item['type'])) $item['type'] = '';
			if (!isset($item['args'])) $item['args'] = [];
			
			// remove args from given classes and functions
			$class = ltrim(strtolower(StringUtil::trim($item['class'])), '\\');
			$function = strtolower($item['function']);
			$cleanArgs = Debug::getCleanArgs();
			foreach ($cleanArgs as $clean) {
				$cleanClass = ltrim(strtolower($clean[0]), '\\');
				$cleanFunction = strtolower($clean[1]);
				
				if ($class == $cleanClass && $function == $cleanFunction) {
					$item['args'] = array_map($removeArgs, $item['args']);
				}
			}
			
			// make paths relativ
			$item['file'] = $this->removePath($item['file']);
			$item['args'] = array_map($removePaths, $item['args']);
			
			return $item;
		};
		
		return array_map($buildStack, $trace);
	}
	
	/**
	 * Remove paths from file and args.
	 * @param	string	$path
	 * @return	string
	 */
	protected function removePath(string $path) {
		if (!empty(Debug::getBaseDir())) {
			$regex = '#^(' . preg_quote(Debug::getBaseDir()) . ')#';
			if (preg_match($regex, $path)) {
				return './' . File::removeTrailingSlash(File::makeRelative($path, Debug::getBaseDir()));
			}
		}
		
		return $path;
	}
}
