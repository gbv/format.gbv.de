<?php
namespace GBV\Exception;

// import
use Symfony\Component\HttpFoundation\Response;

/**
 * Http Exception.
 * @package        PicaHelpRest
 * @author         Karsten (Teralios) Achterrath
 * @copyright      ©2018 GBV VZG
 * @license        GPLv3
 */
class HttpException extends \Exception {
	/**
	 * HttpException constructor.
	 *
	 * @param	int	$code
	 */
	public function __construct(int $code) {
		if (isset(Response::$statusTexts[$code])) {
			parent::__construct(Response::$statusTexts[$code], $code);
		}
		else {
			parent::__construct(Response::$statusTexts[503], 503);
		}
	}
}