<?php
/**
*
* @author Original Author Michael O'Toole@www.stargate-portal.com
*
* @package {k_menus.php}
* @version $Id:$ 3.2.0
* @note: Do not remove this copyright. Just append yours if you have modified it,
*        this is part of the Stargate Portal copyright agreement...
* @copyright (c) 2005 phpbireland
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

	'TITLE' 				=> 'Stargate (aka Kiss) Menu Manager (Administration)',
	'TITLE_EXPLAIN'			=> 'Here you can Add, Edit and Delete Menus. (* indicated the fields cannot be empty).',
	'TITLE_EXPLAIN_EXPAND'	=> 'Fields marked with * cannot be empty.<br />Legend: NDX = Index or sort order, Icon = Menu Icon (each menu item can have a different icon), Alt = Alternative text, Link = Link to whatever... <br />Menu icons are located in images/block_images/menu directory.',
	'TITLE_ICON_EXPLAIN'	=> 'Manage Icons',

	'ACP_MENUS' 			=> 'Menus',

	'MENUS_HEADER_ADMIN'	=> 'Menu Management',
	'MENUS_ADD_HEADER'		=> 'Add a menu item:',
	'MENUS_EDIT'			=> 'Edit Menu.',
	'MENU_ICONS_HEADER'		=> 'Manage Menu Icons ',
	'MENU_DISABLED'			=> 'Dis',
	'MENU_DISABLED_BIG'		=> 'MENU is Disabled',
	'MENU_ACTIVE'			=> 'A',
	'MENU_ACTIVE_BIG'		=> 'MENU is Active',

	'MENU_EXTERN_EXPLAIN'	=> 'Open this link in browser tab:',
	'MENU_EXTERN'			=> 'Link Options',
	'MENU_EXTERN_SHORT'		=> 'Extrn',
	'MENU_EXTERN_WINDOW'	=> 'Window',
	'MENU_EXTERN_TAB'		=> 'Tab',
	'MENU_EXTERN_NORMAL'	=> 'Normal',

	'OPEN_SAME'				=> 'No',
	'OPEN_TAB'				=> 'In Tab',
	'OPEN_WIN'				=> 'Win',

	'MENU_TYPE_BIG'				=> 'File Type',
	'MENU_VIEW_BY_SHORT'		=> 'Allow View By',
	'MENU_VIEWED_BY' 			=> 'Which groups can view this menu item?',
	'MENU_VIEWED_BY_EXPLAINED'	=> 'Admin can see all menu items...',
	'MENU_ITEM_NAME_SHORT'		=> 'Name',
	'MENU_ITEM_NAME'			=> '* Menu item name/title',
	'MENU_ITEM_NAME_EXPLAIN'	=> 'Will be replaced by user language variable if it exist in block_menus_vars.php, else the value shown here will be used.',
	'MENU'						=> 'Menu',
	'MENUID' 					=> 'ID',
	'MENU_ID' 					=> 'ID',
	'MENU_ID_BIG'				=> 'Menu ID (Auto)',
	'MENU_ADD'					=> 'Add',
	'MENU_ADD_NEW'				=> 'Add a New Menu Option',
	'MENU_ADDED'				=> 'Menu added!',
	'MENU_EDIT'					=> 'Edit',
	'MENU_EDITED'				=> 'Menu edited!',
	'MENU_DELETE' 				=> 'Del.',
	'MENU_UP' 					=> 'Up',
	'MENU_DOWN' 				=> 'Dn',
	'MENU_LINK'					=> 'Menu link',
	'MENU_LINK_BIG'				=> '* Link to file',
	'MENU_LINK_EXPLAIN'			=> 'Link associated with this menu item.',
	'MENU_ICON_ALT_TEXT'		=> 'Image alt text',
	'MENU_ICON_THIS'			=> ' current icon = ',
	'MENU_ICON'					=> 'Menu Icon',
	'MENU_ICONS'				=> 'Available menu icon images.<br />Located in: images/block_images/menu',
	'MENU_ICON_BIG'				=> 'Menu item image to use',
	'MENU_NDX'					=> 'NDX',
	'MENU_NDX_BIG'				=> 'Menu Index (for sort order)',
	'MENU_TYPE'					=> '* Type',
	'MENU_TYPE_HEADER'			=> 'Header Menu',
	'MENU_TYPE_NAV'				=> 'Nav Menu',
	'MENU_TYPE_SUB'				=> 'Sub Menu',
	'MENU_TYPE_FOOTER'			=> 'Footer Menu',
	'MENU_TYPE_LINKS'			=> 'Links Menu',
	'MENU_TYPE_OTHER'			=> 'Unassigned',
	'MENU_UPDATED'				=> 'Menu updated',
	'MENU_TYPE_EXPLAIN'			=> 'The position of the menu (you must select one option).',
	'MENU_VIEW_BY'				=> 'View by',
	'DO_NOT_EDIT'				=> 'Note: Do not edit this value',
	'PROCESS'					=> 'process',
	'ICON'						=> 'Icon',
	'MENU_ICON_COUNT'			=> 'Available Icons ',
	'MENU_ICON_EXPLAIN'			=> 'Icon to use with this menu item. ',
	'MANAGE_MENU_ICONS'			=> 'Manage Menu Icons: ',

	'HEADER_MENU'		=> 'Header Menu',
	'NAV_MENU'			=> 'Navigation Menu',
	'SUB_MENU'			=> 'Sub Menu',
	'MENUS_ALL_ITEMS'	=> 'All Menus and Items',
	'OTHER_MENUS'		=> 'Other Menus',
	'UNKNOW_MENU'		=> 'Unknown Menu/Option',
	'CREATE'			=> 'Create Menu',
	'ALL_MENUS'			=> 'Show All Menu Items',
	'MISC'				=> 'Manage Unallocated Items',

	'MENU_NAME_1'		=> 'Header Menu',
	'MENU_NAME_2'		=> 'Navigation Menu',
	'MENU_NAME_3'		=> 'Sub Menu',
	'MENU_ICON_IMG'		=> 'available icon images',

	'CONFIRM_OPERATION_MENUS'		=> 'Do you wish to delete this Menu?',
	'MUST_SELECT_VALID_MENU_DATA'	=> 'Invalid menu ID.',

	'MENU_APPEND_SID_BIG'		=> 'Append SID to link.',
	'MENU_APPEND_UID_BIG'		=> 'Append UID to link.',
	'MENU_APPEND_SID'			=> 'SID',
	'MENU_APPEND_UID'			=> 'UID',
	'MENU_APPEND_SID_EXPLAIN'	=> 'The SID, may be required by code/blocks.',
	'MENU_APPEND_UID_EXPLAIN'	=> 'The user ID may be required by code/blocks.',
	'SOFT_HR'					=> 'Add a soft return (image or spacer) between this and the next menu item',
	'SOFT_HR_EXPLAIN'			=> 'You can use this to group menu items...',
	'SUB_HEADING'				=> '<span style="font-style:italic"> Menu Sub Heading</span>',
	'SUB_HEADING_EXPLAIN'		=> 'This is a Menu Sub Heading... no links allowed.',
	'HEAD'						=> 'Header',
	'NAV'						=> 'Nav',
	'SUB'						=> 'Sub',
	'FOOT'						=> 'Footer',
	'LINKS'						=> 'Links',
	'ADD_ICON'					=> 'Add new icon',
	'MENU_MOVE_ERROR' 			=> 'The ndx’s values are not consecutive, or you are trying to move a menu item out of its group...<br />Go back and manually correct the ndx values, then try again. ',

	'UNDER_CONSTRUCTION'	=> '<strong>Under construction... <br />This section of the portal ACP is for future development (links are disabled)...</strong><br /><br />Here you can see all available block images, later you will be able to add, delete and update images...',
	'SOURCE_DIRECTORY'		=> 'Source Directory = images/block_images/ (menu | block)',

	'SORT_ORDER_UPDATING'	=> 'Sort order updating... please wait!<br />',
	'MISSING_DATA'			=> '<br />You are missing one or more required fields... Please use browser back arrow and add required fields',

	'PORTAL_ERROR_MENU'		=> 'Could not query portal menus information',


	'MENU_VIEW_BY_SHORT'		=> 'View By',
	'MENU_VIEW_GROUPS'			=> 'Menu Group Visibility',
	'MENU_VIEW_GROUPS_EXPLAIN'	=> 'Enter group ID(s) manually or use the dropdown below.',
	'MENU_VIEW_BY' 				=> 'Groups',
	'MENU_VIEW_BY_EXPLAIN'		=> 'Select a group to add to the current list.<br />Selecting <b>(None)</b> will empty the list.',
	'MENU_VIEW_ALL'				=> 'Optionally',
	'MENU_VIEW_ALL_EXPLAIN'		=> 'Ignore these setting and set this menu/menu item visibility to <strong>all</strong> groups.',
	'ALL_GROUPS'				=> 'All Groups',


));
// Message Settings
$lang = array_merge($lang, array(
	'ACP_MESSAGE_SETTINGS_EXPLAIN'	=> 'Here you can set all default settings for private messaging',
));

?>