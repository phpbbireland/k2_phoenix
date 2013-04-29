<?php
/**
*
* @package phpBB3
* @version $Id: sgp_functions_content.php 336 2009-01-23 02:06:37Z Michealo $
* @copyright (c) Michael O'Toole 2005 phpBBireland
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* Last updated: 28 October 2010 Mike
* Do not remove copyright from any file.
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/***
* stargate hardcoded acronyms function, replaces acronyms. Started: 14 February 2007
* Fix: 10 January 2011
*/
if (!function_exists('sgp_local_acronyms'))
{
	function sgp_local_acronyms($message)
	{
		global $user;
		$you = $user->lang['THIS_MEANS_YOU'];

		// process single word acronyms first...
		$message = str_replace("[phpBB3]", '<acronym title="' . $user->lang['ACRO_3'] . '"> phpBB3 </acronym>', $message);
		$message = str_replace("[Stargate Portal]", '<acronym title="' . $user->lang['ACRO_1'] . '"> Stargate Portal </acronym>', $message);
		$message = str_replace("[Kiss Portal Engine]", '<acronym title="' . $user->lang['ACRO_2'] . '"> Kiss Portal Engine </acronym>', $message);

		return($message);
	}
}


/***
* phpbb pregs quote reused
*/

if (!function_exists('phpbb_preg_quote'))
{
	function phpbb_preg_quote($str, $delimiter)
	{
		$text = preg_quote($str);
		$text = str_replace($delimiter, '\\' . $delimiter, $text);

		return $text;
	}
}


/**
* Truncates post while retaining special characters
* Length set in ACP for Announcements or News items
* @param string $txt, $length (truncate to length).
*
* If $options var true, return entire message if it contains attachments.
* Last updated: 28 September 2010 Mike
*/

if (!function_exists('sgp_truncate_message'))
{
	function sgp_truncate_message($txt, $length = 0)
	{
		global $phpbb_root_path, $config;
		$buffer = $div_append = '';
		$len = $extend = 0;

		$len = strlen($txt);

		if ($len > $length)
		{
			$extend = correct_truncate_length($txt, $length);
		}

		if (stripos($txt, '</div>'))
		{
			$div_append = '</div>';
		}

		if (strlen($txt) > $length)
		{
			for ($i = 0; $i <= $extend; $i++)
			{
				$buffer .= $txt[$i];
			}
		}

		$buffer .= '... &nbsp;&nbsp;&nbsp;';

		return($buffer . $div_append);
	}
}

/*
* When truncating text or post message ensure we do not truncate in the middle
* of special text such as bbcode, smilies, attachments etc...
*
* The function is passed the text to truncate and the required lenth of the
* truncated text...
*
* It returns the length of the truncated string altered to avoid splitting
* special code...
*
* 28 September 2010 Mike.... requires testing as usual...
*/
if (!function_exists('correct_truncate_length'))
{
	function correct_truncate_length($txt, $truncate)
	{
		$smile_start = $smile_end = $uid_start = $uid_end = $j = $k = $m = 0;
		$ts = $te = $td = 0;
		$tag_count = 0;

		$tag_start = $tag_end = $tag_data = array();

		$opening_tag_string = $closing_tag_string = '';
		$return_val = $truncate;

		$len = strlen($txt);

		for ($i = 0; $i < $len; $i++)
		{
			// not nestled?
			if ($txt[$i] == '<' && $txt[$i + 5] == 's' && $txt[$i + 6] == ':')
			{
				$smile_start = $i;
				while ($txt[$i] != '>' && $i < $len)
				{
					$i++;
				}
				$smile_end = $i;

				if ($smile_start < $truncate && $smile_end < $truncate) // || $smile_start > $truncate)
				{
					$return_val = $truncate;

				}
				if ($smile_start < $truncate && $smile_end > $truncate)
				{
					$return_val = $smile_end;
				}
			}

			// find bbcodes & make sure we have enought characters left to check after tag //
			if ($i + 9 < $len)
			{
				if ($txt[$i] == ':' && $txt[$i + 9] == ']')
				{
					$opening_tag_string = '';

					while ($txt[$i] != '[')
					{
						$i--;

						// belt and braces //
						if ($i == 1)
						{
							break;
						}
					}

					$tag_start[$ts++] = $i;
					$uid_start = $i;

					while ($txt[$i] != ']')
					{
						if ($txt[$i] == '=')
						{
							while ($txt[$i] != ':')
							{
								$i++;
							}
						}
						$opening_tag_string .= $txt[$i++];
					}
					$opening_tag_string .= $txt[$i++];

					$tag_data[$td] = $opening_tag_string;
					$td++;

					while ($i < $len)
					{
						if ($txt[$i] == '[' && $txt[$i+1] == '/')
						{
							$closing_tag_string = '';
							while ($txt[$i] != ']' && $i < $len)
							{
								$i++;
							}
							$uid_end = $i;
							$tag_end[$te] = $i;

							// grab end tag
							// loop back to get the actual start [ //
							while ($txt[$i] != '[')
							{
								$i--;
							}
							// grab closing tag
							while ($txt[$i] != ']')
							{
								if ($txt[$i] == '/')
								{
									$i++;
								}
								$closing_tag_string .= $txt[$i++];
							}
							$closing_tag_string .= $txt[$i++];

							if (strpos($tag_data[$ts-1], $closing_tag_string) !== false)
							{
								break;
							}
						}
						$i++;
					}
					$i++;

					if ($uid_start < $truncate && $uid_end < $truncate)
					{
						$return_val = $truncate;
					}

					if ($uid_start < $truncate && $uid_end > $truncate)
					{
						$return_val = $uid_end;
					}
				}
			}
		}
		return($return_val);
	}
}


/**
 * Written by Rowan Lewis
 * $search(string), the string to be searched for
 * $replace(string), the string to replace $search
 * $subject(string), the string to be searched in
 */
function word_replace($search, $replace, $subject)
{
	return preg_replace('/[a-zA-Z]+/e', '\'\0\' == \'' . $search . '\' ? \'' . $replace . '\': \'\0\';', $subject);
}
?>