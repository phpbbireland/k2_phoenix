<?php
/**
*
* @package Stargate Portal
* @author  Michael O'Toole - aka Michaelo
* @begin   11 June 2007
* @copyright (c) 2008 phpbbireland
* @home    http://www.phpbbireland.com
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @note: Do not remove this copyright. Just append yours if you have modified it,
*        this is part of the Stargate Portal copyright agreement...
*
* @version $Id: basic_rules.php 336 2009-01-23 02:06:37Z Michealo $
* Updated:
*
*/

/**
* @ignore
*/
define('IN_PHPBB', true);

if (!defined('IN_PHPBB')) // keep mpv happy?
{
	exit;
}

$phpbb_root_path = './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);
include($phpbb_root_path . 'includes/functions_display.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();

// Stargate Portal
if (!STARGATE)
{
	redirect(append_sid("{$phpbb_root_path}index.$phpEx"));
}

$basic_rules = $user->lang['BASIC_RULES'];

$template->assign_block_vars('basic_rules', array(
	'TO_DAY'       => $user->format_date(time(), false, true),
	'BASIC_RULES'  => $basic_rules,
));

// Output page
page_header($user->lang['BASIC_RULES_HEADER']);

$template->set_filenames(array(
	'body' => 'basic_rules.html')
);

page_footer();

?>