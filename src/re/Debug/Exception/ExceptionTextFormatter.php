<?php
namespace Re\Debug\Exception;

/**
 * Represents a exception message for a log.
 * 
 * @package Teralios Web Publisher
 * @author Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license GPLv3
 */
class ExceptionTextFormatter {
	/**
	 * @var	\Re\Debug\Exception\ExceptionContainer
	 */
	protected $e = null;

	protected $eol = PHP_EOL;

	public function __construct(string $eol = PHP_EOL) {
		$this->eol = $eol;
	}
	
	/**
	 * Render exception message.
	 *
	 * @param	\Re\Debug\Exception\ExceptionContainer	$e
	 * @return	string
	 */
	public function renderText(ExceptionContainer $e) {
		$this->e = $e;
		$message = $this->e->getMessage() . $this->eol;
		$message .= 'Exception-ID:' . $this->e->getID() . $this->eol;
		$message .= 'Type: ' . $this->e->getType() . $this->eol;
		$message .= 'File: ' . $this->e->getFile() . $this->eol;
		$message .= 'Line: ' . $this->e->getLine() . $this->eol;
		$message .= "Stack Trace:" . $this->eol;
		$message .= $this->renderTrace();
		
		return $message;
	}
	
	/**
	 * Render stack trace.
	 *
	 * @return	string
	 */
	protected function renderTrace() {
		$trace = $this->e->getTrace();

		$printArray = function ($array) {
			$count = count($array);
			if ($count > 5) {
				return $count;
			}
			
			$values = [];
			foreach ($array as $key => $value) {
				$values[] = $key . ' => ' . gettype($value);
			}
			
			return implode(', ', $values);
		};
		
		$printArgs = function ($arg) use ($printArray) {
			switch (gettype($arg)) {
				case 'integer':
				case 'double':
					return $arg;
				case 'NULL':
					return 'null';
				case 'string':
					return "'".addcslashes($arg, "\\'")."'";
				case 'boolean':
					return $arg ? 'true' : 'false';
				case 'array':
					return '['. $printArray($arg) . ']';
				case 'object':
					return get_class($arg);
				default:
					return '[unknown]';
			}
		};
		
		$content = '';
		if (count($trace) > 0) {
			foreach ($trace as $num => $item) {
				if (!empty($content)) $content .= $this->eol;
				$content .= '#' . $num . ' ' . $item['file'] . '(' . $item['line'] . ') ';
				$content .= ((!empty($item['class'])) ? $item['class'] . '::' : '') . $item['function'] . '(';
				$content .= implode(', ', array_map($printArgs, $item['args'])) . ')';
			}
		}
		else {
			$content .= '#1 {main}';
		}

		return $content;
	}
}
