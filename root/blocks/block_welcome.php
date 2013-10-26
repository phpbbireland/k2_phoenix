<?php
/**
*
* @package Kiss II Engine
* @author  Michael O'Toole - aka michaelo
* @begin   Sunday 24 April 2011
* @copyright (c) 2005-2008 phpbbireland
* @home    http://www.phpbbireland.com
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @note:   Do not remove this copyright. Just append yours if you have modified it,
*          this is part of the Stargate Portal copyright agreement...
*
* @version $Id
* Updated: 24 April 2011
* filename block_welcome.php
*/

/**
* @ignore
*/

	if (!defined('IN_PHPBB'))
	{
		exit;
	}

	global $php_root_path, $db, $user, $config, $k_config, $k_blocks;

	$queries = $cached_queries = 0;

	$welcome_image	= 'welcome.png';

	if (file_exists($php_root_path . 'images/' . $welcome_image))
	{
		$block_link = 'portal.php';
	}
	else
	{
		$welcome_image = '';
		$block_link = '';
	}

	foreach ($k_blocks as $blk)
	{
		if ($blk['html_file_name'] == 'block_welcome_message.html')
		{
			$block_cache_time = $blk['block_cache_time'];
		}
	}
	$block_cache_time = (isset($block_cache_time) ? $block_cache_time : $k_config['block_cache_time_default']);

	include($phpbb_root_path . 'includes/sgp_functions.' . $phpEx);

	$block_name		= (isset($user->lang['WELCOME']) ? $user->lang['WELCOME'] : '{L_NO_LANG_VALUE}');

	$block_details	= $user->lang['WELCOME_MESSAGE'];
	$block_details	= process_for_vars($block_details, true);
	$block_details	= str_replace("[you]", ('<span style="font-weight:bold; color:#' . $user->data['user_colour'] . ';">' . $user->data['username'] . '</span>'), $block_details);

	$template->assign_vars( array(
		'W_TITLE'	=> $block_name,
		'W_IMAGE'	=> $welcome_image,
		'U_LINK'	=> $block_link,
		'W_MESSAGE'	=> htmlspecialchars_decode($block_details),

		'WELCOME_MESSAGE_DEBUG'	=> sprintf($user->lang['PORTAL_DEBUG_QUERIES'], ($queries) ? $queries : '0', ($cached_queries) ? $cached_queries : '0', ($total_queries) ? $total_queries : '0'),
	));
?>