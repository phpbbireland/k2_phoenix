<?php
/**
*
* @package Stargate Portal
* @author  Michael O'Toole - aka Michaelo
* @begin   Saturday, Jan 22, 2005
* @copyright (c) 2005-2008 phpbbireland
* @home    http://www.phpbbireland.com
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @note: Do not remove this copyright. Just append yours if you have modified it,
*        this is part of the Stargate Portal copyright agreement...
*
* @version $Id: block_search.php 298 2008-12-30 18:40:30Z JohnnyTheOne $
* Updated:
*
*/

/**
* @ignore
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

$user->add_lang('portal/kiss_search');
$user->add_lang('search');

$submit			= request_var('submit', false);
$keywords		= request_var('keywords', '', true);

$allow_search = true;

$queries = $cached_queries = 0;

if (!$auth->acl_get('u_search') || !$auth->acl_getf_global('f_search') || !$config['load_search'])
{
	$allow_search = false;

	if ($user->data['user_id'] == ANONYMOUS)
	{
		return;
	}
}

global $lang, $template, $portal_config, $board_config;

$phpEx = substr(strrchr(__FILE__, '.'), 1);

$template->assign_vars(array(
	'S_SEARCH'			=> $allow_search,
	'L_SEARCH_ADV' 		=> $user->lang['SEARCH_ADV'],
	'L_SEARCH_OPTION' 	=> (!empty($portal_config['search_option_text'])) ? $portal_config['search_option_text'] : $board_config ['sitename'],
	'U_SEARCH'			=> append_sid("{$phpbb_root_path}search.$phpEx", 'keywords=' . urlencode($keywords)),
));

$template->assign_vars(array(
	'S_USER_LOGGED_IN'	=> ($user->data['user_id'] != ANONYMOUS) ? true : false,
	'SITE_NAME'         => $config['sitename'],
	'U_INDEX'			=> append_sid("{$phpbb_root_path}index.$phpEx"),
	'U_PORTAL'			=> append_sid("{$phpbb_root_path}portal.$phpEx"),
	'U_SEARCH_BOOKMARKS'=> ($user->data['user_id'] != ANONYMOUS) ? append_sid("{$phpbb_root_path}ucp.$phpEx", 'i=main&mode=bookmarks') : '',
	'SEARCH_DEBUG'		=> sprintf($user->lang['PORTAL_DEBUG_QUERIES'], ($queries) ? $queries : '0', ($cached_queries) ? $cached_queries : '0', ($total_queries) ? $total_queries : '0'),
));

?>