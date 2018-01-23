<?php
namespace Re\Debug;

// imports
use Re\Debug\Exception\ExceptionContainer;
use Re\Debug\Exception\ExceptionTextFormatter;
use Re\Debug\Exception\ThrowableException;
use Re\Util\StringUtil;

/**
 * Handles exceptions.
 * 
 * @package Teralios' Web Publisher
 * @author Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license GPLv3
 */
class ExceptionHandler {
	/**
	 * @var	\DateTime
	 */
	protected $dateTime = null;
	/**
	 * @var	\Re\Debug\Exception\ExceptionContainer
	 */
	protected $container = null;

	/**
	 * @var	\Psr\Log\LoggerInterface
	 */
	protected $logger = null;

	/**
	 * @var	\Re\Debug\Exception\ExceptionTextFormatter
	 */
	protected $textFormatter = null;

	/**
	 * @var	bool
	 */
	protected $logFailed = false;
	
	/**
	 * @var	array
	 */
	protected $systemInformation = [];
	
	/**
	 * @var	integer
	 */
	protected $countExceptions = 0;
	
	/**
	 * @var	array
	 */
	protected $exceptionIDs = [];
	
	/**
	 * @var	string
	 */
	protected $time = '';
	
	/**
	 * @var	string
	 */
	const HTML_TEMPLATE = <<<HTML_TEMPLATE
<!DOCTYPE html>
<html>
	<head>
		<title>{\$title}</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<style type="text/css">
body {
	font-family: sans-serif;
	font-size: 18px;
}

ol, ul {
	margin: 0;
	list-style: none;
	font-size: 14px;
	counter-reset: item;
}

li {
	padding: 5px;
	margin-bottom: 5px;
	background-color: #fff;
	font-weight: bold;
	counter-increment: item;
}

ol li::before {
	display: inline-block;
	margin-right: 10px;
	font-weight:normal;
	text-align: center;
	content: counter(item)".";
}

li:nth-child(even) {
	background-color: #E8F5FF;
}

li:nth-child(even)::before {
	background-color: #E8F5FF;
}

h1 {
	border-bottom: 1px solid #000;
	font-size: 36px;
	color: #000;
}

h1:first-letter {
	color: #0094FF;
}

h2 {
	font-size: 24px;
	color: #000;
}

h2:first-letter {
	color: #0094ff;
}

h2 .type {
	color: #0094ff;
}

h3 {
	font-size: 18px;
	font-weight: bold;
}

h3:first-letter {
	color: #0094ff;
}

#exceptionBody {
	width: 50%;
	margin: 0 auto;
}

.exceptionContainer {
	margin: 0 15px 0 15px;
	padding: 5px;
	background-color: #fff;
}
.exceptionInformation li {
	font-weight: normal;
}

.exceptionInformation li::before {
	display: inline-block;
	margin-right: 10px;
	font-weight: bold;
	content: attr(data-field)": ";
}

ol.stacktrace {
	font-family: Consolas, monospace;

}
.stacktrace li {
	font-weight: normal;
}

.stacktrace li::before {
	display: inline-block;
	font-weight: normal;
	text-align: center;
	content: "#"attr(data-field);
}
		</style>
	</head>
	<body>
		<div id="exceptionBody">
			<h1>{\$title}</h1>
			<div class="exceptionContainer">
				{\$userInformation}
				{\$exceptionIDs}
			</div>
			{\$systemInformation}
			{\$exceptions}
		</div>
	</body>
</html>
HTML_TEMPLATE;
	
	/**
	 * @var	string
	 */
	const MESSAGE_TEMPLATE = '<p>{$message}</p>';
	
	/**
	 * @var	string
	 */
	const DATA_TEMPLATE = '<li data-field="{$field}">{$value}</li>';
	
	/**
	 * @var	string
	 */
	const EXCEPTION_TEMPLATE = <<<EXCEPTION
<div class="exceptionContainer">
	<h2>{\$sectionTitle}</h2>
	<ul class="exceptionInformation">
		{\$data}
	</ul>
	{\$trace}
</div>
EXCEPTION;
	
	/**
	 * Handles given exception.
	 * 
	 * @param	\Throwable	$e
	 */
	public function handle(\Throwable $e) {
		// format time.
		$this->dateTime = new \DateTime();
		$this->time = $this->dateTime->format('H:i:s');

		// cast exception to an exception container
		if ($e instanceof \Exception) {
			$this->container = new ExceptionContainer($e);
		}
		
		else if ($e instanceof \Throwable) {
			$this->container = new ExceptionContainer(new ThrowableException($e));
		}

		// send response
		$this->sendHTTPHeader();
		$this->sendHTML($this->handleException($this->container));
	}
	
	/**
	 * Send http headers
	 */
	protected function sendHTTPHeader() {
		@header('HTTP/1.1 503 Module Unavailable');
		@header('Content-Type: text/html; charset=UTF-8');
	}
	
	/**
	 * Send html code.
	 * 
	 * @param	string	$exceptions
	 */
	protected function sendHTML(string $exceptions) {
		// build system information
		$systemInformation = '';
		if (Debug::showFull()) {
			$systemData = $this->parseData('PHP Version', phpversion());
			$systemData .= $this->parseData('Http URI', (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : ''));
			$systemData .= $this->parseData('Referrer', (isset($_SERVER['HTTP_REFERER']) ? str_replace("\n", ' ', $_SERVER['HTTP_REFERER']) : ''));
			$systemData .= $this->parseData('User Agent', (isset($_SERVER['HTTP_USER_AGENT']) ? str_replace("\n", ' ', $_SERVER['HTTP_USER_AGENT']) : ''));
			$systemData .= $this->parseData('Time', $this->time);
			
			$systemInformation = $this->parseExceptionContainer('System Information', $systemData, '');
		}
		
		// search array
		$replace = [
			'{$title}' => StringUtil::encodeHtml($this->getTitle()),
			'{$userInformation}' => $this->getUserInformation(),
			'{$exceptionIDs}' => $this->getExceptionIDs(),
			'{$systemInformation}' => $systemInformation,
			'{$exceptions}'	=> $exceptions
		];
		
		$response = static::HTML_TEMPLATE;
		foreach ($replace as $key => $value) {
			$response = str_replace($key, $value, $response);
		}

		echo $response;
	}
	
	/**
	 * Return title.
	 * 
	 * @return	string
	 */
	protected function getTitle() {
		$title = Debug::language()->getTitles();
		
		return StringUtil::encodeHtml(($this->countExceptions > 1) ? $title[1] : $title[0]);
	}
	
	/**
	 * Return message for users.
	 * 
	 * @return	string
	 */
	protected function getUserInformation() {
		$messages = Debug::language()->getMessages();
		
		$returnValue = '<p>' . StringUtil::encodeHtml($messages[0]) . '</p>';
		if (count($this->exceptionIDs) > 0) {
			$returnValue .= '<p>' . StringUtil::encodeHtml($messages[1]) . '</p>';
		}
		
		return $returnValue;
	}
	
	/**
	 * Return exception ids for user.
	 * @return	string
	 */
	protected function getExceptionIDs() {
		$response = '';
		
		if (count($this->exceptionIDs) > 0) {
			$response = '<ol>';
			foreach ($this->exceptionIDs as $id) {
				$response .= '<li>' . StringUtil::encodeHtml($id) . '</li>';
			}
			$response .= '</ol>';
		}
		
		return $response;
	}
	
	/**
	 * Write given exception to a log and add exception to response.
	 * @param	ExceptionContainer	$e
	 * @param	string				$previousResponse
	 * @return	string
	 */
	protected function handleException(ExceptionContainer $e, string $previousResponse = '') {
		// log errors
		if (($this->writeLog($e) == true)) {
			$this->exceptionIDs[] = $e->getID();
		}
		
		// counter for the exception
		++$this->countExceptions;

		$response = '';
		if (Debug::showFull()) {
			// title
			$title = '<span class="type">[' . StringUtil::encodeHtml($e->getType()) . ']</span> ' . StringUtil::encodeHtml($e->getMessage());
			
			// parse information
			$data = '';
			$data .= $this->parseData('Type', $e->getType());
			$data .= $this->parseData('Message', $e->getMessage());
			$data .= ($e->getCode() != 0) ? $this->parseData('Code', $e->getCode()) : '';
			$data .= $this->parseData('File', $e->getFile());
			$data .= $this->parseData('Line', $e->getLine());
			
			// additional data
			$additionalData = $e->getAdditionalData();
			if (count($additionalData) > 0) {
				foreach ($additionalData as $key => $value) {
					$data .= $this->parseData($key, $value);
				}
			}
			
			// parse trace
			$trace = "<h3>Stacktrace</h3>\n";
			$trace .= $this->parseTrace($e->getTrace());
			
			// prepare response
			$response = $previousResponse;
			$response .= $this->parseExceptionContainer($title, $data, $trace);
		}

		return ($e->getPrev() !== null) ? $this->handleException($e->getPrev(), $response) : $response;
	}
	
	/**
	 * Add user information and system information to response.
	 * 
	 * @param	string	$sectionTitle
	 * @param	string	$data
	 * @param	string	$trace
	 * @return	string
	 */
	protected function parseExceptionContainer(string $sectionTitle, string $data, string $trace) {
		return str_replace(['{$sectionTitle}', '{$data}', '{$trace}'], [$sectionTitle, $data, $trace], static::EXCEPTION_TEMPLATE);
	}
	
	/**
	 * Parse a data field for a exception.
	 * 
	 * @param	string	$field
	 * @param	string	$value
	 * @return	string
	 */
	protected function parseData(string $field, string $value) {
		return str_replace(['{$field}', '{$value}'], [StringUtil::encodeHtml($field), StringUtil::encodeHtml($value)], static::DATA_TEMPLATE);
	}
	
	/**
	 * Write trace to exception message.
	 * 
	 * @param	array	$trace
	 * @return	string
	 */
	protected function parseTrace(array $trace) {
		$printArray = function ($array) {
			$count = count($array);
			if ($count > 5) {
				return $count;
			}
			
			$values = [];
			foreach ($array as $key => $value) {
				$values[] = StringUtil::encodeHtml($key) . ' => ' . gettype($value);
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
					return "'" . addcslashes(StringUtil::encodeHTML($arg), "\\'") . "'";
				case 'boolean':
					return $arg ? 'true' : 'false';
				case 'array':
					return '[' . $printArray($arg) . ']';
				case 'object':
					return get_class($arg);
				default:
					return '[unknown]';
			}
		};
		
		// trace header
		$response = '<ol class="stacktrace">';
		
		// build information
		if (count($trace) > 0) {
			foreach ($trace as $i => $information) {
				$response .= '<li data-field="' . $i . '"><b>';
				$response .= StringUtil::encodeHtml($information['file']) . '(' . StringUtil::encodeHtml($information['line']) . ') ';
				$response .= (!empty($information['class'])) ? ' <i>' . StringUtil::encodeHtml($information['class']) . '::</i>' : '';
				$response .= StringUtil::encodeHtml($information['function']) . '</b>(';
				$response .= implode(', ', array_map($printArgs, $information['args']));
				$response .= ')</li>';
			}
		}
		else {
			$response .= '<li data-field="1">{main}</li>';
		}

		// trace footer
		$response .= '</ol>';
		
		return $response;
	}
	
	/**
	 * Write Exception to log.
	 * 
	 * @param	\Re\Debug\Exception\ExceptionContainer	$e
	 * @return	boolean
	 */
	protected function writeLog(ExceptionContainer $e) {
		// a log failed. Return immediately .
		if ($this->logFailed === true) return false;

		// no logger is set, return immediately.
		if ($this->logger === null && Debug::getLogger() === null) return false;

		// no logger in handler, logger added to debug handler.
		if ($this->logger === null && Debug::getLogger() !== null) {
			$this->logger = Debug::getLogger();
			$this->textFormatter = new ExceptionTextFormatter();
		}

		// render text for log.
		$message = $this->textFormatter->renderText($e);

		// log exception
		try {
			$this->logger->error($message);
		}
		catch (\Exception $e) {
			return $this->logFailed = true;
		}

		return true;
	}
}
