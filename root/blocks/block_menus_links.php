<?php
/**
*
* @package Stargate Portal
* @author  Michael O'Toole - aka Michaelo
* @begin   Saturday, 15th November, 2005
* @copyright (c) 2005-2008 phpbbireland
* @home    http://www.phpbbireland.com
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @note: Do not remove this copyright. Just append yours if you have modified it,
*        this is part of the Stargate Portal copyright agreement...
*
* @version $Id: block_link_menus.php 324 2009-01-17 01:23:22Z Michealo $
* Updated: 15 November 2008 by NeXur
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

	$queries = $cached_queries = 0;

	$user->add_lang('portal/kiss_block_variables');

	include($phpbb_root_path . 'includes/sgp_functions.'. $phpEx );

	global $db, $user, $_SID, $_EXTRA_URL, $k_config, $k_blocks, $k_groups;

	foreach ($k_blocks as $blk)
	{
		if ($blk['html_file_name'] == 'block_sub_menus.html')
		{
			$block_cache_time = $blk['block_cache_time'];
		}
	}
	$block_cache_time = (isset($block_cache_time) ? $block_cache_time : $k_config['k_block_cache_time_default']);

	// menu_type 0 = Header Menu,
	// menu type 1 = Main Nav blocks,
	// menu type 2 = Sub Nav Block
	// menu type 3 = Footer Menu Block
	// menu type 4 = Links Menu Block

	$j = 0;
	$is_sub_heading = false;

	$loop_count = array();
	$portal_link_menus = array();
	$my_names = array();

	$sql = "SELECT * FROM ". K_MENUS_TABLE . "
		WHERE menu_type = 4 && view_by != 0
		ORDER BY ndx ASC";

	if (!$result = $db->sql_query($sql, $block_cache_time))
	{
		trigger_error($user->lang['ERROR_PORTAL_SUB_MENU'] . basename(dirname(__FILE__)) . '/' . basename(__FILE__) . ', line ' . __LINE__);
	}

	$portal_link_menus = array();

	while ($row = $db->sql_fetchrow($result))
	{
		$portal_link_menus[] = $row;
	}
	$db->sql_freeresult($result);

	// $group_name = which_group($user->data['group_id']);  // change to get_group_name - do we need this one anymore? see below...

	//get_all_groups();

	$memberships = array();
	$memberships = sgp_group_memberships(false, $user->data['user_id'], false);

	for ($i = 0; $i < count($portal_link_menus); $i++)
	{
		$name = strtoupper($portal_link_menus[$i]['name']);						// convert to uppercase //
		$tmp_name = str_replace(' ','_', $portal_link_menus[$i]['name']);        // replace spaces with underscore //

		$name = (!empty($user->lang[$tmp_name])) ? $user->lang[$tmp_name] : $portal_link_menus[$i]['name'];   // get language equivalent //

		$s_id = ''; 														// initiate our var session s_id, if we need to pass session id
		$u_id = ''; 														// initiate our var user u_id, if we need to pass user id
		$isamp = '';														// initiate our var isamp, if we need to use it

		$menu_item_view_by = $portal_link_menus[$i]['view_by'];
		$menu_view_groups = $portal_link_menus[$i]['view_groups'];
		$menu_item_view_all = $portal_link_menus[$i]['view_all'];

		$process_menu_item = false;

		if ($menu_item_view_all != 0)
		{
			$grps = explode(",", $menu_view_groups);

			if ($memberships)
			{
				foreach ($memberships as $member)
				{
					if ($menu_item_view_by == $member['group_id'] || $menu_item_view_all == 1)
					{
						$process_menu_item = true;
					}
					else
					{
						for ($j = 0; $j < count($grps); $j++)
						{
							if ($grps[$j] == $member['group_id'])
							{
								$process_menu_item = true;
							}
						}
					}
				}
			}
		}
		else
		{
			$process_menu_item = false;
		}

		if ($portal_link_menus[$i]['append_uid'] == 1)							// do we need to pass user id //
		{
			$isamp = '&amp';
			$u_id = $user->data['user_id'];
		}
		else
		{
			$u_id = '';
			$isamp = '';
		}

		if ($portal_link_menus[$i]['append_sid'] == 1)							// do we need to pass user session id //
		{
			$s_id = '?sid=';
			$s_id .= $user->session_id;
		}
		else
		{
			$s_id = '';
		}

		if ($process_menu_item && $portal_link_menus[$i]['sub_heading'])
		{
			$j++;
		}

		if ($process_menu_item)
		{

			if (strstr($portal_link_menus[$i]['link_to'], 'http'))
			{
				$link = ($portal_link_menus[$i]['link_to']) ? $portal_link_menus[$i]['link_to'] : '';
			}
			else
			{
				$link = ($portal_link_menus[$i]['link_to']) ? append_sid("{$phpbb_root_path}" . $portal_link_menus[$i]['link_to'] . $s_id . $u_id) : '';
			}

			$is_sub_heading = ($portal_link_menus[$i]['sub_heading']) ? true : false;

			$template->assign_block_vars('portal_link_menus_row', array(
				'EXTERN'					=> $portal_link_menus[$i]['extern'],
				'PORTAL_LINK_MENU_HEAD_NAME'	=> ($is_sub_heading) ? $name : '',
				'PORTAL_LINK_MENU_NAME'		=> ($is_sub_heading) ? '' : $name,
				'U_PORTAL_LINK_MENU_LINK'	=> ($is_sub_heading) ? '' : $link,
				'PORTAL_LINK_MENU_ICON'		=> ($portal_link_menus[$i]['menu_icon'] == 'NONE') ? '' : '<img src="' . $phpbb_root_path . 'images/block_images/menu/' . $portal_link_menus[$i]['menu_icon'] . '" alt="" />',
				'S_SOFT_HR'					=> ($is_sub_heading) ? $portal_link_menus[$i]['soft_hr'] : '',
				'S_SUB_HEADING' 			=> ($is_sub_heading) ? true : false,
			));
		}
	}

	$template->assign_vars(array(
		'S_USER_LOGGED_IN'	=> ($user->data['user_id'] != ANONYMOUS) ? true : false,
		'U_INDEX'			=> append_sid("{$phpbb_root_path}index.$phpEx"),
		'U_PORTAL'			=> append_sid("{$phpbb_root_path}portal.$phpEx"),
		'SUB_MENUS_DEBUG'	=> sprintf($user->lang['PORTAL_DEBUG_QUERIES'], ($queries) ? $queries : '0', ($cached_queries) ? $cached_queries : '0', ($total_queries) ? $total_queries : '0'),
	));

?>