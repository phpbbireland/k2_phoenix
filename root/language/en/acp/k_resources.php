<?php
/**
*
* @author Original Author Michael O'Toole@www.stargate-portal.com
*
* @package {PACKAGENAME}
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

$lang = array_merge($lang, array(
	'TITLE' 		=> 'Portal Variables Manager',
	'TITLE_EXPLAIN'	=> '
	When you add or edit a web page, you can pass additional information in the form of variable data taken from the $config or $k_config tables.<br />
	Before these variables can be accessed, you must first specify them using this form. The variable name will be replaced with the variable data automatically.<br />
	Enter the variable name exactly as it appears in the database (normally lower case without spaces). If the variable does not exits it will be ignored....',
	'TITLE_ADD'		=> 'Add Variable',

	'ID'		=> 'ID',
	'R'			=> 'Reserved',
	'RESERVED'	=> 'Reserved',
	'V'			=> 'Variable',
	'VARIABLE'	=> 'A variable',
	'TYPE'		=> 'Type',

	'NEW'		=> 'New',
	'NEW_WORD'	=> 'A new word',

	'NEW_WORD_ADD'	=> 'Add leading $ for variable',
	'SWITCH'		=> 'Switch types',

	'SWITCH_V'	=> 'Variables',
	'SWITCH_R'	=> 'Reserved',
	'SWITCH_A'	=> 'Both',

	'SAVE_CURRENT'	=> 'Save current',



	'WORDS'						=> 'Reserved',
	'PLEASE_CONFIRM_ADD'		=> 'Confirm add word?',
	'PLEASE_CONFIRM_UPDATE'		=> 'Update words?',
	'PLEASE_CONFIRM_DELETE'		=> 'Confirm delete?',

	'RESERVED'					=> 'A reserved word',
	'RESERVED_WORDS'			=> 'Reserved word',

	'VAR'						=> 'Variable',

	'ACP_K_RES_WORDS'			=> 'Resources',
	'ACP_K_ADMIN_REFERRALS'		=> 'Manage Resource words',


	'SELECT_FILTER'				=> 'Select filter',
	'SELECT_SORT_METHOD'		=> 'Select sort method',

	'ORDER'						=> 'Order',
	'SORT_DESCENDING'			=> 'Descending',
	'SORT_ASCENDING'			=> 'Ascending',
	'SORT'						=> 'Sort',

	'ENABLE_MARKED'				=> 'Enable marked',
	'DISABLE_MARKED'			=> 'Disable_marked',


	'REFERRALS_MANAGEMENT'			=> 'Referrals management.',
	'REFERRALS_MANAGEMENT_EXPLAIN'	=> 'Here you can manage HTTP Referrals stored in your database.',

	'NO_ITEMS_MARKED'				=> 'No items marked.',
	'PLEASE_CONFIRM'				=> 'Please confirm.',

	'SWITCH_TO_WORDS'		=> 'Switch to words',
	'SWITCH_TO_VARIABLES'	=> 'Switch to variables',
	'SHOW_BOTH_TYPES'		=> 'Show both types',
	'VAR_NAME'				=> 'Variable name',
	'ADD_VARIABLE'			=> 'Add Variable',
	'VAR'					=> 'Variable',
	'TABLE'					=> 'Table',
	'OPTION'				=> 'Option',
	'REPORT'				=> 'Last process report',
	'VAR_NOT_FOUND'			=> '<strong>%s</strong> is not a valid config variable... Add action was aborted!',
	'VAR_ADDED'				=> '<strong>%s</strong> added!',

	'UNKNOWN'	=> 'Unknown',
	'K_CONFIG'	=> 'k_config',
	'CONFIG'	=> 'config',
	'PROCESS_REPORT'	=> 'Process report: %1$s',
	'NA'				=> '...',

));

?>