<?php
namespace Re\Debug;

/**
 * Contains translations for exceptions message.
 * 
 * @package Teralios' Web Publisher
 * @author Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license GPLv3
 */
class Language {
	/**
	 * Code of languages (ISO-639-1)
	 * 
	 * @var	string
	 */
	protected $code = 'en';
	
	/**
	 * Contain messages.
	 * 
	 * @var	string[]
	 */
	protected $messages = [];
	
	/**
	 * Contain titles.
	 * 
	 * @var	string[]
	 */
	protected $titles = [];
	
	// default values (english)
	const DEFAULT_TITLES = ['An error has occurred', 'Some errors has occurred'];
	const DEFAULT_MESSAGES = ['Unfortunately we weren\'t able to process your request. It appears to occur one or multiple errors and the script had to be stopped.  Please try again later.', 'Please contact the support with the specific error codes.'];
	
	/**
	 * Creates language object.
	 * 
	 * @param	string	$code
	 */
	public function __construct(string $code = 'en') {
		$this->code = $code;
		
		$this->loadLanguage();
	}
	
	/**
	 * Return titles.
	 * 
	 * @return	string[]
	 */
	public function getTitles() {
		return $this->titles;
	}
	
	/**
	 * Return messages.
	 * @return	string[]
	 */
	public function getMessages() {
		return $this->messages;
	}
	
	/**
	 * Load messages and titles.
	 */
	protected function loadLanguage() {
		$this->titles = static::DEFAULT_TITLES;
		$this->messages = static::DEFAULT_MESSAGES;
		
		if (preg_match('#^[a-zA-Z]{2}$#', $this->code)) {
			$titles = $messages = [];
			$file = __DIR__ . '/Language/' . strtolower($this->code) . '.php';
			
			if (file_exists($file)) {
				require($file);
				if (is_array($titles) && count($titles) == 2) {
					$this->titles = $titles;
				}
				
				if (is_array($messages) && count($messages) == 2) {
					$this->messages = $messages;
				}
			}
		}
	}
}
