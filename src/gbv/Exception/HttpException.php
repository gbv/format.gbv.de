<?php
namespace GBV\Exception;

// import
use Symfony\Component\HttpFoundation\Response;

/**
 * Http Exception.
 *
 * @package		PicaHelpRest
 * @author		Karsten Achterrath <karsten.achterrath@gbv.de>
 * @copyright	©$2018 GBV VZG <https://www.gbv.de>
 * @license		GPLv3 <https://www.gnu.org/licenses/gpl-3.0.txt>
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