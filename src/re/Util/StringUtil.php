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
	const HTML_PATTERN = '~</?[a-z]+[1-6]?
			(?:\s*[a-z\-]+\s*(=\s*(?:
			"[^"\\\\]*(?:\\\\.[^"\\\\]*)*"|\'[^\'\\\\]*(?:\\\\.[^\'\\\\]*)*\'|[^\s>]
			))?)*\s*/?>~ix';
	const HTML_COMMENT_PATTERN = '~<!--(.*?)-->~';

	/**
	 * utf8 bytes of the HORIZONTAL ELLIPSIS (U+2026)
	 * @var	string
	 */
	const HELLIP = "\xE2\x80\xA6";

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

	/**
	 * Strips HTML tags from a string.
	 *
	 * @author	Oliver Kliebisch, Marcel Werk
	 * @copyright	2001-2017 WoltLab GmbH
	 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
	 *
	 * @param	string		$string
	 * @return	string
	 */
	public static function stripHTML(string $string) {
		return preg_replace(self::HTML_PATTERN, '', preg_replace(self::HTML_COMMENT_PATTERN, '', $string));
	}

	/**
	 * Truncates the given string to a certain number of characters.
	 *
	 * @author	Oliver Kliebisch, Marcel Werk
	 * @copyright	2001-2017 WoltLab GmbH
	 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
	 *
	 * @param	string		$string		string which shall be truncated
	 * @param	integer		$length		string length after truncating
	 * @param	string		$etc		string to append when $string is truncated
	 * @param	boolean		$breakWords	should words be broken in the middle
	 * @return	string				truncated string
	 */
	public static function truncate(string	$string, int $length = 80, string $etc = self::HELLIP, bool $breakWords = false) {
		if ($length == 0) {
			return '';
		}

		if (mb_strlen($string) > $length) {
			$length -= mb_strlen($etc);

			if (!$breakWords) {
				$string = preg_replace('/\\s+?(\\S+)?$/', '', mb_substr($string, 0, $length + 1));
			}

			return mb_substr($string, 0, $length).$etc;
		}
		else {
			return $string;
		}
	}

	/**
	 * Truncates a string containing HTML code and keeps the HTML syntax intact.
	 *
	 * @author	Oliver Kliebisch, Marcel Werk
	 * @copyright	2001-2017 WoltLab GmbH
	 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
	 *
	 * @param	string		$string			string which shall be truncated
	 * @param	integer		$length			string length after truncating
	 * @param	string		$etc			ending string which will be appended after truncating
	 * @param	boolean		$breakWords		if false words will not be split and the return string might be shorter than $length
	 * @return	string					truncated string
	 */
	public static function truncateHTML(string $string, int $length = 500, string $etc = self::HELLIP, bool $breakWords = false) {
		if (mb_strlen(self::stripHTML($string)) <= $length) {
			return $string;
		}
		$openTags = [];
		$truncatedString = '';

		// initialize length counter with the ending length
		$totalLength = mb_strlen($etc);

		preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $string, $tags, PREG_SET_ORDER);

		foreach ($tags as $tag) {
			// ignore void elements
			if (!preg_match('/^(area|base|br|col|embed|hr|img|input|keygen|link|menuitem|meta|param|source|track|wbr)$/s', $tag[2])) {
				// look for opening tags
				if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
					array_unshift($openTags, $tag[2]);
				}
				/**
				 * look for closing tags and check if this tag has a corresponding opening tag
				 * and omit the opening tag if it has been closed already
				 */
				else if (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
					$position = array_search($closeTag[1], $openTags);
					if ($position !== false) {
						array_splice($openTags, $position, 1);
					}
				}
			}
			// append tag
			$truncatedString .= $tag[1];

			// get length of the content without entities. If the content is too long, keep entities intact
			$decodedContent = self::decodeHTML($tag[3]);
			$contentLength = mb_strlen($decodedContent);
			if ($contentLength + $totalLength > $length) {
				if (!$breakWords) {
					if (preg_match('/^(.{1,'.($length - $totalLength).'}) /s', $decodedContent, $match)) {
						$truncatedString .= self::encodeHTML($match[1]);
					}

					break;
				}

				$left = $length - $totalLength;
				$entitiesLength = 0;
				if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $tag[3], $entities, PREG_OFFSET_CAPTURE)) {
					foreach ($entities[0] as $entity) {
						if ($entity[1] + 1 - $entitiesLength <= $left) {
							$left--;
							$entitiesLength += mb_strlen($entity[0]);
						}
						else {
							break;
						}
					}
				}
				$truncatedString .= mb_substr($tag[3], 0, $left + $entitiesLength);
				break;
			}
			else {
				$truncatedString .= $tag[3];
				$totalLength += $contentLength;
			}
			if ($totalLength >= $length) {
				break;
			}
		}

		// close all open tags
		foreach ($openTags as $tag) {
			$truncatedString .= '</'.$tag.'>';
		}

		// add etc
		$truncatedString .= $etc;

		return $truncatedString;
	}
}
