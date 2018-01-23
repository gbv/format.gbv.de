<?php
namespace Re\Util;

// imports
use Symfony\Component\Filesystem\Filesystem;

/**
 * Helpful functions for work with files and folders.
 * 
 * @package Teralios Web Publisher
 * @author Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license GPLv3
 */
final class File {
	/**
	 * @var	\finfo
	 */
	protected static $finfo = null;

	/**
	 * Formats given bytes.
	 *
	 * @param	integer	$bytes
	 * @param	bool	$binary
	 * @return	string
	 */
	public static function formatFileSize(int $bytes, bool $binary = true) {
		$prefix = [
			1000 => ['Bytes', 'kB', 'MB', 'GB', 'TB'],
			1024 => ['Bytes', 'KiB', 'MiB', 'GiB', 'TiB']
		];

		$divisor = ($binary === true) ? 1024 : 1000;
		$rounds = count($prefix[$divisor]);

		for ($i = 0; $i < $rounds; $i++) {
			if ($bytes < $divisor) {
				break;
			}

			$bytes /= $divisor;
		}

		return round($bytes, 2) . ' ' . $prefix[$divisor][$i];
	}

	/**
	 * Adds a slash to the end of a path.
	 * 
	 * @param	string	$path
	 * @return	string
	 */
	public static function addSeparator(string $path) {
		return rtrim($path, '/').'/';
	}

	/**
	 * Removes slash from the end of a path.
	 *
	 * @param	string	$path
	 * @return	string
	 */
	public static function removeTrailingSlash(string $path) {
		return rtrim($path, '/');
	}
	
	/**
	 * Unify dir separators.
	 * 
	 * @param	string	$path
	 * @return	mixed
	 */
	public static function unifyPath(string $path) {
		$path = str_replace("\\\\", "/", $path);
		$path = str_replace("\\", "/", $path);
		
		return $path;
	}
	
	/**
	 * Make a path relative and adds the file name to the end.
	 * 
	 * @param	string	$endPath
	 * @param	string	$startPath
	 * @return	string
	 */
	public static function makeRelative(string $endPath, string $startPath) {
		// unify paths
		$endPath = static::unifyPath($endPath);
		$startPath = static::unifyPath($startPath);
		
		$filesystem = new Filesystem();
		return $filesystem->makePathRelative(static::unifyPath($endPath), static::unifyPath($startPath));
	}

	/**
	 * Returns mime type of given file.
	 *
	 * @param	string	$filename
	 * @return	string
	 */
	public static function getMimeType(string $filename) {
		if (self::$finfo === null) {
			if (!class_exists('\finfo', false)) {
				self::$finfo = false;

				return 'application/octet-stream';
			}

			self::$finfo = new \finfo(FILEINFO_MIME_TYPE);
		}

		return self::$finfo->file($filename) ?: 'application/octet-stream';
	}
}
