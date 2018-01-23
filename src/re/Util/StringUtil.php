<?php
namespace Re\Util;

/**
 * Contains some functions for working with strings.
 * 
 * @package Teralios Web Publisher
 * @author Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license GPLv3
 */
final class StringUtil {
	public static function getRandomID() {
		return sha1(uniqid(mt_rand(), true) . microtime());
	}

	/**
	 * Replace windows and mac os new lines with unix new lines.
	 * 
	 * @param	string	$string
	 * @return	string
	 */
	public static function unifyNewlines(string $string) {
		return preg_replace("%(\r\n)|(\r)%", "\n", $string);
	}

	/**
	 * Trim whitespace signs.
	 * 
	 * @param	string	$string
	 * @return	string
	 */
	public static function trim(string $string) {
		$string = preg_replace('%^[\p{Zs}\s]+%u', '', $string);
		$string = preg_replace('%[\p{Zs}\s]+$%u', '', $string);
		return $string;
	}
	
	/**
	 * Encodes html.
	 * 
	 * @param	string	$string
	 * @return	string
	 */
	public static function encodeHtml(string $string) {
		return @htmlspecialchars($string, ENT_COMPAT, 'UTF-8');
	}

	/**
	 * Decodes html entities.
	 *
	 * @param	string		$string
	 * @return	string
	 */
	public static function decodeHTML(string $string) {
		$string = str_ireplace('&nbsp;', ' ', $string); // convert non-breaking spaces to ascii 32; not ascii 160
		return @html_entity_decode($string, ENT_COMPAT, 'UTF-8');
	}

	/**
	 * Checks given string for only ascii.
	 * 
	 * @param	string	$string
	 * @return	boolean
	 */
	public static function isASCII(string $string) {
		return (preg_match('%^[\x00-\x7F]*$%', $string)) ? true : false;
	}

	/**
	 * Checks given string for utf-8 encoding.
	 * @see https://www.w3.org/International/questions/qa-forms-utf-8
	 * 
	 * @param	string	$string
	 * @return	boolean
	 */
	public static function isUTF8(string $string) {
		return (preg_match('%^(
			[\x09\x0A\x0D\x20-\x7E]*		# ASCII
		|	[\xC2-\xDF][\x80-\xBF]			# non-overlong 2-byte
		|	\xE0[\xA0-\xBF][\x80-\xBF]		# excluding overlongs
		|	[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}	# straight 3-byte
		|	\xED[\x80-\x9F][\x80-\xBF]		# excluding surrogates
		|	\xF0[\x90-\xBF][\x80-\xBF]{2}		# planes 1-3
		|	[\xF1-\xF3][\x80-\xBF]{3}		# planes 4-15
		|	\xF4[\x80-\x8F][\x80-\xBF]{2}		# plane 16
		)*$%x', $string)) ? true : false;
	}
}
