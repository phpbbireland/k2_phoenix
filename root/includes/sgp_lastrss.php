<?php
/**
* Simple yet powerfull PHP class to parse RSS files.
* copyright (c) 2007 Jiri Smika (Smix) http://phpbb3.smika.net
* (c) 2003-2004 original lastRSS by Vojtech Semecky http://lastrss.oslab.net/
*
* Ported and rewritten for PhpBB3 and Kiss Portal & Stargate Portal by: NeXur
*
* @package Kiss Portal Engine / Stargate Portal
* @version $Id$
* @copyright (c) 2008 Martin Larsson - aka NeXur
* @copyright (c) 2005-2013 phpbbireland
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

//define('IN_PHPBB', true); // mvp?

class lastRSS
{
	// -------------------------------------------------------------------
	// Public properties
	// -------------------------------------------------------------------
	var $default_cp = 'UTF-8';
	var $CDATA = 'strip';
	var $cp = 'UTF-8';
	var $rsscp = 'UTF-8';
	var $items_limit = 0;
	var $stripHTML = true;
	var $date_format = 'U';
	var $cache_dir = '';
	var $type = '';

	// -------------------------------------------------------------------
	// Private variables
	// -------------------------------------------------------------------
	var $channeltags = array ('title', 'link', 'description', 'language', 'copyright', 'managingEditor', 'webMaster', 'lastBuildDate', 'rating', 'docs');
	var $itemtags = array('title', 'link', 'author', 'category', 'comments', 'enclosure', 'guid', 'pubDate', 'source');
	var $imagetags = array('title', 'url', 'link', 'width', 'height');
	var $textinputtags = array('title', 'description', 'name', 'link');
	// -------------------------------------------------------------------
	// Parse RSS file and returns associative array.
	// -------------------------------------------------------------------
	/**
	* Get RSS (URL) with curl
	*/
	function curl_get_rss($url)
	{
		global $rss, $user;

		// initiate and set options
		if (isset($url))
		{
			$ch = curl_init($url);
		}

		if (isset($ch))
		{
			@curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
			@curl_setopt( $ch, CURLOPT_FAILONERROR, 1);
			@curl_setopt( $ch, CURLOPT_NOPROGRESS, 0);
			@curl_setopt( $ch, CURLOPT_HEADER, 0);
			@curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
			@curl_setopt( $ch, CURLOPT_ENCODING, '');
			@curl_setopt( $ch, CURLOPT_USERAGENT, 'lastRSS');

			// initial connection timeout
			@curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 5);

			// setting this to higher means longer time for loading the page for user!
			@curl_setopt( $ch, CURLOPT_TIMEOUT, 60);
			@curl_setopt( $ch, CURLOPT_MAXREDIRS, 0);

			// get content
			$content = @curl_exec($ch);
			$err = @curl_errno($ch);
			$errmsg = @curl_error($ch);
			$header = @curl_getinfo($ch);

			if (curl_errno($ch))
			{
				// error in getting content
				return $items = array();
			}
			else
			{
				return $content;
			}
			@curl_close($ch);
		}
	}

	function Get ($rss_url)
	{
		// If CACHE ENABLED
		if ($this->cache_dir != '')
		{
			$cache_file = $this->cache_dir . '/rsscache_' . md5($rss_url) . '.dat';
			//chmod ($cache_file, 0666);
			$timedif = @(time() - filemtime($cache_file));
			if ($timedif < $this->cache_time)
			{
				// cached file is fresh enough, return cached array
				$result = unserialize(join('', file($cache_file)));
				// set 'cached' to 1 only if cached file is correct
				if ($result)
				{
					$result['cached'] = 1;
				}
			}
			else
			{
				// cached file is too old, create new
				$result = $this->Parse($rss_url);
				$serialized = serialize($result);
				if ($f = @fopen($cache_file, 'wb+'))
				{
					fwrite ($f, $serialized, strlen($serialized));
					fclose($f);
					chmod ($cache_file, 0666);
				}
				if ($result)
				{
					$result['cached'] = 0;
				}
			}
		}
		// If CACHE DISABLED >> load and parse the file directly
		else
		{
			$result = $this->Parse($rss_url);
			if ($result) $result['cached'] = 0;
		}
		// return result
		return $result;
	}

	// -------------------------------------------------------------------
	// Modification of preg_match(); return trimed field with index 1
	// from 'classic' preg_match() array output
	// -------------------------------------------------------------------
	function my_preg_match($pattern, $subject)
	{
		// start regullar expression
		preg_match($pattern, $subject, $out);
		// if there is some result... process it and return it
		if (isset($out[1]))
		{
			// cdata
			$out[1] = strtr($out[1], array('<![CDATA['=>'', ']]>'=>''));
  			if ((isset($this->rsscp))&&($this->rsscp != 'UTF-8'))
			{
				// recode with phpBB functions
				$out[1] = utf8_recode($out[1],$this->rsscp);
			}

			// Return result
			return trim($out[1]);
		}
		else
		{
			// if there is NO result, return empty string
			return('');
		}
	}
	// -------------------------------------------------------------------
	// Replace HTML entities &something; by real characters
	// -------------------------------------------------------------------
	function unhtmlentities ($string)
	{
		// Get HTML entities table
		$trans_tbl = get_html_translation_table (HTML_ENTITIES, ENT_QUOTES);
		// Flip keys<==>values
		$trans_tbl = array_flip ($trans_tbl);
		// Add support for &apos; entity (missing in HTML_ENTITIES)
		$trans_tbl += array('&apos;' => "'");
		// Replace entities by values
		return strtr($string, $trans_tbl);
	}

	// -------------------------------------------------------------------
	// Parse() is private method used by Get() to load and parse RSS file.
	// Don't use Parse() in your scripts - use Get($rss_file) instead.
	// -------------------------------------------------------------------
	function parse($rss_url)
	{
		global $rss, $user;

		// open and load RSS file
		// use curl if enabled
		if (function_exists('curl_init') && $rss->type == 'curl')
		{
			$rss_content = $this->curl_get_rss($rss_url);
		}
		else if (ini_get('allow_url_fopen') == '1' && $rss->type == 'fopen')
		{
			// else use fopen if possible
			if ($f = @fopen($rss_url, 'r'))
			{
				$rss_content = '';
				while (!feof($f))
				{
					@$rss_content .= fgets($f, 4096);
				}
				fclose($f);
			}
		}

		//if download was succesfull
		if (isset($rss_content) && (sizeof($rss_content)>0))
		{
			// parse document encoding
			$result['encoding'] = $this->my_preg_match("'encoding=[\'\"](.*?)[\'\"]'si", $rss_content);
  		  	// if document encoding is specified, use it
			if (isset($result['encoding']) && ($result['encoding'] != '') )
			{
				$this->rsscp = $result['encoding'];
			}
			else
			{
				// otherwise use the default encoding
				$this->rsscp = $this->default_cp;
			}
			// parse channel info
			preg_match("'<channel.*?>(.*?)</channel>'si", $rss_content, $out_channel);

			foreach ($this->channeltags as $channeltag)
			{
				$temp = @$this->my_preg_match("'<$channeltag.*?>(.*?)</$channeltag>'si", $out_channel[1]);
				if (isset($temp))
				{
					$result[$channeltag] = $temp;
				}
			}

			// If date_format is specified and lastBuildDate is valid
			if ($this->date_format != '' && ($timestamp = strtotime($result['lastBuildDate'])) !==-1)
			{
				// convert lastBuildDate to specified date format
				$result['lastBuildDate'] = date($this->date_format, $timestamp);
			}


			// parse textinput info
			// This a little strange regexp means:
			// Look for tag <textinput> with or without any attributes, but skip truncated version <textinput /> (it's not beggining tag)
			preg_match("'<textinput(|[^>]*[^/])>(.*?)</textinput>'si", $rss_content, $out_textinfo);
			if (isset($out_textinfo[2]))
			{
				foreach ($this->textinputtags as $textinputtag)
				{
					$temp = $this->my_preg_match("'<$textinputtag.*?>(.*?)</$textinputtag>'si", $out_textinfo[2]);
					if (isset($temp))
					{
						$result['textinput_'.$textinputtag] = $temp;
					}
				}
			}
			// parse images
			preg_match("'<image.*?>(.*?)</image>'si", $rss_content, $out_imageinfo);
			if (isset($out_imageinfo[1]))
			{
				foreach ($this->imagetags as $imagetag)
				{
					$temp = $this->my_preg_match("'<$imagetag.*?>(.*?)</$imagetag>'si", $out_imageinfo[1]);
					if ($temp != '')
					{
						$result['image_'.$imagetag] = $temp;
					}
				}
			}
			// parse items
			preg_match_all("'<item(| .*?)>(.*?)</item>'si", $rss_content, $items);

			//Added to read entry if format changed Ref: http://www.phpbbireland.com/phpBB3/viewtopic.php?p=16993#p16993
			if (empty($items[2]))
			{
				preg_match_all("'<entry(| .*?)>(.*?)</entry>'si", $rss_content, $items);
			}


			$rss_items = $items[2];
			// init item counter
			$i = 0;
			$result['items'] = array(); // create array even if there are no items
			foreach ($rss_items as $rss_item)
			{
				// If number of items is lower then limit: parse one item
				if ($i < $this->items_limit || $this->items_limit == 0)
				{
					foreach ($this->itemtags as $itemtag)
					{
						$temp = $this->my_preg_match("'<$itemtag.*?>(.*?)</$itemtag>'si", $rss_item);
						if (isset($temp))
						{
							$result['items'][$i][$itemtag] = $temp;
						}
					}
					// item title
					if ($this->stripHTML && isset($result['items'][$i]['title']))
					{
						$result['items'][$i]['title'] = strip_tags($this->unhtmlentities(strip_tags($result['items'][$i]['title'])));
					}

					// item description
					if ($this->stripHTML && isset($result['items'][$i]['description']))
					{
						$result['items'][$i]['description'] = strip_tags($this->unhtmlentities(strip_tags($result['items'][$i]['description'])));
					}

					// If pubDate exists
					if ((isset($result['items'][$i]['pubDate']) && ($result['items'][$i]['pubDate'] != '') ))
					{
						// ... and is valid
						if ((($timestamp = strtotime($result['items'][$i]['pubDate'])) !== -1) && (($timestamp = strtotime($result['items'][$i]['pubDate'])) === false))
						{
							// convert pubDate to specified date format
							$result['items'][$i]['pubDate'] = date($this->date_format, $timestamp);
						}
						else
						{
							$result['items'][$i]['pubDate'] = time();
						}
					}
					else
					{
						$result['items'][$i]['pubDate'] = time();
					}
					// item counter
					$i++;
				}
			}
			$result['items_count'] = $i;
			return ($result);
		}
		else
		{
			// error in getting content return error
			$result['items'] = array();
			$result['description'] = $user->lang['RSS_ERROR'];
			$result['title'] = '{L_RSS_ERROR}';
			$result['items_count'] = '{L_RSS_ERROR}';
			return ($result);
		}
	}
}
?>