<?php
/**
*
* @package Stargate Portal
* @author  Michael O'Toole - aka Michaelo
* @begin   Saturday, June 23rd, 2007
* @copyright (c) 2005-2008 phpbbireland
* @home    http://www.phpbbireland.com
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @note: Do not remove this copyright. Just append yours if you have modified it,
*        this is part of the Stargate Portal copyright agreement...
* This code may be overkill but will do for now... additional data can now be
* passed to block_forum_categories.html block...
*
* @version $Id$
*/

/**
* @ignore
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

// for bots test //
//$page_title = $user->lang['BLOCK_CATEGORIES'];

// SGP debug vars
$queries = $cached_queries = 0;

global $db, $auth, $user, $template;
global $phpbb_root_path, $phpEx, $config, $k_config, $k_blocks;


foreach ($k_blocks as $blk)
{
	if ($blk['html_file_name'] == 'block_forum_categories.html')
	{
		$block_cache_time = $blk['block_cache_time'];
	}
}
$block_cache_time = (isset($block_cache_time) ? $block_cache_time : $k_config['k_block_cache_time_default']);

$store = array();

$this_page = explode(".", $user->page['page']);

if ($this_page[0] != 'index' && $this_page[0] != 'portal')
{
	return;
}

$forum_count = $cat_count = $uniq = 0;

$kdata = array('info' => array('id', 'parent', 'posts', 'topics', 'type'));

$posts = $topics = array();

$sql = 'SELECT forum_posts, right_id, left_id, parent_id, forum_id, forum_name, forum_type, forum_desc, forum_image, forum_topics, forum_desc_uid, forum_desc_bitfield, forum_desc_options, forum_flags, forum_link, forum_password
	FROM ' . FORUMS_TABLE . '
	ORDER BY forum_type, left_id ASC';
$result = $db->sql_query($sql, $block_cache_time);

while ($row = $db->sql_fetchrow($result))
{
	$forum_id = $row['forum_id'];

	$allow_read = $auth->acl_get('f_read', $row['forum_id']);

	if ($allow_read)
	{
		$forum_count++;

		$kdata['count'] = $forum_id;
		$kdata[$forum_id]['id'] = $forum_id;
		$kdata[$forum_id]['parent'] = $row['parent_id'];
		$kdata[$forum_id]['posts'] = $row['forum_posts'];
		$kdata[$forum_id]['topics'] = $row['forum_topics'];
		$kdata[$forum_id]['type'] = $row['forum_type'];
	}

	if($row['forum_type'] == 0)
	{
		$cat_count++;
	}

	if ($row['forum_type'] != FORUM_LINK && $allow_read)
	{
		$u_viewforum = append_sid("{$phpbb_root_path}viewforum.$phpEx", 'f=' . $row['forum_id']);
	}
	else
	{
		// If the forum is a link and we count redirects we need to visit it
		// If the forum has a password or no read access we do not expose the link, but instead handle it in viewforum
		if (($row['forum_flags'] & FORUM_FLAG_LINK_TRACK) || $row['forum_password'] || !$allow_read)
		{
			$u_viewforum = append_sid("{$phpbb_root_path}viewforum.$phpEx", 'f=' . $row['forum_id']);
		}
		else
		{
			$u_viewforum = $row['forum_link'];
		}
	}

	if ($forum_count > 0 || $row['forum_type'] == 2 || $row['forum_type'] == 1 && $row['parent_id'] == 0)
	{
		//only dispaly main categories and link forums//
		//if($u_viewforum && $row['forum_type'] == 0 && $auth->acl_get('f_list', $forum_id) || $row['forum_type'] == 2 && $auth->acl_get('f_list', $forum_id))

		//Depend on what you want to show... Show Categories and Link forums and forums where no category is specified ///
		if ($u_viewforum && $auth->acl_get('f_list', $forum_id) && $row['forum_type'] == 0 || $row['forum_type'] == 2 || $row['forum_type'] == 1 && $row['parent_id'] == 0)
		{
			//$row['forum_name'] = sgp_checksize ($row['forum_name'],20);

			$store[] = array(
				's_is_cat'				=> ($row['forum_type'] == FORUM_LINK) ? '' : 'POSTS',
				's_is_link'				=> ($row['forum_type'] == FORUM_LINK) ? 'CLICKS' : '',
				'forum_id'				=> $row['forum_id'],
				'forum_name'			=> $row['forum_name'],
				'forum_desc'			=> generate_text_for_display($row['forum_desc'], $row['forum_desc_uid'], $row['forum_desc_bitfield'], $row['forum_desc_options']),
				'cat_forum_count'		=> $forum_count,
				'forum_topics'			=> isset($kdata[$forum_id]['topics']) ? $kdata[$forum_id]['topics'] : '',
				'forum_posts'			=> isset($kdata[$forum_id]['posts']) ? @$kdata[$forum_id]['posts'] : '',
				'clicks'				=> ($row['forum_type'] != FORUM_LINK || $row['forum_flags'] & FORUM_FLAG_LINK_TRACK) ? $row['forum_posts'] : '',
				'forum_image_src'		=> ($row['forum_image']) ? $phpbb_root_path . $row['forum_image'] : $phpbb_root_path . 'images/forum_icons/default.png',
				'u_viewforum'			=> $u_viewforum,
				's_cat_count'			=> $cat_count,
				'forum_type'			=> $row['forum_type'],
				'unique'				=> $uniq++,
			);
	    }
	}
}
$db->sql_freeresult($result);

$ids = array();
$posts = array();
$topics = array();
$forum = array();

for ($j = 0; $j < count($kdata); $j++)
{
	for ($k = 0; $k < count($kdata); $k++)
	{
		// Categories and Link forums
		if (isset($kdata[$k]['parent']) && isset($kdata[$j]['id']) && $kdata[$j]['id'] == $kdata[$k]['parent'])
		{
			@$posts [$kdata[$j]['id']] += $kdata[$k]['posts'];
			@$topics[$kdata[$j]['id']] += $kdata[$k]['topics'];
			@$forum [$kdata[$j]['id']] += $kdata[$k]['type'];
		}
		else if (isset($kdata[$k]['parent']) && $kdata[$k]['parent'] == 0 && $kdata[$k]['type'] != 2)  // forums with no category and not links
		{
			@$posts [$kdata[$j]['id']] += $kdata[$k]['posts'];
			@$topics[$kdata[$j]['id']] += $kdata[$k]['topics'];
			@$forum [$kdata[$j]['id']] += $kdata[$k]['type'];
		}
	}
}

for ($j = 0; $j < count($store); $j++)
{
	$template->assign_block_vars('iforumrow', array(
		'S_IS_CAT'				=> $store[$j]['s_is_cat'],
		'S_IS_LINK'				=> $store[$j]['s_is_link'],
		'FORUM_ID'				=> $store[$j]['forum_id'],
		'FORUM_NAME'			=> $store[$j]['forum_name'],
		'FORUM_DESC'			=> $store[$j]['forum_desc'],
		'CAT_FORUM_COUNT'		=> isset($forum [$store[$j]['forum_id']]) ? $forum [$store[$j]['forum_id']] : '',
		'FORUM_TOPICS'			=> isset($topics[$store[$j]['forum_id']]) ? $topics[$store[$j]['forum_id']] : '',
		'FORUM_POSTS'			=> isset($posts [$store[$j]['forum_id']]) ? $posts [$store[$j]['forum_id']] : '',
		'CLICKS'				=> $store[$j]['clicks'],
		'FORUM_IMAGE_SRC'		=> $store[$j]['forum_image_src'],
		'U_VIEWFORUM'			=> $store[$j]['u_viewforum'],
		'S_CAT_COUNT'			=> $store[$j]['s_cat_count'],
		'FORUM_TYPE'			=> $store[$j]['forum_type'],
		'UNIQUE'				=> $store[$j]['unique'],
	));
}

$template->assign_vars(array(
	'S_TOTAL_CATS' 	=> $cat_count,
	'FORUM_CATEGORIES_DEBUG'	=> sprintf($user->lang['PORTAL_DEBUG_QUERIES'], ($queries) ? $queries : '0', ($cached_queries) ? $cached_queries : '0', ($total_queries) ? $total_queries : '0'),
));


?>