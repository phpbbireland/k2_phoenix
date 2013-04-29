<?php
/**
*
* mcp [English]
*
* @package language
* @version $Id$
* @copyright (c) 2005 phpBB Group
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

$lang = array_merge($lang, array(
	'MCP_MAKE_NEWS'					=> 'Modify to “News”',
	'MCP_MAKE_NEWS_CONFIRM'			=> 'Are you sure you want to change this topic to a News Item”?',
	'MCP_MAKE_NEWSS'				=> 'Modify to “News Items”',
	'MCP_MAKE_NEWSS_CONFIRM'		=> 'Are you sure you want to change these topics to a News Items”?',
	'MCP_MAKE_NEWS_GLOBAL'			=> 'Modify to “Global News”',
	'MCP_MAKE_NEWS_GLOBAL_CONFIRM'	=> 'Are you sure you want to change this topic to a Global News Item”?',
	'MCP_MAKE_NEWSS_GLOBAL'			=> 'Modify to “Global News Items”',
	'MCP_MAKE_NEWSS_GLOBAL_CONFIRM'	=> 'Are you sure you want to change these topics to a Global News Items”?',
));

?>