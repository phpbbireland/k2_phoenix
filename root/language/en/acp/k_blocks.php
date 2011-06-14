<?php
/**
*
* @author Original Author Michael O'Toole@www.stargate-portal.com
*
* @package {k_blocks.php}
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

	'TITLE' 			=> 'Block Administration/Management',
	'TITLE_EXPLAIN'		=> '
	* Block titles will be replaced by lang var if it exists.<br />&bull; The last edited block is highlighted (bold).',

	'TITLE_EXPLAIN_EXPAND'	=> '
	&bull; The NDX indicates position relative to other blocks in the same column.<br />
	&bull; Block html files are located in: styles/_portal_common/template/blocks folder.',

	'ACP_BLOCKS' 		=> 'Blocks',
	'ACP_BLOCK_TOOLS' 	=> 'Blocks Tools',

	'BLOCKS_HEADER_ADMIN'	=> 'Block Management',
	'BLOCKS_ADD_HEADER'		=> 'Add a new block',
	'BLOCKS_REINDEX'		=> 'Re-index blocks',
	'BLOCKS_REINDEXED'		=> 'All blocks have been Re-Indexed',
	'BLOCK_TITLE' 			=> 'Block Title*',
	'BLOCK_FNAME_P' 		=> 'Filename (.php)',
	'BLOCK_FNAME_H'		 	=> 'Filename (.html)',
	'BLOCK_FNAME_I'			=> 'Icon',
	'BLOCK_FNAME_I_EXPLAIN'	=> 'Please note, image filenames cannot contain spaces.',
	'BLOCK_FNAME_I_BIG'	 	=> 'Block Mini image',
	'BLOCK_FNAME_IS_BIG'	=> 'Mini block images found',
	'BLOCK_FNAME_P_BIG'		=> 'Block Filename.php',
	'BLOCK_FNAME_H_BIG'	 	=> 'Block Filename.html',
	'BLOCK_FNAME_EXPLAIN'	=> 'Located in: styles/portal_common/template/blocks folder',
	'BLOCK_ID' 				=> 'ID',
	'BLOCK_NDX'				=> 'NDX',
	'BLOCK_INDEX'			=> '(Index / Sort Order)',
	'BLOCK_UP' 				=> 'Up',
	'BLOCK_DOWN' 			=> 'Dn',
	'BLOCK_DISABLED'		=> 'Disabled',
	'BLOCK_DISABLED_BIG'	=> 'Block is Disabled',
	'BLOCK_ACTIVE'			=> 'Active',
	'BLOCK_ACTIVE_BIG'		=> 'Block is Active',
	'BLOCK_TYPE'			=> 'T',
	'BLOCK_TYPE_BIG'		=> 'File Type',
	'BLOCK_POSITION'	 	=> 'Position',
	'BLOCK_POSITION_BIG' 	=> 'Block Position',

	'BLOCK_VIEW_BY_SHORT'	=> 'View By',

	'BLOCK_VIEW_GROUPS'			=> 'Block Group Visibility',
	'BLOCK_VIEW_GROUPS_EXPLAIN'	=> 'Enter group ID(s) manually or use the dropdown below.',

	'BLOCK_VIEW_BY' 			=> 'Groups',
	'BLOCK_VIEW_BY_EXPLAIN'		=> 'Select a group to add to the current list.<br />Selecting <b>(None)</b> will empty the list.',

	'BLOCK_VIEW_ALL'			=> 'Optionally',
	'BLOCK_VIEW_ALL_EXPLAIN'	=> 'Ignore these setting and set this Block visibility to <strong>all</strong> groups.',

	'BLOCK_EDIT'			=> 'Edit',
	'BLOCK_DELETE' 			=> 'Del.',
	'BLOCK_MOVE'			=> 'Move',
	'BLOCK_SCROLL'			=> 'S',
	'BLOCK_ADDED'			=> ' Block Added!',
	'BLOCK_EDITED'			=> ' Block Edited!',
	'BLOCK_UPDATED'			=> ' Block Updated',
	'BLOCK_DELETED'			=> ' Block deleted',

	'BLOCK_CACHE_TIME_HEAD'		=> 'Block Cache Time',
	'BLOCK_CACHE_TIME'			=> 'Set the block cache time.',
	'BLOCK_CACHE_TIME_EXPLAIN'	=> 'Default cache time for blocks (600).',

	'DO_NOT_EDIT'			=> ' (Do not edit this value)',

	'BLOCK_SCROLL_BIG'			=> 'Allow Scrolling',
	'BLOCK_SCROLL_BIG_EXPLAIN'	=> 'Yes, block (data) will scroll, No, block is static.',

	'PROCESS'				=> 'process',
	'PORTAL_BLOCKS_ENABLED' => 'Portal blocks enabled',

	'BLOCK_G_COUNT'			=> 'Generic store for blocks',
	'BLOCK_G_COUNT_EXPLAIN'	=> 'The number of Announcements, News Items or Recent Topics to display if scrolling is disabled in their associated blocks.',

	'VARS_NO_EDIT'			=> 'Block has no variables',
	'VARS_HAS_EDIT'			=> 'Set block variables',

	'HAS_VARS'					=> 'Block contains configurable data',
	'HAS_VARS_EXPLAIN'			=> '(config info is stored in the database).',
	'BLOCK_VAR_FILE'			=> 'Select the config file used to display/edit variables',
	'BLOCK_VAR_FILE_EXPLAIN'	=> '(located in adm/style/k_block_vars folder).',

	'MINIMOD_BASED'				=> 'Is this block based on a SGP minimod?',
	'MINIMOD_BASED_EXPLAIN'		=> 'Select Yes, if Block is based on a portal minmod? (adjusted elsewhere)',
	'MINIMOD_OPTIONS'			=> 'Which minimod is associated with this block?',
	'MINIMOD_OPTIONS_EXPLAIN'	=> 'Ignore if block is not based on a minimod.',
	'MINIMOD_DETAILS_SHOW'		=> 'This block is based on a minimod, this is a link to it!',
	'MINIMOD_DETAILS_NO_EDIT'	=> 'Block is not a minimod',

	'HTML'			=> 'HTML',
	'BBCODE'		=> 'BBcode',
	'ALL_GROUPS'	=> 'All Groups',
	'SAVED'			=> 'Data saved... purging cache for this table...!',
	'SAVING'		=> 'Saving Data...',
	'UNKNOWN_ERROR'	=> 'Error not processing saved data<br />',

	'CONFIRM_OPERATION_BLOCKS'			=> 'Do you wish to delete this block?',
	'CONFIRM_OPERATION_BLOCKS_REINDEX'	=> 'Do you wish to re-index the blocks?',
	'MUST_SELECT_VALID_BLOCK_DATA'		=> 'Invalid block ID',
	'BLOCK_UPDATING'					=> 'Updating block positions, please wait...<br />',
	'BLOCK_MOVE_ERROR'					=> 'Blocks require reindexing... <br />Press back and try again... If this condition persists, please try to manually correct the ndx values, and then try again. ',

	'VIEW_PAGE'				=> 'Add page from available pages:',
	'VIEW_PAGE2'			=> 'Available pages:',
	'VIEW_PAGE_EXPLAIN'		=> 'Select from this list (reusable) to add, selecting <strong>None</strong> will empty the list.',
	'VIEW_PAGE_EXPLAIN2'	=> 'Select the pages where this block will be visible.<br /><br /><strong>Notes:</strong><br />Blocks will only be visible on pages that support blocks.<br />We do not process blocks if the information they contain is already process by the page they are displayed on.',

	'PAGE_ARRAY'			=> 'Array of page',
	'PAGE_ARRAY_EXPLAIN'	=> 'List of all block where block is visible',

	'VIEW_PAGES'			=> 'Page ID where the block will be displayed',
	'VIEW_PAGES_EXPLAIN'	=> 'The list will be updated automatically.',

	'PAGE_LEFT'				=> 'Page Left',
	'PAGE_CENTRE'			=> 'Page Centre',
	'PAGE_RIGHT'			=> 'Page right',
	'LEFT_OF_CENTRE'		=> 'Left (centre 2x)',
	'RIGHT_OF_CENTRE'		=> 'Right (centre 2x)',
	'MOVE_DOWN'				=> 'Move Down',
	'MOVE_UP'				=> 'Move Up',
	'EDIT_BLOCK'			=> 'Edit block',
	'DELETE_THIS_BLOCK'		=> 'Delete this block',

	'SET_VARIABLES_IN_MINI-MODULES'	=> 'Set variables in Mini-Modules',
	'MANAGE_PAGES'					=> 'Manage pages',
	'NONE'							=> 'None',

));
// Message Settings
$lang = array_merge($lang, array(
	'ACP_MESSAGE_SETTINGS_EXPLAIN'	=> 'Here you can set all default settings for private messaging',
));

?>