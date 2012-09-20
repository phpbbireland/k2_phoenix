<?php
/**
*
* @package Kiss Portal Engine (acp_k_portal) (English)
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
// phpbbportal profile fields
$lang = array_merge($lang, array(


	'BLOCK_DEFAULT'					=> 'Default',
	'BLOCK_FIVE_COLUMN'				=> 'Five Column',
	'BLOCK_FOUR_COLUMN'				=> 'Four Column',
	'BLOCK_THREE_COLUMN'			=> 'Three Column',
	'BLOCK_TWO_COLUMN'				=> 'Two Column',
	'BLOCKS_UPDATED'				=> 'Portal info updated',
	'BLOCKS_UPDATE_FILES'			=> 'Update Files',

	'HEADER_MENU'					=> 'Header Menu',

	'PORTAL' 						=> 'Portal',
	'PORTAL_MAIN'					=> 'Main Block/Portal Configuration',
	'PORTAL_BLOCKS_WIDTH' 			=> 'Block Width (Left and Right Blocks)',
	'PORTAL_BLOCKS_LEFT_ENABLED' 	=> 'Enable Left Blocks',
	'PORTAL_BLOCKS_RIGHT_ENABLED' 	=> 'Enable Right Blocks',
	'PORTAL_SCROLL_RECENT'			=> 'Allow Scrolling',
	'PORTAL_SCROLL_LINKS'			=> 'Scroll Links',
	'PORTAL_SET_LAYOUT_NEW'			=> '*Set Block Layout/Style for Welcome Page (New Optional)',
	'PORTAL_SET_LAYOUT'				=> '*Set Block Layout/Style for Site (Default Option)',

	'PBLOCK_HEADER'			=> 'Stargate (aka Kiss) Portal Block Manager (Future Development!) ',
	'PBLOCK_NAME'			=> 'Block Name',
	'PBLOCK_CLASS'			=> 'Class',
	'PBLOCK_APPROVED'		=> 'Approved',
	'PBLOCK_AUTHOR'			=> 'Author',
	'PBLOCK_VERSION'		=> 'Revision',
	'PBLOCK_DATE'			=> 'Date',
	'PBLOCK_UPDATE'			=> 'Update',
	'PBLOCK_SITE'			=> 'Site',

	'TITLE' 			=> 'Portal Information',
	'TITLE_EXPLAIN'		=> 'Extended details for installed blocks... Author, Revision, Site/Links etc.',

));

?>