<?php
/**
*
* @package install
* @version $Id: portal_install.php 323 2009-01-16 21:55:07Z Michealo $
* @copyright (c) 2005 phpbBB Group
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


// k2 country flag_mod
$lang = array_merge($lang, array(
	'DONATIONS_MOD'				=> 'Kiss II Donations Mod',
	'K2_DONATIONS_MOD' 			=> 'Donations Mod',
	'K2_DONATIONS_MOD_EXPLAIN' 	=> 'Allows you to add information re donations...',
));

?>