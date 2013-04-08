<?php
/*
 	Simple Thumb created by Amaury BALMER.

	Based on MimThumb script created by Tim McDaniels and Darren Hoyt with tweaks by Ben Gillbanks
		http://code.google.com/p/timthumb/	
		MIT License: http://www.opensource.org/licenses/mit-license.php


	Parameters
	---------
	w: width
	h: height
	zc: zoom crop (0 or 1)
	q: quality (default is 75 and max is 100)
	
	HTML example: <img src="/scripts/simple-thumb.php?src=/images/whatever.jpg&w=150&h=200&zc=1" alt="" />
*/

/*
$sizeLimits = array(
	"100x100",
	"150x150",
);
*/

require (dirname ( __FILE__ ) . '/phpthumb-latest/ThumbLib.inc.php');

if (!function_exists('apache_request_headers')) {
    eval('
        function apache_request_headers() {
            foreach($_SERVER as $key=>$value) {
                if (substr($key,0,5)=="HTTP_") {
                    $key=str_replace(" ","-",ucwords(strtolower(str_replace("_"," ",substr($key,5)))));
                    $out[$key]=$value;
                }
            }
            return $out;
        }
    ');
} 

//define ( 'CACHE_SIZE', 99999999 ); // number of files to store before clearing cache
//define ( 'CACHE_CLEAR', 5 ); // maximum number of files to delete on each cache clear
define ( 'VERSION', '1.1-3.1' ); // version number (to force a cache refresh) + version thumb library
define ( 'MEMORY_LIMIT', '32M' );

$thumb = new SimpleThumb ( );
class SimpleThumb {
	// Folder for cache and external
	private $cache_dir = '';
	private $external_dir = '';
	
	// Request datas
	private $src = '';
	private $width = 0;
	private $height = 0;
	private $zoom_crop = 1;
	private $quality = '80';
	private $blog_id = 0;
	private $filters = '';
	
	// File datas
	private $last_modified = '';
	private $cache_file;
	
	function SimpleThumb() {
		$this->init ();
		$this->request ();
	}
	
	function init() {
		// Init paths for cache
		$this->cache_dir = dirname(__FILE__) . '/../../../thumb-cache/cache';
		$this->external_dir = dirname(__FILE__) . '/../../../thumb-cache/external';
		
		// Allow work on big image
		if (function_exists ( 'memory_get_usage' ) && (( int ) @ini_get ( 'memory_limit' ) < abs ( intval ( MEMORY_LIMIT ) )))
			@ini_set ( 'memory_limit', MEMORY_LIMIT );
			
		// Get all properties
		$this->width = preg_replace ( "/[^0-9]+/", "", $this->getRequest ( "w", 0 ) );
		$this->height = preg_replace ( "/[^0-9]+/", "", $this->getRequest ( "h", 0 ) );
		$this->zoom_crop = preg_replace ( "/[^0-9]+/", "", $this->getRequest ( "zc", 1 ) );
		$this->quality = preg_replace ( "/[^0-9]+/", "", $this->getRequest ( "q", 80 ) );
		$this->blog_id = preg_replace ( "/[^0-9]+/", "", $this->getRequest ( "id", 0 ) );
		$this->filters = $this->getRequest ( "f", "" );
		
		// Update path if WPmu need subfolder
		if ( $this->blog_id != 0 ) {
			$this->cache_dir .= '/blog-'.$this->blog_id;
			$this->external_dir .= '/blog-'.$this->blog_id;
			
			if ( !is_dir($this->cache_dir) ) 	mkdir( $this->cache_dir );				
			if ( !is_dir($this->external_dir) ) mkdir( $this->external_dir );				
		}
		// Set minimum size if image dimension = 0
		if ($this->width == 0 && $this->height == 0) {
			$this->width = 100;
			$this->height = 100;
		}
	}
	
	function request() {
		// sort out image source
		$src = $this->getRequest ( "src", "" );
		if (empty ( $src ) || strlen ( $src ) <= 3) {
			$this->displayError ( "no image specified" );
		}
		
		// clean params before use
		$src = $this->cleanSource ( $src );
	
		// last modified time (for caching)
		$this->last_modified = filemtime ( $src );
		
		// get mime type of src
		$mime_type = $this->mimeType ( $src );
		
		// check to see if this image is in the cache already
		$this->checkCache ( $mime_type );
		
		// if not in cache then clear some space and generate a new file
		// $this->cleanCache ();
		
		// make sure that the src is gif/jpg/png
		if (! $this->validSrcMimeType ( $mime_type )) {
			$this->displayError ( "Invalid src mime type: " . $mime_type );
		}
		
		if (strlen ( $src ) && is_file ( $src )) {
			
			$this->buildThumb ( $src );
		
		} else {
			
			if (strlen ( $src )) {
				$this->displayError ( "image " . $src . " not found" );
			} else {
				$this->displayError ( "no source specified" );
			}
		
		}
	}
	
	/**
	 * Use class PhpThumbFactory for build and display the thumb for the first time.
	 *
	 * @param unknown_type $src
	 * @return unknown
	 */
	function buildThumb($src = '') {
	

		try {
			$thumb = PhpThumbFactory::create ( $src, array ('jpegQuality' => $this->quality ) );
		} catch ( Exception $e ) {
			// handle error here however you'd like
			$this->displayError ( sprintf ( "You must have either the GD or iMagick extension loaded to use this library. Error %s", $e ) );
			return false;
		}
		
		if ($this->zoom_crop == 1) {
			$thumb->adaptiveResize ( $this->width, $this->height );
		} else {
			$thumb->resize ( $this->width, $this->height );
		}
		
		// Save thumb ?
		if ($this->isWritable () == true) {
			$thumb->save ( $this->getCacheFile (), 'png' );
		}
		
		// Display thumb
		$thumb->show ();
		exit();
		
		return true;
	}
	
	/**
	 * 
	 */
	function isWritable() {
		// check to see if we can write to the cache directory
		$cache_file_name = $this->getCacheFile ();

		if (touch ( $cache_file_name )) {
			
			// give 666 permissions so that the developer 
			// can overwrite web server user
			chmod ( $cache_file_name, 0666 );
			return true;
		
		}
		return false;
	}
	
	/**
	 * 
	 */
	function getRequest($property, $default = 0) {
		
		if (isset ( $_REQUEST [$property] )) {
			
			return $_REQUEST [$property];
		
		} else {
			
			return $default;
		
		}
	
	}
	
	/**
	 * clean out old files from the cache
	 * you can change the number of files to store and to delete per loop in the defines at the top of the code
	 */
	function cleanCache() {
		
		$files = glob ( $this->cache_dir . "/*", GLOB_BRACE );
		
		$yesterday = time () - (24 * 60 * 60);
		
		if (count ( $files ) > 0) {
			
			usort ( $files, array (&$this, "filemtimeCompare" ) );
			$i = 0;
			
			if (count ( $files ) > CACHE_SIZE) {
				
				foreach ( $files as $file ) {
					
					$i ++;
					
					if ($i >= CACHE_CLEAR) {
						return;
					}
					
					if (filemtime ( $file ) > $yesterday) {
						return;
					}
					
					unlink ( $file );
				
				}
			
			}
		
		}
	
	}
	
	/**
	 * compare the file time of two files
	 */
	function filemtimeCompare($a, $b) {
		return filemtime ( $a ) - filemtime ( $b );
	}
	
	/**
	 * determine the file mime type
	 */
	function mimeType($file) {
		
		if (stristr ( PHP_OS, 'WIN' )) {
			$os = 'WIN';
		} else {
			$os = PHP_OS;
		}
		
		$mime_type = '';
		
		if (function_exists ( 'mime_content_type' )) {
			$mime_type = mime_content_type ( $file );
		}
		
		// use PECL fileinfo to determine mime type
		if (! $this->validSrcMimeType ( $mime_type )) {
			if (function_exists ( 'finfo_open' )) {
				$finfo = finfo_open ( FILEINFO_MIME );
				$mime_type = finfo_file ( $finfo, $file );
				finfo_close ( $finfo );
			}
		}
		
		// try to determine mime type by using unix file command
		// this should not be executed on windows
		if (! $this->validSrcMimeType ( $mime_type ) && $os != "WIN") {
			if (preg_match ( "/FREEBSD|LINUX/", $os )) {
				$mime_type = trim ( @shell_exec ( 'file -bi "' . $file . '"' ) );
			}
		}
		
		// use file's extension to determine mime type
		if (! $this->validSrcMimeType ( $mime_type )) {
			
			// set defaults
			$mime_type = 'image/png';
			// file details
			$fileDetails = pathinfo ( $file );
			$ext = strtolower ( $fileDetails ["extension"] );
			// mime types
			$types = array ('jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif' );
			
			if (strlen ( $ext ) && strlen ( $types [$ext] )) {
				$mime_type = $types [$ext];
			}
		
		}
		
		return $mime_type;
	
	}
	
	/**
	 * 
	 */
	function validSrcMimeType($mime_type) {
		if (preg_match ( "/jpg|jpeg|gif|png/i", $mime_type )) {
			return true;
		}
		return false;
	}
	
	/**
	 * 
	 */
	function checkCache($mime_type) {
		// make sure cache dir exists
		if (! is_dir ( $this->cache_dir )) {
			// give 777 permissions so that developer can overwrite
			// files created by web server user
			mkdir ( $this->cache_dir );
			chmod ( $this->cache_dir, 0777 );
		}
		
		// make sure external dir exists
		if (! is_dir ( $this->external_dir )) {
			// give 777 permissions so that developer can overwrite
			// files created by web server user
			mkdir ( $this->external_dir );
			chmod ( $this->external_dir, 0777 );
		}

		$this->showCacheFile ( $mime_type );
	}
	
	/**
	 * 
	 */
	function showCacheFile() {
		$this->cache_file = $this->cache_dir . '/' . $this->getCacheFile ();					
		if (is_file ( $this->cache_file )) {
		
			// Getting headers sent by the client.
			$headers = apache_request_headers();
			
			// Checking if the client is validating his cache and if it is current.
			if (isset($headers['If-Modified-Since']) && (strtotime($headers['If-Modified-Since']) == filemtime($this->cache_file))) {
				// Client's cache IS current, so we just respond '304 Not Modified'.
				header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($fn)).' GMT', true, 304);
			} else {
				// Image not cached or cache outdated, we respond '200 OK' and output the image.
				header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($fn)).' GMT', true, 200);
				header('Content-Length: '.filesize($this->cache_file));
				header('Content-Type: image/png');
				print file_get_contents($this->cache_file);
			}


			// send headers then display image
			/*
			header ( "Content-Type: image/png" );
			header ( "Accept-Ranges: bytes" );
			header ( "Last-Modified: " . $gmdate_mod );
			header ( "Content-Length: " . $fileSize );
			header ( "Cache-Control: max-age=9999, must-revalidate" );
			header ( "Expires: " . $gmdate_mod );
			*/
			
			exit ();
		
		}
	}
	
	/**
	 * 
	 */
	function getCacheFile() {
		if (empty ( $this->cache_file )) {
			$cachename = $_SERVER ['QUERY_STRING'] . VERSION . $this->last_modified;
			$this->cache_file = md5 ( $cachename ) . '.png';
		}
		
		return $this->cache_file;
	}
	
	/**
	 * tidy up the image source url
	 */
	function cleanSource($src) {
		
		// remove slash from start of string
		if (strpos ( $src, "/" ) == 0) {
			$src = substr ( $src, - (strlen ( $src ) - 1) );
		}
		
		// remove http/ https/ ftp
		$src = preg_replace ( "/^((ht|f)tp(s|):\/\/)/i", "", $src );
		
		// remove domain name from the source url
		$host = $_SERVER ["HTTP_HOST"];
		$src = str_replace ( $host, "", $src );
		$host = str_replace ( "www.", "", $host );
		$src = str_replace ( $host, "", $src );
		
		// don't allow users the ability to use '../' 
		// in order to gain access to files below document root
		

		// src should be specified relative to document root like:
		// src=images/img.jpg or src=/images/img.jpg
		// not like:
		// src=../images/img.jpg
		$src = preg_replace ( "/\.\.+\//", "", $src );
		
		// get path to image on file system
		$doc_root = $this->getDocumentRoot( $src );
		if (is_array ( $doc_root )) {
			$src = $this->external_dir . '/' . current ( $doc_root );
		} else {
			$src = $doc_root . '/' . $src;
		}
		
		return $src;
	
	}
	
	/**
	 * 
	 */
	function getDocumentRoot($src) {
		// check for unix servers
		if (@is_file ( $_SERVER ['DOCUMENT_ROOT'] . '/' . $src )) {
			return $_SERVER ['DOCUMENT_ROOT'];
		}
		
		// check from script filename (to get all directories to timthumb location)
		$parts = array_diff ( explode ( '/', $_SERVER ['SCRIPT_FILENAME'] ), explode ( '/', $_SERVER ['DOCUMENT_ROOT'] ) );
		$path = $_SERVER ['DOCUMENT_ROOT'] . '/';
		foreach ( $parts as $part ) {
			$path .= $part . '/';
			if (is_file ( $path . $src )) {
				return $path;
			}
		}
		
		// the relative paths below are useful if timthumb is moved outside of document root
		// specifically if installed in wordpress themes like mimbo pro:
		// /wp-content/themes/mimbopro/scripts/timthumb.php
		$paths = array (".", "..", "../..", "../../..", "../../../..", "../../../../.." );
		foreach ( ( array ) $paths as $path ) {
			if (is_file ( $path . '/' . $src )) {
				return $path;
			}
		}
		
		// special check for microsoft servers
		if (! isset ( $_SERVER ['DOCUMENT_ROOT'] )) {
			$path = str_replace ( "/", "\\", $_SERVER ['ORIG_PATH_INFO'] );
			$path = str_replace ( $path, "", $_SERVER ['SCRIPT_FILENAME'] );
			
			if (is_file ( $path . '/' . $src )) {
				return $path;
			}
		}
		
		// File exist on external foler
		$local_filename = preg_replace ( "/[^a-zA-Z0-9.]+/", "", $src );
		
		if (is_file ( $this->external_dir .'/'. $local_filename )) {
			return array ($local_filename );
		} else {
			// Try to retrieve image from web
			$cc = new cURL ( );
			$image = $cc->get ( $src );
			unset ( $cc );
			
			file_put_contents ( $this->external_dir . '/' . $local_filename, $image );
			unset ( $image );
			
			if (is_file ( $this->external_dir . '/' . $local_filename )) {
				return array ($local_filename );
			}
		}
		
		$this->displayError ( 'file not found ' . $src );
		return false;
	}
	
	/**
	 * generic error message
	 */
	function displayError($errorString = '') {
		header ( 'HTTP/1.1 400 Bad Request' );
		die ( $errorString );
	}
}

class cURL {
	private $headers;
	private $user_agent;
	private $compression;
	
	function cURL($compression = 'gzip') {
		$this->headers [] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/jpeg, image/png';
		$this->headers [] = 'Connection: Keep-Alive';
		$this->headers [] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
		$this->user_agent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)';
		$this->compression = $compression;
	}
	
	function get($url) {
		$process = curl_init ( $url );
		
		curl_setopt ( $process, CURLOPT_HTTPHEADER, $this->headers );
		curl_setopt ( $process, CURLOPT_HEADER, 0 );
		curl_setopt ( $process, CURLOPT_USERAGENT, $this->user_agent );
		curl_setopt ( $process, CURLOPT_ENCODING, $this->compression );
		curl_setopt ( $process, CURLOPT_TIMEOUT, 30 );
		curl_setopt ( $process, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $process, CURLOPT_FOLLOWLOCATION, 1 );
		$return = curl_exec ( $process );
		curl_close ( $process );
		
		return $return;
	}
}
?>