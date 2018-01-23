<?php
namespace Re\Debug\Exception;

/**
 * Cast an \Throwable to an \Exception
 * 
 * @package Teralios Web Publisher
 * @author Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license GPLv3
 */
class ThrowableException extends \ErrorException {
	/**
	 * @var	array
	 */
	protected $originTrace = [];
	
	/**
	 * @var	string
	 */
	protected $type = '';
	
	/**
	 * Cast \Throwable to \Exception.
	 * 
	 * @param \Throwable $e
	 */
	public function __construct(\Throwable $e) {
		parent::__construct($e->getMessage(), $e->getCode(), E_ERROR, $e->getFile(), $e->getLine(), $e->getPrevious());
		
		$this->type = get_class($e);
		$this->originTrace = $e->getTrace();
	}
	
	/**
	 * Returns error type.
	 * 
	 * @return	string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Returns stack trace.
	 * 
	 * @return	mixed[]
	 */
	public function getOriginTrace() {
		return $this->originTrace;
	}
}
