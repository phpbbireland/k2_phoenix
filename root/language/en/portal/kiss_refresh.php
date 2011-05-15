<?php
/**
*
* @package kiss refresh
* @version $Id$
* @copyright (c) 2005 phpbbireland
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//
//- stargate aka kiss portal engine lang definitions -//
$lang = array_merge($lang, array(
	//SGP Refresh ALL
	'CACHE_PURGED'			=> '<br />&nbsp;&#187;&nbsp;Cache purged!',
	'CACHE_DIR_CLEANED'		=> '<br />&nbsp;&#187;&nbsp;cache directory cleaned up.',
	'DISABSLE_USE'			=> '<br />&nbsp;&#187;&nbsp;Disabled, use refresh in ACP for time being...',
	'DATABASE_TABLE'		=> ' database table!</b>',
	'DELETING_RSSCACHE'		=> '<b>Deleting rsscache_*.dat files in cache directory:</b>',
	'FAILED_UPDATE'			=> '<br /><b>Failed to update ',
	'LOG_RSS_CACHE_CLEANED'	=> '<strong>Deleted cached versions of all rsscache_*.dat files</strong><br />» %s',
	'NO_INFO_FOUND'			=> '<br /><b>No info found in ',
	'PURGING_CACHE'			=> '<b>Purging cache:</b>',
	'REFRESHED'				=> ' - <b>refreshed</b>',
	'REFRESHING_TEMPLATES'	=> '<b>Refreshing styles templates:</b>',
	'REFRESHING_THEMES'		=> '<b>Refreshing styles themes:</b>',
	'REFRESHING_IMAGESETS'	=> '<b>Refreshing styles imagesets:</b>',
	'SGP_REFRESH_ALL'		=> 'SGP Refresh ALL',
	'SGPRA_EXEPTIONS'		=> '<strong><font color="#FF0000">!NOTE</font>:<br />SGP Refresh ALL completed with exceptions!</strong> (see above for info)<br />',
	'SGPRA_LOG_IN'			=> '<strong>log in</strong></a> as an <font color="#FF0000"><strong>ADMINISTRATOR</strong></font> and <font color="#FF0000"><strong>refresh</strong></font> this page...</b><br /><br /><hr />',
	'SGPRA_NO_ADMIN'		=> '<font color="#FF0000"><strong>You do not have permission to run SGP Refresh ALL!</strong></font>',
	'SGPRA_NO_ERRORS'		=> '<br /><strong><font color="#00FF00">SGP Refresh ALL completed without any errors!...</font></strong><br />',
));

?>