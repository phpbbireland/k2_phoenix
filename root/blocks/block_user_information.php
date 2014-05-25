<?php
/**
*
* @package Kiss Portal Engine
* @version $Id$
* @author  Michael O'Toole - aka michaelo
* @begin   Saturday, Jan 22, 2005
* @copyright (c) 2005-2013 phpbbireland
* @home    http://www.phpbbireland.com
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* Updated: prosk8er 16 March 2014
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

global $user, $auth, $db, $ranks, $config, $k_config, $k_blocks, $phpbb_root_path;

// initialise local variables //
$queries = $cached_queries = 0;
$rank_title = $rank_img = $rank_img_src = '';

foreach ($k_blocks as $blk)
{
	if ($blk['html_file_name'] == 'block_user_information.html')
	{
		$block_cache_time = $blk['block_cache_time'];
		break; // break out of loop as soon as it finds a match //
	}
}
$block_cache_time = (isset($block_cache_time) ? $block_cache_time : $k_config['k_block_cache_time_default']);

//
// + new posts since last visit & your post number
//
$ex_fid_ary = array_unique(array_merge(array_keys($auth->acl_getf('!f_read', true)), array_keys($auth->acl_getf('!f_search', true))));

if ($auth->acl_get('m_approve'))
{
	$m_approve_fid_ary = array(-1);
	$m_approve_fid_sql = '';
}
else if ($auth->acl_getf_global('m_approve'))
{
	$m_approve_fid_ary = array_diff(array_keys($auth->acl_getf('!m_approve', true)), $ex_fid_ary);
	$m_approve_fid_sql = ' AND (p.post_approved = 1' . ((sizeof($m_approve_fid_ary)) ? ' OR ' . $db->sql_in_set('p.forum_id', $m_approve_fid_ary, true) : '') . ')';
}
else
{
	$m_approve_fid_ary = array();
	$m_approve_fid_sql = ' AND p.post_approved = 1';
}

$sql = 'SELECT COUNT(distinct t.topic_id) as total
			FROM ' . TOPICS_TABLE . ' t
			WHERE t.topic_last_post_time > ' . $user->data['user_lastvisit'] . '
				AND t.topic_moved_id = 0
				' . str_replace(array('p.', 'post_'), array('t.', 'topic_'), $m_approve_fid_sql) . '
				' . ((sizeof($ex_fid_ary)) ? 'AND ' . $db->sql_in_set('t.forum_id', $ex_fid_ary, true) : '');
$result = $db->sql_query($sql, $block_cache_time);
$new_posts_count = (int) $db->sql_fetchfield('total');
$db->sql_freeresult($result);

// unread posts
$sql_where = 'AND t.topic_moved_id = 0
				' . str_replace(array('p.', 'post_'), array('t.', 'topic_'), $m_approve_fid_sql) . '
				' . ((sizeof($ex_fid_ary)) ? 'AND ' . $db->sql_in_set('t.forum_id', $ex_fid_ary, true) : '');
$unread_list = array();
$unread_list = get_unread_topics($user->data['user_id'], $sql_where, 'ORDER BY t.topic_id DESC');
$unread_posts_count = sizeof($unread_list);

get_user_rank($user->data['user_rank'], (($user->data['user_id'] == ANONYMOUS) ? false : $user->data['user_posts']), $rank_title, $rank_img, $rank_img_src);

$template->assign_vars(array(
	'AVATAR'          => get_user_avatar($user->data['user_avatar'], $user->data['user_avatar_type'], $user->data['user_avatar_width'], $user->data['user_avatar_height'], 'USER_AVATAR', true),
	'WELCOME_SITE'    => sprintf($user->lang['WELCOME_SITE'], $config['sitename']),
	'USR_RANK_TITLE'  => $rank_title,
	'USR_RANK_IMG'    => $rank_img,
	'L_NEW_POSTS'     => $user->lang['SEARCH_NEW'] . '&nbsp;(' . $new_posts_count . ')',
	'L_SELF_POSTS'    => $user->lang['SEARCH_SELF'] . '&nbsp;(' . $user->data['user_posts'] . ')',
	'L_UNREAD_POSTS'  => $user->lang['SEARCH_UNREAD'] . '&nbsp;(' . $unread_posts_count . ')',
	'U_NEW_POSTS'     => append_sid("{$phpbb_root_path}search.$phpEx", 'search_id=newposts'),
	'U_SELF_POSTS'    => append_sid("{$phpbb_root_path}search.$phpEx", 'search_id=egosearch'),
	'U_SELF_TOPICS'   => append_sid("{$phpbb_root_path}search.$phpEx", 'search_id=egosearch&amp;sf=firstpost'),
	'U_UNREAD_POSTS'  => append_sid("{$phpbb_root_path}search.$phpEx", 'search_id=unreadposts'),
	'USER_INFORMATION_DEBUG'	=> sprintf($user->lang['PORTAL_DEBUG_QUERIES'], ($queries) ? $queries : '0', ($cached_queries) ? $cached_queries : '0', ($total_queries) ? $total_queries : '0'),
));

?>