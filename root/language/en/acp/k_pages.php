<?php
/**
*
* @package Kiss Portal Engine (acp_k_pages) (English)
*
* @package language
* @version $Id:$ 1.0.17
* @copyright (c) 2005-2011 Michael O'Toole (mike@phpbbireland.com)
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

$lang = array_merge($lang, array(
	'ACP_PAGES'					=> 'Current phpBB pages.',
	'ACP_K_PAGES'				=> 'phpBB pages',
	'ACP_K_PAGES_LAND'			=> 'Set landing page',
	'ACP_K_PAGES_MANAGE'		=> 'Manage phpBB pages',
	'ACP_K_RESOURCES'			=> 'Portal Resources',
	'ACP_K_RESOURCES'			=> 'Manage portal resources',
	'ADD_PAGE'					=> 'Add page',
	'ADDING_PAGES'				=> 'Page added... ',
	'CONFIG_PAGES'				=> 'Config pages',
	'DELETE_FROM_LIST'			=> 'Delete this page from list?',
	'ERROR_PORTAL_PAGES'		=> 'Error! deleting this page from database list',
	'ID'						=> 'ID',
	'LAND'                      => 'Set the default page to load after login.',
	'LANDING_PAGE'				=> 'Landing page',
	'LANDING_PAGE_EXPLAIN'		=> 'Return to this page after successful login.',
	'LANDING_PAGE_SET'			=> 'Landing page set',
	'LINE'						=> ', line ',
	'MANAGE_PAGES'				=> 'Manage pages',
	'NO_FILES_FOUND'			=> 'The dropdown is unavailable as there are no files to add...',
	'PAGE_NAME'					=> 'Current phpBB pages',
	'PAGE_NAME_EXPLAIN'			=> 'Blocks can be displayed on these pages.',
	'PAGE_NEW_FILENAME'			=> 'Add this page to the list',
	'PAGE_NEW_FILENAME_EXPLAIN'	=> 'Select file (page) from the dropdown and hit Submit...',
	'REMOVING_PAGES'			=> 'Page removed... ',
	'SWITCHING'					=> 'Switching to k_pages',
	'TITLE_EXPLAIN_PAGES'		=> '&bull; Blocks can be displayed on any valid phpBB, any mod pages you care to add, and basic html web pages...<br />
	&bull; To facilitate this action we provide a method to add additional pages form a list of valid pages in the root/mod folders.<br />
	&bull; Once a page is added, it will become available in the block layout.<br />
	<br />Note: Mod pages must provide necessary code to facilitate blocks (this is easy to add should you desire it)...',
));

?>