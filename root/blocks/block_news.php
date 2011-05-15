<?php
/**
*
* @package Stargate Portal
* @author  Michael O'Toole - aka Michaelo
* @begin   Saturday, 31st May, 2008
* @copyright (c) 2005-2008 phpbbireland
* @home    http://www.phpbbireland.com
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @note: Do not remove this copyright. Just append yours if you have modified it,
*        this is part of the Stargate Portal copyright agreement...
*
* @version $Id: block_news_advanced.php 307 2009-01-01 16:05:35Z Michealo $
* Updated: 28 June 2009
*
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

$phpEx = substr(strrchr(__FILE__, '.'), 1);

if (!class_exists('bbcode'))
{
	include($phpbb_root_path . 'includes/bbcode.' . $phpEx);
}

global $k_config, $k_blocks;

$queries = $cached_queries = 0;

foreach ($k_blocks as $blk)
{
	if ($blk['html_file_name'] == 'block_news.html')
	{
		$block_cache_time = $blk['block_cache_time'];
	}
}
$block_cache_time = (isset($block_cache_time) ? $block_cache_time : $k_config['k_block_cache_time_default']);

// Get portal cache data
$k_news_items_to_display = $k_config['k_news_items_to_display'];
$k_news_item_max_length = $k_config['k_news_item_max_length'];
$k_news_allow = $k_config['k_news_allow'];
$k_news_type = $k_config['k_news_type'];

$bbcode_bitfield = $a_type = $where_attachments = '';
$has_attachments = $display_notice = false;
$attach_list = $post_list = $posts = $attachments = $extensions = array();
$time_now = time();

// Build sql WHERE clause based on $config['k_news_type']... //fix stu http://www.phpbbireland.com/phpBB3/viewtopic.php?p=16804
switch($k_news_type)
{
	case 0:   // both
		$a_type = "(t.topic_id = p.topic_id AND t.topic_type = 4 AND t.topic_status <> 2 AND (t.topic_time_limit = 0 OR (t.topic_time + t.topic_time_limit)  >  $time_now) OR " . "t.topic_id = p.topic_id AND t.topic_type = 5 AND t.topic_status <> 2 AND (t.topic_time_limit = 0 OR (t.topic_time + t.topic_time_limit)  <  $time_now ))";
	break;

	case 4:   // local News
		$a_type = "(t.topic_id = p.topic_id AND t.topic_type = 4 AND t.topic_status <> 2 AND (t.topic_time_limit = 0 OR (t.topic_time + t.topic_time_limit)  >  $time_now))";
	break;

	case 5:   // global news
		$a_type = "(t.topic_id = p.topic_id AND t.topic_type = 5 AND t.topic_status <> 2 AND (t.topic_time_limit = 0 OR (t.topic_time + t.topic_time_limit)  >  $time_now))";
	break;

	default:	//global news
		$a_type = "(t.topic_id = p.topic_id AND t.topic_type = 5 AND t.topic_status <> 2 AND (t.topic_time_limit = 0 OR (t.topic_time + t.topic_time_limit)  >  $time_now))";
	break;
}

// Search and return all posts of type news including global...
$sql = 'SELECT
		t.forum_id,
		t.topic_id,
		t.topic_status,
		t.topic_time,
		t.topic_time_limit,
		t.topic_title,
		t.topic_replies,
		t.topic_poster,
		t.topic_attachment,
		t.poll_title,
		t.topic_type,
		t.topic_time_limit,
		p.poster_id,
		p.topic_id,
		p.post_text,
		p.bbcode_uid,
		p.post_approved,
		p.post_id,
		p.post_time,
		p.enable_smilies,
		p.enable_bbcode,
		p.enable_magic_url,
		p.bbcode_bitfield,
		p.bbcode_uid,
		p.post_attachment,
		u.username,
		u.user_colour,
		f.forum_name
	FROM
		' . TOPICS_TABLE . ' AS t,
		' . POSTS_TABLE . ' AS p,
		' . USERS_TABLE . ' AS u,
		' . FORUMS_TABLE . ' AS f
	WHERE
		' . $a_type . ' AND
		t.topic_poster = u.user_id AND
           p.post_time = t.topic_time AND
			t.forum_id = f.forum_id
	ORDER BY
		t.topic_time DESC';

// query the database
if(!($result = $db->sql_query_limit($sql, (($k_news_items_to_display) ? $k_news_items_to_display : 1), 0, $block_cache_time)))
{
	trigger_error('ERROR_PORTAL_NEWS' . basename(dirname(__FILE__)) . '/' . basename(__FILE__) . ', line ' . __LINE__);
}

$i = 0;
while ($row = $db->sql_fetchrow($result))
{
	if ($auth->acl_get('f_read', $row['forum_id']))
	{
		// Do post have an attachment? If so, add them to the list //
		if ($row['post_attachment'] && $config['allow_attachments'])
		{
			$attach_list = $row['post_id'];
			$attach_list_forums = $row['forum_id'];

			if ($row['post_approved'])
			{
				$has_attachments = true;
			}
		}
		$post_list[$i++] = $row['post_id'];

		// store all data for now //
		$rowset[$row['post_id']] = array(
			'post_id'			=> $row['post_id'],
			'post_text'			=> $row['post_text'],
			'topic_id'			=> $row['topic_id'],
			'forum_id'			=> $row['forum_id'],
			'post_id'			=> $row['post_id'],
			'poster_id'			=> $row['poster_id'],
			'topic_replies'		=> $row['topic_replies'],
			'topic_time'		=> $user->format_date($row['post_time']),
			'topic_title'		=> $row['topic_title'],
			'topic_type'		=> $row['topic_type'],
			'topic_status'		=> $row['topic_status'],
			'username'			=> $row['username'],
			'user_colour'		=> $row['user_colour'],
			'poll_title'		=> ($row['poll_title']) ? true : false,
			'post_time'			=> create_date($config['default_dateformat'], $row['post_time'],  $config['board_timezone']),
			'topic_time'		=> create_date($config['default_dateformat'], $row['topic_time'], $config['board_timezone']),
			'post_approved'		=> $row['post_approved'],
			'post_attachment'	=> $row['post_attachment'],
			'bbcode_bitfield'	=> $row['bbcode_bitfield'],
			'bbcode_uid'		=> $row['bbcode_uid'],
			'forum_name'		=> $row['forum_name'],
		);

		// Define the global bbcode bitfield, will be used to load bbcodes
		$bbcode_bitfield = $bbcode_bitfield | base64_decode($row['bbcode_bitfield']);

		// build a list of allowed posts containing attachments //
		if ($row['post_attachment'] && $config['allow_attachments'])
		{
			global $cache;

			$where_attachments .= $row['post_id'] . ', ';
			$extensions .= $cache->obtain_attach_extensions($row['forum_id']);
		}
	}
}
$db->sql_freeresult($result);

// Pull attachment data
if (sizeof($attach_list))
{
	$where_attachments = rtrim($where_attachments, ', ');

	if ($where_attachments == '')
	{
		$where_attachments = '1';
	}

	if ($auth->acl_get('u_download'))
	{
		$sql = 'SELECT *
			FROM ' . ATTACHMENTS_TABLE . '
			WHERE post_msg_id IN (' . $where_attachments . ')
				AND in_message = 0
			ORDER BY filetime DESC';
		$result = $db->sql_query($sql, 300);

		while($row = $db->sql_fetchrow($result))
		{
			$attachments[$row['post_msg_id']][] = $row;
			$attachmentss[$row['post_msg_id']][] = $row;
		}
		$db->sql_freeresult($result);
	}
	else
	{
		$display_notice = true;
	}
}


// Instantiate BBCode if need be
if ($bbcode_bitfield !== '')
{
	$bbcode = new bbcode(base64_encode($bbcode_bitfield));
}

for ($i = 0, $end = sizeof($post_list); $i < $end; ++$i)
{
	if (!isset($rowset[$post_list[$i]]))
	{
		continue;
	}

	$store = 0;
	$row =& $rowset[$post_list[$i]];

	// Size the message to max length set in ACP
	if (($k_news_item_max_length != 0) && (strlen($row['post_text']) > $k_news_item_max_length))
	{
		$row['post_text'] = sgp_truncate_message($row['post_text'], $k_news_item_max_length);
		$row['post_text'] .= ' <a href="' . append_sid("{$phpbb_root_path}viewtopic.$phpEx", 'f=' . (($row['forum_id']) ? $row['forum_id'] : $forum_id) . '&amp;t=' . $row['topic_id']) . '"><strong>[' . $user->lang['VIEW_FULL_ARTICLE']  . ']</strong></a>';
	}

	// Parse the message
	$message = censor_text($row['post_text']);
	//$message = acronym_pass($message);

	// Second parse bbcode here
	if ($row['bbcode_bitfield'])
	{
		$bbcode->bbcode_second_pass($message, $row['bbcode_uid'], $row['bbcode_bitfield']);
	}

	$message = bbcode_nl2br($message);
	$message = smiley_text($message);

	if (!empty($attachments[$row['post_id']]))
	{
		parse_attachments($row['forum_id'], $message, $attachments[$row['post_id']], $update_count);
	}

	$forum_id = $row['forum_id'];

	if ($store != $forum_id)
	{
		$store = $forum_id;
	}
	else
	{
		$store = 0;
	}

	$posts[$i]['store'] = $store;

	$postrow = array(
		'CAT'			=> ($posts[$i]['store'] != 0) ? $row['forum_name'] : '',
		'ALLOW_REPLY'	=> ($auth->acl_get('f_reply', $row['forum_id']) && $row['topic_status'] != '1') ? TRUE : FALSE,
		'ALLOW_POST'	=> ($auth->acl_get('f_post', $row['forum_id']) && $row['topic_status'] != '1') ? TRUE : FALSE,
		'POSTER'		=> '<span style="color:#' . $row['user_colour'] . ';">' . $row['username'] . '</span>',
		'TIME'			=> $row['post_time'],
		'TITLE'			=> $row['topic_title'],
		'MESSAGE'		=> $message,

		'U_POSTER'		=> get_username_string('full', $row['poster_id'], $row['username'], $row['user_colour']),
		'U_VIEW'		=> append_sid("{$phpbb_root_path}viewtopic.$phpEx", 'f=' . (($row['forum_id']) ? $row['forum_id'] : $forum_id) . '&amp;t=' . $row['topic_id']),
		'U_REPLY'		=> append_sid($phpbb_root_path . 'posting.' . $phpEx . '?mode=reply&amp;t=' . $row['topic_id'] . '&amp;f=' . $row['forum_id']),
		'U_PRINT'		=> ($auth->acl_get('f_print', $row['forum_id'])) ? append_sid("{$phpbb_root_path}viewtopic.$phpEx", "f=" . $row['forum_id'] . " &amp;t=" . $row['topic_id'] . "&amp;view=print") : '',
		'U_REPLY_IMG'	=> '<img src="' . $phpbb_root_path . 'styles/' . $user->theme['imageset_path'] . '/imageset/blocks/post_comment.png'  . '" title="' . $user->lang['POST_COMMENTS']  . '" alt="' . $user->lang['POST_COMMENTS']  . '" />',
		'U_PRINT_IMG' 	=> '<img src="' . $phpbb_root_path . 'styles/' . $user->theme['imageset_path'] . '/imageset/blocks/post_print.png' . '" title="' . $user->lang['PRINT_IT']  . '" alt="' . $user->lang['PRINT_IT']  . '" />',
		'U_VIEW_IMG'	=> '<img src="' . $phpbb_root_path . 'styles/' . $user->theme['imageset_path'] . '/imageset/blocks/post_view.png' . '" title="' . $user->lang['VIEW_FULL_ARTICLE']  . '" alt="' . $user->lang['VIEW_FULL_ARTICLE']  . '" />',

		'S_TOPIC_TYPE'	=> $row['topic_type'],
		'S_NOT_LAST'	=> ($i < sizeof($posts) - 1) ? true : false,
		'S_ROW_COUNT'	=> $i,
		'S_POST_UNAPPROVED'	=> ($row['post_approved']) ? false : true,
		'S_DISPLAY_NOTICE'	=> $display_notice,

		'S_HAS_ATTACHMENTS'	=> (!empty($attachments[$row['post_id']])) ? true : false,
		'S_DISPLAY_NOTICE'	=> $display_notice && $row['post_attachment'],
	);

	$template->assign_block_vars('news_row', $postrow);

	// Display not already displayed Attachments for this post, we already parsed them. ;)
	if (!empty($attachments[$row['post_id']]))
	{
		foreach ($attachments[$row['post_id']] as $attachment)
		{
			$template->assign_block_vars('news_row.attachment', array(
				'DISPLAY_ATTACHMENT'	=> $attachment)
			);
		}
	}

	unset($rowset[$post_list[$i]]);
	unset($attachments[$row['post_id']]);
}
unset($rowset, $user_cache);

$message = '';

$template->assign_vars(array(
	'S_NEWS_COUNT' 	=> sizeof($posts),
	'S_NEWS_COUNT_RETURNED' => sizeof($post_list),
	'T_IMAGESET_LANG_PATH'	=> "{$phpbb_root_path}styles/" . $user->theme['imageset_path'] . '/imageset/' . $user->data['user_lang'],

	'NEWS_ADVANCED_DEBUG'	=> sprintf($user->lang['PORTAL_DEBUG_QUERIES'], ($queries) ? $queries : '0', ($cached_queries) ? $cached_queries : '0', ($total_queries) ? $total_queries : '0'),
));

// END: Fetch News //
?>