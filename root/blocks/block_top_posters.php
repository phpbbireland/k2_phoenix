<?php
/**
*
* @package Stargate Portal
* @author  Michael O'Toole - aka Michaelo
* @begin   24 September 2007
* @copyright (c) 2005-2008 phpbbireland
* @home    http://www.phpbbireland.com
* additional code taken from various core files
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @note: Do not remove this copyright. Just append yours if you have modified it,
*        this is part of the Stargate Portal copyright agreement...
*
* @version $Id: block_top_posters.php 297 2008-12-30 18:40:30Z JohnnyTheOne $
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
global $k_config, $k_blocks;
$queries = $cached_queries = 0;

foreach ($k_blocks as $blk)
{
	if ($blk['html_file_name'] == 'block_top_posters.html')
	{
		$block_cache_time = $blk['block_cache_time'];
	}
}
$block_cache_time = (isset($block_cache_time) ? $block_cache_time : $k_config['k_block_cache_time_default']);

include($phpbb_root_path . 'includes/sgp_functions.'. $phpEx );

$k_top_posters_to_display = (!empty($k_config['k_top_posters_to_display'])) ? $k_config['k_top_posters_to_display'] : '5';

$sql = 'SELECT user_id, username, user_posts, user_colour, user_type, group_id, user_avatar, user_avatar_type, user_avatar_width , user_avatar_height, user_website
	FROM ' . USERS_TABLE . '
	WHERE user_type <> ' . USER_IGNORE . '
		AND user_posts <> 0
	ORDER BY user_posts DESC';

$result = $db->sql_query_limit($sql, $k_top_posters_to_display, 0, $block_cache_time);

while ($row = $db->sql_fetchrow($result))
{
    if (!$row['username'])
    {
        continue;
    }

    $template->assign_block_vars('top_posters', array(
        'S_SEARCH_ACTION'	=> append_sid("{$phpbb_root_path}search.$phpEx", 'author_id=' . $row['user_id'] . '&amp;sr=posts'),
		'USERNAME_FULL'		=> get_username_string('full', $row['user_id'], sgp_checksize($row['username'],15), $row['user_colour']),
        'POSTER_POSTS'		=> $row['user_posts'],
        'USER_AVATAR_IMG'	=> get_user_avatar($row['user_avatar'], $row['user_avatar_type'], '16', '16', $user->lang['USER_AVATAR']),
        'URL'				=> $row['user_website'],
        )
    );

	$template->assign_vars(array(
		'TOP_POSTERS_DEBUG'	=> sprintf($user->lang['PORTAL_DEBUG_QUERIES'], ($queries) ? $queries : '0', ($cached_queries) ? $cached_queries : '0', ($total_queries) ? $total_queries : '0'),
	));
}
$db->sql_freeresult($result);

?>