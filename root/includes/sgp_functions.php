<?php
/**
*
* @package phpBB3
* @version $Id: sgp_functions.php 336 2009-01-23 02:06:37Z Michealo $
* @copyright (c) Michael O'Toole 2005 phpBBireland
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* Last updated: 28 September 2010 by Mike
* Do not remove copyright from any file.
*/

/*
* A couple of functions rescued from functions.php
* Part of the Acronym code based on the original Acronym copyright 2005 CodeMonkeyX
* @copyright (c) 2007 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

/*
* Several of the phpBB functions core are repeated here with two alterations.
*
* Function names are proceeded with 'sgp_' and wrapped in 'function_exists'
* to prevent re-declaration.
*
* It would have been much easier to wrap the function in the phpBB core
* file, however this might cause problems later when adding mods in addition to
* being bad practice...
*/


if ( !defined('IN_PHPBB') )
{
	exit;
}

global $phpbb_root_path;

/***
* Stargate functions starts
*/


/***
* generate random logo
*/
if (!function_exists('sgp_get_rand_logo'))
{
	function sgp_get_rand_logo()
	{
		// initalise variables //
		global $user, $phpbb_root_path, $k_config;
		$rand_logo = "";
		$imglist = "";
		$imgs ="";

		// Random logos are disabled config, so return default logo //
		if ($k_config['k_allow_rotating_logos'] == 0)
		{
			return $user->img('site_logo');
		}

		mt_srand((double)microtime()*1000001);

		$logos_dir = "{$phpbb_root_path}styles/" . $user->theme['theme_path'] . '/theme/images/logos';

		@$handle=opendir($logos_dir);

		// for logo in default directory 	//@$handle=opendir('images/logos');

		if (!$handle) // no handle so we don't have logo directory or we are attempting to login to ACP so we need to return the default logo //
		{
			return($user->img('site_logo'));
		}

		while (false!==($file = readdir($handle)))
		{
			if (stripos($file, ".gif") || stripos($file, ".jpg") || stripos($file, ".png") && stripos($file ,"ogo_"))
			{
				$imglist .= "$file ";
			}
		}
		closedir($handle);

		$imglist = explode(" ", $imglist);

		if (sizeof($imglist) < 2)
		{
			return $user->img('site_logo');
		}

		$random = mt_rand(0, (mt_rand(0, (sizeof($imglist)-2))));

		$image = $imglist[$random];

		$rand_logo .= '<img src="' . $logos_dir . '/' . $image . '" alt="" /><br />';

		// uncomment next line if template assignment is required //
		//$template->assign_vars(array('RAND_LOGO' => $rand_logo));

		return ($rand_logo);
	}
}

/***
* set config value phpbb code reused
*/
if (!function_exists('sgp_acp_set_config'))
{
	function sgp_acp_set_config($config_name, $config_value, $is_dynamic = false)
	{
		global $db, $cache, $k_config;

		$sql = 'UPDATE ' . K_BLOCKS_CONFIG_VAR_TABLE . "
			SET config_value = '" . $db->sql_escape($config_value) . "'
			WHERE config_name = '" . $db->sql_escape($config_name) . "'";
		$db->sql_query($sql);

		if (!$db->sql_affectedrows() && !isset($k_config[$config_name]))
		{
			$sql = 'INSERT INTO ' . K_BLOCKS_CONFIG_VAR_TABLE . ' ' . $db->sql_build_array('INSERT', array(
				'config_name'	=> $config_name,
				'config_value'	=> $config_value,
				'is_dynamic'	=> ($is_dynamic) ? 1 : 0));
			$db->sql_query($sql);
		}

		$k_config[$config_name] = $config_value;

		if (!$is_dynamic)
		{
			$cache->destroy('config');
		}
	}
}
/***
* return a k_config value (may not be required)
*/
if (!function_exists('get_k_config_var'))
{
	function get_k_config_var($item)
	{
		if (isset($item))
		{
			return($item);
		}

		$sql = 'SELECT config_name, config_value
			FROM ' . K_BLOCKS_CONFIG_VAR_TABLE . '
			WHERE config_name = ' . (int)$item;

		$row = $db->sql_fetchrow($result);
		//$k_config[$row['config_name']] = $row['config_value'];
		return $row['config_value'];
	}
}

/***
* little function to create text version for a comnpletion bar 0-100%
*/
if (!function_exists('k_progress_bar'))
{
	function k_progress_bar($percent)
	{
		// $percent = number between 0 and 100 //

		$ss = "";

		// define these in css
		$start = '<b class="green">';	// green
		$middl = '<b class="orange">';	// orange
		$endss = '<b class="red">';		// red

		$tens = $percent / 10; // how many tens //

		if ($percent % 10)
		{
			$i = 1;
		}
		else
		{
			$i = 0;
		}

		for ($i; $i < ($percent / 10); $i++)
		{
			$ss .= '|';
		}

		$start .= $ss . '</b>';

		if ($percent % 10)
		{
			$start .= $middl . '|' . '</b>' . $endss;
		}
		else
		{
			$start .= '' . $endss;
		}

		while ($i++ < 10)
		{
			$start .= '|';
		}

		$start .= '</b>';

		return ' [' . $start . ']';
	}
}


/***
* create a date (old code)
*/
if (!function_exists('create_date'))
{
	function create_date($format, $gmepoch, $tz)
	{
		global $board_config, $lang;
		static $translate;
		global $userdata, $db;

		$switch_summer_time = ( $userdata['user_summer_time'] && $board_config['summer_time'] ) ? true : false;
		if ($switch_summer_time) $tz++;

		if (empty($translate) && $board_config['default_lang'] != 'english')
		{
			@reset($lang['datetime']);
			while ( list($match, $replace) = @each($lang['datetime']) )
			{
				$translate[$match] = $replace;
			}
		}
		return ( !empty($translate) ) ? strtr(@gmdate($format, $gmepoch + (3600 * $tz)), $translate) : @gmdate($format, $gmepoch + (3600 * $tz));
	}
}


/***
* Smilie processing.
*/
if (!function_exists('smilie_text'))
{
	function smilie_text($text, $force_option = false)
	{
		global $config, $user, $phpbb_root_path;

		// could redirect to style based smilies //
		$userstylepath = $phpbb_root_path . $config['smilies_path'] . '/';

		$phpbb_root_path = './';

		return ($force_option || !$config['allow_smilies'] || !$user->optionget('viewsmilies')) ? preg_replace('#<!\-\- s(.*?) \-\-><img src="\{SMILIES_PATH\}\/.*? \/><!\-\- s\1 \-\->#', '\1', $text) : str_replace('<img src="{SMILIES_PATH}', '<img src="' . $userstylepath, $text);
	}
}


/***
* same as truncate_string() with ...
*/

if (!function_exists('sgp_checksize'))
{
	function sgp_checksize($txt,$len)
	{
		if (strlen($txt) > $len)
		{
			$txt = truncate_string($txt, $len);
			$txt .= '...';
		}
		return($txt);
	}
}

/***
*
*/

if (!function_exists('smilies_pass'))
{
	function smilies_pass($message)
	{
		static $orig, $repl;

		if (!isset($orig))
		{

			global $db, $images, $portal_config, $var_cache, $phpbb_root_path, $config;

			$orig = $repl = array();

			if (!$orig)
			{
				$sql = 'SELECT * FROM ' . SMILIES_TABLE;
				if ( !$result = $db->sql_query($sql) )
				{
					trigger_error($user->lang['ERROR_SMILIES_DATA'] , __LINE__, __FILE__, $sql);
				}
				$smilies = $db->sql_fetchrowset($result);

				if (count($smilies))
				{
					usort($smilies, "smiley_sort");
				}

				for ($i = 0; $i < count($smilies); $i++)
				{
					$orig[] = "/(?<=.\W|\W.|^\W)" . phpbb_preg_quote($smilies[$i]['code'], "/") . "(?=.\W|\W.|\W$)/";
					$repl[] = '<img src="'. $phpbb_root_path . $config['smilies_path'] . '/' . $smilies[$i]['smiley_url'] . '" alt="' . $smilies[$i]['emotion'] . '" border="0" />';
				}

				if ($portal_config['cache_enabled'])
				{
					$var_cache->save($orig, 'orig2', 'smilies');
					$var_cache->save($repl, 'repl2', 'smilies');
				}
			}
		}

		if (count($orig))
		{
			$message = preg_replace($orig, $repl, ' ' . $message . ' ');
			$message = substr($message, 1, -1);
		}

		return $message;
	}
}

/***
* sort smilies
*/

if (!function_exists('smiley_sort'))
{
	function smiley_sort($a, $b)
	{
		if ( strlen($a['code']) == strlen($b['code']) )
		{
			return 0;
		}

		return ( strlen($a['code']) > strlen($b['code']) ) ? -1 : 1;
	}
}

/***
* search block search
*/

if (!function_exists('search_block_func'))
{
	function search_block_func()
	{
		global $lang, $template, $portal_config, $board_config, $keywords, $phpbb_root_path;

		$phpEx = substr(strrchr(__FILE__, '.'), 1);

		$template->assign_vars(array(
			"L_SEARCH_ADV"		=> $lang['SEARCH_ADV'],
			"L_SEARCH_OPTION"	=> (!empty($portal_config['search_option_text'])) ? $portal_config['search_option_text'] : $board_config ['sitename'],
			'U_SEARCH'			=> append_sid("{$phpbb_root_path}search.$phpEx", 'keywords=' . urlencode($keywords)),
			)
		);
	}
}

/**
*	returns the users group name (phpbb code reused)
*/

if (!function_exists('which_group'))
{
	function which_group($id)
	{
		global $db, $template;

		// Get group name for this user
		$sql = 'SELECT group_name
			FROM ' . GROUPS_TABLE . '
			WHERE group_id = ' . $id;

		$result = $db->sql_query($sql,650);

		$name = $db->sql_fetchfield('group_name');

		$db->sql_freeresult($result);

		// mb_convert_case is not available in some versions //
		//$name = mb_convert_case($name, MB_CASE_TITLE, "UTF-8");

		if ($name == '')
		{
			return('None');
		}
		else
		{
			return ($name);
		}
	}
}

/***
* get all group names (used to avoid problems with group ID's changing) phpBB 2
* (phpbb code reused)
*/

/*
if (!function_exists('get_all_groups'))
{
	function get_all_groups()
	{

		global $db, $template, $k_groups, $k_group_id, $k_group_name_id;

		// Get us all the groups
		$sql = 'SELECT group_id, group_name
			FROM ' . GROUPS_TABLE . '
			ORDER BY group_id ASC, group_name';
		$result = $db->sql_query($sql,600);
		$i = 0;
		while ($row = $db->sql_fetchrow($result))
		{
			$k_groups[$i++] = $row['group_name'];
			$k_group_id[$row['group_id']] = $row;
			$k_group_name_id[$row['group_name']] = $row['group_id'];
		}
		$db->sql_freeresult($result);
	}
}
*/

/*
* A simple function to replace variables in pages with values if the are present in either config or $k_config tables
* The format used mimics the standard, for example: {STARGATE_VERSION}
*
* This needs to be cached!!!!!
*/
/*
if (!function_exists('process_for_vars'))
{
	function process_for_vars($data)
	{
		global $config, $k_config;

		$a = array('{', '}');
		$b = array('','');

		$replace = array();

		$searchs = s_get_vars_array();

		foreach ($searchs as $search)
		{
			$find = $search;

			// convert to normal text //
			$search = str_replace($a, $b, $search);
			$search = strtolower($search);

			if (isset($k_config[$search]))
			{
				$replace = (isset($k_config[$search])) ? $k_config[$search] : '';
				$data = str_replace($find, $replace, $data);
			}
			else if (isset($config[$search]))
			{
				$replace = (isset($config[$search])) ? $config[$search] : '';
				$data = str_replace($find, $replace, $data);
			}
		}
		return($data);
	}
}
*/

if (!function_exists('process_for_vars'))
{
	function process_for_vars($data)
	{
		global $config, $k_config, $k_resources;

		$a = array('{', '}');
		$b = array('','');

		$replace = array();

		foreach ($k_resources as $search)
		{
			$find = $search;

			// convert to normal text //
			$search = str_replace($a, $b, $search);
			$search = strtolower($search);

			if (isset($k_config[$search]))
			{
				$replace = (isset($k_config[$search])) ? $k_config[$search] : '';
				$data = str_replace($find, $replace, $data);
			}
			else if (isset($config[$search]))
			{
				$replace = (isset($config[$search])) ? $config[$search] : '';
				$data = str_replace($find, $replace, $data);
			}
		}
		return($data);
	}
}



// Stargate Random Banner mod //
global $k_config, $template, $phpbb_root_path, $user;

/*
if ($k_config['rand_banner'] != 0)
{
	$image = get_random_image($phpbb_root_path . 'images/rand_banner', true);
	$template->assign_vars(array(
		'RAND_BANNER' => $image,
		'RAND_BANNER_POSITION' => $k_config['rand_banner'],
	));
}

if ($k_config['rand_header'] == 1)
{
	global $user, $template, $config, $k_config;

	// get an image but don't parse it...
	// we now use the styles own folder...

	// as this file may be called for one or more functions the $user->theme['theme_path'] may not be visible so hide errors //
	@$path = $phpbb_root_path . 'styles/' . $user->theme['theme_path'] . '/theme/images/headers';

 	$image = get_random_image($path, false, 'header_', true);

	$template->assign_vars(array(
		'RAND_HEADER_IMG' => $image,
		'RAND_HEADER_OPT' => $k_config['rand_header'],
	));
}
*/

/*
if (!function_exists('sgp_delete_cookies'))
{
	function sgp_delete_cookies()
	{
		global $user, $phpbb_root_path, $phpEx;

		if (confirm_box(true))
		{
			$user->set_cookie('sgp_right', '', 1);
			$user->set_cookie('sgp_center', '', 1);
			$user->set_cookie('sgp_left', '', 1);
			$user->set_cookie('sgp_block_cache', '0', 1);
			$user->set_cookie('sgp_style_colour', '', 1);
		}
		else
		{
			confirm_box(false, 'DELETE_SGP_COOKIES_CONFIRM', '');
		}

		meta_refresh(3, append_sid("{$phpbb_root_path}portal.$phpEx"));

		$message = $user->lang['SGP_COOKIES_DELETED'] . '<br /><br />' . sprintf($user->lang['RETURN_PORTAL'], '<a href="' . append_sid("{$phpbb_root_path}portalx.$phpEx") . '">', '</a>');
		trigger_error($message);
	}
}
*/

if (!function_exists('get_user_data'))
{
	function get_user_data($what = '', $id)
	{
		global $db, $template, $user;

		if (!$id)
		{
			return($user->lang['NO_ID_GIVEN']);
		}

		// Get user info
		$sql = 'SELECT user_id, username, user_colour
			FROM ' . USERS_TABLE . '
			WHERE user_id = ' . $id. ' LIMIT 1';

		$result = $db->sql_query($sql,10);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		switch($what)
		{
			case 'name':
				return($row['username']);

			case 'full':
				return(get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']));

			default:
				return;
		}
	}
}

/*
if (!function_exists('make_link_img_name'))
{
	function make_link_img_name($img)
	{
		$find		=	array("/","?","+");
		$replace	=	array("#", "@", "$");
		$lnk = str_replace($find, $replace, $img);
		return($lnk);
	}
}
			'INFO'	=> make_link_img_name("www.my_site.com/folder/index.php?this_bit+0"),
*/



/**
* Return all page in a given path or template assign them
*
* @param string $path The path to search
* @param string $token A token to include in the search
* @param string $publish Template assign in file list
*
* @return bool Returns true if the password is correct, false if not.
*/

if (!function_exists('sgp_get_file_list'))
{
	function sgp_get_file_list($path, $token = '.', $publish = false)
	{
		$dirs = '';
		$dirslist ='';

		if ($path == '')
		{
			if (DEBUG_EXTRA) echo 'Debug notice: Path not found';
			return;
		}

		@$handle = opendir($path);

		if (!$handle)
		{
			if (DEBUG_EXTRA) echo 'Debug notice: No handle for:[' . $path . ']';
			return;
		}

		while (false!==($file = readdir($handle)))
		{
			if ($file != '.' and $file != '..')
				$dirslist .= "$file ";
		}
		closedir($handle);

		$dirslist = explode(" ", $dirslist);
		sort($dirslist);

		if ($publish)
		{
			for ( $i=0; $i < sizeof($dirslist); $i++ )
			{
				if ($dirslist[$i] != '')
					$template->assign_block_vars('sgp_file_list', array('S_VAR_FILE_NAME' => $dirslist[$i]));
			}
			$dirslist = '';
			//return;
		}
		else
		{
			// Can this not be done with pointers...
			// Would rather return pounter to list that the actual list?
			return($dirslist);
		}
		//return;
	}
}




/**
* (phpbb code reused)
* Get user rank title and image rewrite for portal to avoid re-declaration copyright phhpBB
*
* @param int $user_rank the current stored users rank id
* @param int $user_posts the users number of posts
* @param string &$rank_title the rank title will be stored here after execution
* @param string &$rank_img the rank image as full img tag is stored here after execution
* @param string &$rank_img_src the rank image source is stored here after execution
*
* Note: since we do not want to break backwards-compatibility, this function will only properly assign ranks to guests if you call it for them with user_posts == false
*/

if (!function_exists('sgp_get_user_rank'))
{
	function sgp_get_user_rank($user_rank, $user_posts, &$rank_title, &$rank_img, &$rank_img_src)
	{
		global $ranks, $config, $phpbb_root_path;

		if (empty($ranks))
		{
			global $cache;
			$ranks = $cache->obtain_ranks();
		}

		if (!empty($user_rank))
		{
			$rank_title = (isset($ranks['special'][$user_rank]['rank_title'])) ? $ranks['special'][$user_rank]['rank_title'] : '';
			$rank_img = (!empty($ranks['special'][$user_rank]['rank_image'])) ? '<img src="' . $phpbb_root_path . $config['ranks_path'] . '/' . $ranks['special'][$user_rank]['rank_image'] . '" alt="' . $ranks['special'][$user_rank]['rank_title'] . '" title="' . $ranks['special'][$user_rank]['rank_title'] . '" />' : '';
			$rank_img_src = (!empty($ranks['special'][$user_rank]['rank_image'])) ? $phpbb_root_path . $config['ranks_path'] . '/' . $ranks['special'][$user_rank]['rank_image'] : '';
		}
		else if ($user_posts !== false)
		{
			if (!empty($ranks['normal']))
			{
				foreach ($ranks['normal'] as $rank)
				{
					if ($user_posts >= $rank['rank_min'])
					{
						$rank_title = $rank['rank_title'];
						$rank_img = (!empty($rank['rank_image'])) ? '<img src="' . $phpbb_root_path . $config['ranks_path'] . '/' . $rank['rank_image'] . '" alt="' . $rank['rank_title'] . '" title="' . $rank['rank_title'] . '" />' : '';
						$rank_img_src = (!empty($rank['rank_image'])) ? $phpbb_root_path . $config['ranks_path'] . '/' . $rank['rank_image'] : '';
						break;
					}
				}
			}
		}
	}
}

/**
* Build all minimods added 307-001 Mike
*/
if (!function_exists('sgp_build_minimods'))
{
	function sgp_build_minimods()
	{
		global $phpbb_root_path, $user, $template, $db, $k_config, $config, $k_config, $phpEx;
		$block_cache_time = $k_config['k_block_cache_time_default'];

		$queries = $cached_queries = $i = $j= 0;
		$same_mod_count = 1;
		$stored_mod_type = $mod_type = '';
		$mod_bbcode_bitfield = '';
		$filename = '';

		$select_allow = ($config['override_user_style']) ? false : true;

		$sql = "SELECT * FROM " . K_MODULES_TABLE . "
			WHERE mod_status > 0
				ORDER BY mod_type, mod_origin DESC ";

		if (!$result1 = $db->sql_query($sql, $block_cache_time))
		{
			trigger_error($user->lang['ERROR_PORTAL_MENUS'] . basename(dirname(__FILE__)) . '/' . basename(__FILE__) . ', line ' . __LINE__);
		}

		$mod = array();

		while ($row = $db->sql_fetchrow($result1))
		{
			$mods[] = $row;
		}

		foreach ($mods as $mod)
		{
			$mod_type = $mod['mod_type'];

			switch ($mod['mod_download_count'])
			{
				case 0:		$mod['mod_download_count'] = sprintf($user->lang['DOWNLOAD_COUNT_NONE'], $mod['mod_download_count']); break;
				case 1:		$mod['mod_download_count'] = sprintf($user->lang['DOWNLOAD_COUNT'], $mod['mod_download_count']); break;
				default:	$mod['mod_download_count'] = sprintf($user->lang['DOWNLOAD_COUNTS'], $mod['mod_download_count']); break;
			}

			if ($mod_type == $stored_mod_type)
			{
				$same_mod_count++;
			}
			else
			{
				$same_mod_count = 1;
			}

			$info = process_for_vars(htmlspecialchars_decode($mod['mod_details']));
			$info = acronym_pass($info);

			$mod_bbcode_bitfield = $mod_bbcode_bitfield | base64_decode($mod['mod_bbcode_bitfield']);

			// Instantiate BBCode class
			if (!isset($bbcode) && $mod_bbcode_bitfield !== '')
			{
				if (!class_exists('bbcode'))
				{
					include($phpbb_root_path . 'includes/bbcode.' . $phpEx);
				}
				$bbcode = new bbcode(base64_encode($mod_bbcode_bitfield));
			}

			if ($mod['mod_bbcode_bitfield'])
			{
				$bbcode->bbcode_second_pass($info, $mod['mod_bbcode_uid'], $mod['mod_bbcode_bitfield']);
			}

			$info = bbcode_nl2br($info);
			$info = smiley_text($info);

			$filename = $phpbb_root_path . 'download/file.php?name=' . $mod['mod_filename'] . '.zip';

			// separate out our mods //
			if ($mod['mod_origin'])
			{
				$template->assign_block_vars('our_mod_'. $mod['mod_type'] . '_row', array(
					'MOD_NAME'				=> $mod['mod_name'],
					'MOD_TYPE'				=> $mod['mod_type'],
					'MOD_ORIGIN'			=> $mod['mod_origin'],
					'MOD_VERSION'			=> $mod['mod_version'],
					'MOD_IMG'				=> $phpbb_root_path . 'images/style_thumbs/' . $mod['mod_thumb'],
					'MOD_THUMB'				=> $phpbb_root_path . 'images/style_thumbs/thumbs/' . $mod['mod_thumb'],
					'MOD_UPDATED'			=> $mod['mod_last_update'],
					'MOD_AUTHOR'			=> $mod['mod_author'],
					'MOD_AUTHOR_CO'			=> $mod['mod_author_co'],
					'MOD_DETAILS'			=> $info,
					'MOD_THIS'				=> $i++,
					'MOD_COUNT'				=> ($mod['mod_type'] == 'style') ? $j++ : $j,
					'MOD_DOWNLOAD_COUNT'	=> $mod['mod_download_count'],
					'MOD_STATUS'			=> k_progress_bar($mod['mod_status']),
					'MOD_COUNT'				=> $same_mod_count,
					'U_MOD_FILENAME'		=> $filename,
					'U_MOD_LINK'			=> htmlspecialchars_decode($mod['mod_link']),// . $mod['mod_name'],
					'U_MOD_SUPPORT'			=> htmlspecialchars_decode($mod['mod_support_link']),
					'U_MOD_TEST_IT'			=> ($mod['mod_link_id'] && $select_allow) ? $phpbb_root_path . 'portal.php?style=' . $mod['mod_link_id'] : '',
				));
			}
			else
			{
				$template->assign_block_vars('mod_'. $mod['mod_type'] . '_row', array(
					'MOD_NAME'				=> $mod['mod_name'],
					'MOD_TYPE'				=> $mod['mod_type'],
					'MOD_ORIGIN'			=> $mod['mod_origin'],
					'MOD_VERSION'			=> $mod['mod_version'],
					'MOD_IMG'				=> $phpbb_root_path . 'images/style_thumbs/' . $mod['mod_thumb'],
					'MOD_THUMB'				=> $phpbb_root_path . 'images/style_thumbs/thumbs/' . $mod['mod_thumb'],
					'MOD_UPDATED'			=> $mod['mod_last_update'],
					'MOD_AUTHOR'			=> $mod['mod_author'],
					'MOD_AUTHOR_CO'			=> $mod['mod_author_co'],
					'MOD_DETAILS'			=> $info,
					'MOD_THIS'				=> $i++,
					'MOD_COUNT'				=> ($mod['mod_type'] == 'style') ? $j++ : $j,
					'MOD_DOWNLOAD_COUNT'	=> $mod['mod_download_count'],
					'MOD_STATUS'			=> k_progress_bar($mod['mod_status']),
					'MOD_COUNT'				=> $same_mod_count,
					'U_MOD_FILENAME'		=> $filename,
					'U_MOD_LINK'			=> htmlspecialchars_decode($mod['mod_link']),// . $mod['mod_name'],
					'U_MOD_SUPPORT'			=> htmlspecialchars_decode($mod['mod_support_link']),
					'U_MOD_TEST_IT'			=> ($mod['mod_link_id'] && $select_allow) ? $phpbb_root_path . 'portal.php?style=' . $mod['mod_link_id'] : '',
				));
			}
			$stored_mod_type = $mod['mod_type'];
		}

		$template->assign_vars(array(
			'DOWNLOAD_IMG'		=> '<img src="' . $phpbb_root_path . 'images/2download-box-32.png" title="Download" alt="" />',
			'TEST_IT_IMG'		=> '<img src="' . $phpbb_root_path . 'images/gnome-view-fullscreen-32.png" title="Check it out!" alt="" />',
			'PINFO_IMG'			=> '<img src="' . $phpbb_root_path . 'images/information-32.png" title="Info" alt="" />',
		));
	}
}


if (!function_exists('ready_text_for_storage'))
{
	function ready_text_for_storage($data)
	{
		$uid = $bitfield = $options = '';
		$allow_bbcode = $allow_urls = $allow_smilies = true;

		generate_text_for_storage($data, $uid, $bitfield, $options, $allow_bbcode, $allow_urls, $allow_smilies);

		$data_array = array(
			'mod_text'				=> $data,
			'mod_bbcode_uid'		=> $uid,
			'mod_bbcode_bitfield'	=> $bitfield,
			'mod_bbcode_options'	=> $options,
		);
		return($data_array);
	}
}

if (!function_exists('ready_text_from_storage'))
{
	function ready_text_from_storage($row)
	{
		/*
		$sql = 'SELECT text, bbcode_uid, bbcode_bitfield, enable_bbcode, enable_smilies, enable_magic_url
			FROM ' . $table;
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
		*/

		$row['mod_bbcode_options'] = (($row['mod_enable_bbcode']) ? OPTION_FLAG_BBCODE : 0) +
			(($row['mod_enable_smilies']) ? OPTION_FLAG_SMILIES : 0) +
			(($row['mod_enable_magic_url']) ? OPTION_FLAG_LINKS : 0);

		$text = generate_text_for_display($row['mod_text'], $row['mod_bbcode_uid'], $row['mod_bbcode_bitfield'], $row['mod_bbcode_options']);

		return($text);
	}
}


/**
* Obtain list of moderators of each forum
* (phpbb code reused)
*/
if (!function_exists('sgp_get_moderators'))
{
	/**
	* Obtain list of moderators of each forum
	*/
	function sgp_get_moderators(&$forum_moderators, $forum_id = false)
	{
		global $config, $template, $db, $phpbb_root_path, $phpEx, $user, $auth;

		$forum_id_ary = array();

		if ($forum_id !== false)
		{
			if (!is_array($forum_id))
			{
				$forum_id = array($forum_id);
			}

			// Exchange key/value pair to be able to faster check for the forum id existence
			$forum_id_ary = array_flip($forum_id);
		}

		$sql_array = array(
			'SELECT'	=> 'm.*, u.user_colour, g.group_colour, g.group_type',

			'FROM'		=> array(
				MODERATOR_CACHE_TABLE	=> 'm',
			),

			'LEFT_JOIN'	=> array(
				array(
					'FROM'	=> array(USERS_TABLE => 'u'),
					'ON'	=> 'm.user_id = u.user_id',
				),
				array(
					'FROM'	=> array(GROUPS_TABLE => 'g'),
					'ON'	=> 'm.group_id = g.group_id',
				),
			),

			'WHERE'		=> 'm.display_on_index = 1',
		);

		// We query every forum here because for caching we should not have any parameter.
		$sql = $db->sql_build_query('SELECT', $sql_array);
		$result = $db->sql_query($sql, 3600);

		while ($row = $db->sql_fetchrow($result))
		{
			$f_id = (int) $row['forum_id'];

			if (!isset($forum_id_ary[$f_id]))
			{
				continue;
			}

			if (!empty($row['user_id']))
			{
				$forum_moderators[$f_id][] = get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']);
			}
			else
			{
				$group_name = (($row['group_type'] == GROUP_SPECIAL) ? $user->lang['G_' . $row['group_name']] : $row['group_name']);

				if ($user->data['user_id'] != ANONYMOUS && !$auth->acl_get('u_viewprofile'))
				{
					$forum_moderators[$f_id][] = '<span' . (($row['group_colour']) ? ' style="color:#' . $row['group_colour'] . ';"' : '') . '>' . $group_name . '</span>';
				}
				else
				{
					$forum_moderators[$f_id][] = '<a' . (($row['group_colour']) ? ' style="color:#' . $row['group_colour'] . ';"' : '') . ' href="' . append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=group&amp;g=' . $row['group_id']) . '">' . $group_name . '</a>';
				}
			}
		}
		$db->sql_freeresult($result);

		return;
	}
}

/**
* (phpbb code reused)
* Obtain either the members of a specified group, the groups the specified user is subscribed to
* or checking if a specified user is in a specified group. This function does not return pending memberships.
*
* Note: Never use this more than once... first group your users/groups
*/
if (!function_exists('sgp_group_memberships'))
{
	function sgp_group_memberships($group_id_ary = false, $user_id_ary = false, $return_bool = false)
	{
		global $db;

		if (!$group_id_ary && !$user_id_ary)
		{
			return true;
		}

		if ($user_id_ary)
		{
			$user_id_ary = (!is_array($user_id_ary)) ? array($user_id_ary) : $user_id_ary;
		}

		if ($group_id_ary)
		{
			$group_id_ary = (!is_array($group_id_ary)) ? array($group_id_ary) : $group_id_ary;
		}

		$sql = 'SELECT ug.*, u.username, u.username_clean, u.user_email
			FROM ' . USER_GROUP_TABLE . ' ug, ' . USERS_TABLE . ' u
			WHERE ug.user_id = u.user_id
				AND ug.user_pending = 0 AND ';

		if ($group_id_ary)
		{
			$sql .= ' ' . $db->sql_in_set('ug.group_id', $group_id_ary);
		}

		if ($user_id_ary)
		{
			$sql .= ($group_id_ary) ? ' AND ' : ' ';
			$sql .= $db->sql_in_set('ug.user_id', $user_id_ary);
		}

		$result = ($return_bool) ? $db->sql_query_limit($sql, 1, 0, 600, 'sgp') : $db->sql_query($sql, 600);

		$row = $db->sql_fetchrow($result);

		if ($return_bool)
		{
			$db->sql_freeresult($result);
			return ($row) ? true : false;
		}

		if (!$row)
		{
			return false;
		}

		$return = array();

		do
		{
			$return[] = $row;
		}
		while ($row = $db->sql_fetchrow($result));

		$db->sql_freeresult($result);

		return $return;
	}
}

/**
* Get group name (phpbb code reused)
*/
if (!function_exists('sgp_get_group_name'))
{
	function sgp_get_group_name($group_id)
	{
		global $db, $user;

		$sql = 'SELECT group_name, group_type
			FROM ' . GROUPS_TABLE . '
			WHERE group_id = ' . (int) $group_id;
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		if (!$row || ($row['group_type'] == GROUP_SPECIAL && empty($user->lang)))
		{
			return('');
		}

		return ($row['group_type'] == GROUP_SPECIAL) ? $user->lang['G_' . $row['group_name']] : $row['group_name'];
	}
}

if (!function_exists('portal_block_template'))
{
	function portal_block_template($block_file)
	{
		global $template;

		// Set template filename
		$template->set_filenames(array('block' => 'blocks/' . $block_file));

		// Return templated data
		return $template->assign_display('block', true);
	}
}

if (!function_exists('process_for_admin_bbcodes'))
{
	function process_for_admin_bbcodes($data)
	{
		global $user;

		// later pull admin bbcodes from DB //

		if ($user->data['username'] == 'Anonymous')
		{
			$data = str_replace("[you]", $user->lang['GUEST'], $data);
		}
		else
		{
			$data = str_replace("[you]", ('<span style="font-weight:bold; color:#' . $user->data['user_colour'] . ';">' . $user->data['username'] . '</span>'), $data);
		}
		return($data);
	}
}




/*
* Takes the page name
* Returns the pages id
* The query is cached... is there a better method?
*/
if (!function_exists('get_page_id'))
{
	function get_page_id($this_page_name)
	{
		global $db, $user, $k_pages;

/*
		// Basic error checking //
		if ($this_page_name == '')
		{
			trigger_error($user->lang['SOMETHING_WENT_WRONG'] . basename(dirname(__FILE__)) . '/' . basename(__FILE__) . ', line ' . __LINE__);
		}
*/

		foreach ($k_pages as $page)
		{
			if ($page['page_name'] == $this_page_name)
			{
				return($page['page_id']);
			}
		}
		return(0);

/*
		// Get all pages
		$sql = 'SELECT page_id, page_name
			FROM ' . K_PAGES_TABLE . '
			ORDER BY page_id ASC, page_name';
		$result = $db->sql_query($sql, 600);

		while ($row = $db->sql_fetchrow($result))
		{
			$page_id[] = $row['page_id'];
			$page_name[] = $row['page_name'];
		}
		$db->sql_freeresult($result);

		for ($i = 0; $i < count($page_name); $i++)
		{
			if ($this_page_name == $page_name[$i])
			{
				return($page_id[$i]);
			}
		}
		return(0);
*/

	}
}

/**
* Convert Menu Name to language variable... leave alone if not found!
**/
if (!function_exists('get_menu_lang_name'))
{
	function get_menu_lang_name($input)
	{
		global $user;

		// Basic error checking //
		if ($input == '')
		{
			return('');
		}

		$block_title = $input;
		$name = strtoupper($input);
		$name = str_replace(" ","_", $name);
		$block_title = (!empty($user->lang[$name])) ? $user->lang[$name] : $block_title;

		return($block_title);
	}
}

/**
* Takes a phpBB $page name and position (left/right/centre)...
* Returns true/false if the block should be displayed on a giveb page...
**/
if (!function_exists('show_blocks'))
{
	function show_blocks($page, $position)
	{
		global $k_config;

		$page_id = get_page_id($page);

		if ($position == 'L')
		{
			//return($k_config['show_lb_ipsmuy'][$page_id]) ? true : false;
			return(true);
		}
		else if ($position == 'R')
		{
			//return($k_config['show_rb_ipsmuy'][$page_id]) ? true : false;
			return(true);
		}
		else if ($position == 'C')
		{
			//return($k_config['show_rb_ipsmuy'][$page_id]) ? true : false;
			return(true);
		}
	}
}

if (!function_exists('s_get_vars_array'))
{
	function s_get_vars_array()
	{

		global $db, $template;
		$resources = array();

		$sql = 'SELECT * FROM ' . K_RESOURCES_TABLE  . ' ORDER BY word ASC';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$resources[] = $row['word'];
		}

		$db->sql_freeresult($result);
		return($resources);
	}
}

if (!function_exists('s_get_vars'))
{
	function s_get_vars()
	{
		global $db, $template;

		$type = "'V'";

		$sql = 'SELECT * FROM ' . K_RESOURCES_TABLE  . ' WHERE type = ' . $type . ' ORDER BY word ASC';

		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$template->assign_block_vars('adm_vars', array(
				'VAR'	=> $row['word'],
			));
		}
		$db->sql_freeresult($result);
	}
}

/*
* Rewrite of a phpbb function so we can wrap it and call it without additional code
* Wrapping, stops redeclaration errors...
*/
if (!function_exists('is_member'))
{
	function is_member($group_id_ary = false, $user_id_ary = false, $return_bool = false)
	{
		global $db;

		if (!$group_id_ary && !$user_id_ary)
		{
			return true;
		}

		if ($user_id_ary)
		{
			$user_id_ary = (!is_array($user_id_ary)) ? array($user_id_ary) : $user_id_ary;
		}

		if ($group_id_ary)
		{
			$group_id_ary = (!is_array($group_id_ary)) ? array($group_id_ary) : $group_id_ary;
		}

		$sql = 'SELECT ug.*, u.username, u.username_clean, u.user_email
			FROM ' . USER_GROUP_TABLE . ' ug, ' . USERS_TABLE . ' u
			WHERE ug.user_id = u.user_id
				AND ug.user_pending = 0 AND ';

		if ($group_id_ary)
		{
			$sql .= ' ' . $db->sql_in_set('ug.group_id', $group_id_ary);
		}

		if ($user_id_ary)
		{
			$sql .= ($group_id_ary) ? ' AND ' : ' ';
			$sql .= $db->sql_in_set('ug.user_id', $user_id_ary);
		}

		// we cache he resut for 600 //
		$result = ($return_bool) ? $db->sql_query_limit($sql, 1, 0, 600) : $db->sql_query($sql);

		$row = $db->sql_fetchrow($result);

		if ($return_bool)
		{
			$db->sql_freeresult($result);
			return ($row) ? true : false;
		}

		if (!$row)
		{
			return false;
		}

		$return = array();

		do
		{
			$return[] = $row;
		}
		while ($row = $db->sql_fetchrow($result));

		$db->sql_freeresult($result);

		return $return;
	}
}

?>