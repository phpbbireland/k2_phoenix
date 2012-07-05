<?php
/**
*
* @package acp Stargate Portal
* @version $Id: acp_k_pages.php 305 2010-01-01 17:23:23Z Michealo $
* @copyright (c) 2007 Michael O'Toole aka michaelo
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

/**
* @package acp
*/

class acp_k_pages
{

	var $u_action;

	function main($page_id, $mode)
	{
		global $db, $user, $auth, $template, $cache;
		global $k_config, $config, $SID, $phpbb_root_path, $phpbb_admin_path, $phpEx;

		$current_pages = array();

		include($phpbb_root_path . 'includes/sgp_functions.' . $phpEx);

		$user->add_lang('acp/k_pages');
		$this->tpl_name = 'acp_k_pages';
		$this->page_filename = 'ACP_PAGES';
		$this->page_title = 'ACP_K_PAGES';

		$form_key = 'acp_k_pages';
		add_form_key($form_key);

		//$s_hidden_fields = '';

		$mode = request_var('mode', '');
		$page_id = request_var('page_id', 0);
		$action	= request_var('config', '');
		$tag_id = request_var('tag_id', '');

		$submit = (isset($_POST['submit'])) ? true : false;

		if ($tag_id != '')
		{
			$mode = 'add';
		}

		switch ($action)
		{
			case 'config':
				$template->assign_var('MESSAGE', $user->lang['SWITCHING']);

				meta_refresh(1, append_sid("{$phpbb_admin_path}index.$phpEx", 'i=k_vars&amp;mode=config&amp;switch=k_pages'));
			break;

			default:
			break;
		}

		if ($submit && !check_form_key($form_key))
		{
			$submit = false;
			$mode = '';
			trigger_error($user->lang['FORM_INVALID'] . basename(dirname(__FILE__)) . '/' . basename(__FILE__) . $user->lang['LINE'] . __LINE__);
		}

		$template->assign_vars(array(
			'U_BACK'    => append_sid("{$phpbb_admin_path}index.$phpEx", "i=k_pages&amp;mode=manage"),
			'U_ADD'     => append_sid("{$phpbb_admin_path}index.$phpEx", "i=k_pages&amp;mode=add"),
			'U_MANAGE'  => append_sid("{$phpbb_admin_path}index.$phpEx", "i=k_pages&amp;mode=manage"),
			'S_OPT'     => 'S_MANAGE',
			'S_PAGE'    => isset($k_config['k_landing_page']) ? $k_config['k_landing_page'] : 'portal',
		));

		switch ($mode)
		{
			case 'delete':

				$page_name = get_page_filename($page_id);

				if (confirm_box(true))
				{
					$sql = 'DELETE FROM ' . K_PAGES_TABLE . '
						WHERE page_id = ' . (int)$page_id;

					if (!$result = $db->sql_query($sql))
					{
						trigger_error($user->lang['ERROR_PORTAL_PAGES'] . basename(dirname(__FILE__)) . '/' . basename(__FILE__) . $user->lang['LINE'] . __LINE__);
					}

					$cache->destroy('sql', K_PAGES_TABLE);

					$template->assign_vars(array(
						'S_OPTION' => 'processing',
						'MESSAGE'  => $user->lang['REMOVING_PAGES'] . $page_name,
					));

					meta_refresh(1, append_sid("{$phpbb_admin_path}index.$phpEx", 'i=k_pages&amp;mode=manage'));
					break;
				}
				else
				{
					confirm_box(false, sprintf("%s (%s)", $user->lang['DELETE_FROM_LIST'], $page_name), build_hidden_fields(array(
						'id'      => $page_id,
						'mode'    => $mode,
						'action'  => 'delete'))
					);
				}

				$template->assign_var('MESSAGE', $user->lang['ACTION_CANCELLED']);

				meta_refresh(1, append_sid("{$phpbb_admin_path}index.$phpEx", 'i=k_pages&amp;mode=manage'));

			break;

			case 'add':
				if ($submit)
				{
					// drop extension
					$tag_id = str_replace('.php', '', $tag_id);

					// skip the spacer //
					if ($tag_id == '..')
					{
						$template->assign_vars(array(
							'S_OPTION' => 'processing', // not lang var
							'MESSAGE'  => sprintf($user->lang['ERROR_PAGE'], $tag_id),
						));
						meta_refresh(2, append_sid("{$phpbb_admin_path}index.$phpEx", 'i=k_pages&amp;mode=manage'));
						return;
					}

					if (in_array($tag_id, $current_pages))
					{
						break;
					}

					$sql_array = array(
						'page_name'	=> $tag_id,
					);

		           $db->sql_query('INSERT INTO ' . K_PAGES_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_array));

					meta_refresh(1, append_sid("{$phpbb_admin_path}index.$phpEx", 'i=k_pages&amp;mode=manage'));

					$template->assign_vars(array(
						'S_OPTION' => 'processing', // not lang var
						'MESSAGE'  => $user->lang['ADDING_PAGES'],
					));

					$cache->destroy('sql', K_PAGES_TABLE);
					break;
				}
			break;

			case 'land':

				$page_name = get_page_filename($page_id);

				sgp_acp_set_config('k_landing_page', $page_name, 1);

				$template->assign_vars(array(
					'S_OPTION' => 'processing',
					'MESSAGE'  => $user->lang['LANDING_PAGE_SET'] . ': '. $page_name,
				));

				$cache->destroy('k_config');
				$cache->destroy('sql', K_BLOCKS_CONFIG_VAR_TABLE);

				meta_refresh(1, append_sid("{$phpbb_admin_path}index.$phpEx", 'i=k_pages&amp;mode=manage'));
			break;

			case 'config':
			break;

			case 'manage':
				get_all_available_files();
				get_pages_data();
			break;

			case 'default':
			break;
		}

		$template->assign_var('U_ACTION', $this->u_action);
	}
}

function get_pages_data()
{
	global $db, $template, $phpbb_admin_path, $phpEx;
	global $current_pages;

	$sql = 'SELECT *
		FROM ' . K_PAGES_TABLE ;

	$result = $db->sql_query($sql);

	while ($row = $db->sql_fetchrow($result))
	{
		$current_pages = $row['page_name'];

		$template->assign_block_vars('phpbbpages', array(
			'S_PAGE_ID'     => $row['page_id'],
			'S_PAGE_NAME'   => $row['page_name'],
			'U_EDIT'        => append_sid("{$phpbb_admin_path}index.$phpEx", "i=k_pages&amp;mode=edit&amp;page_id=" . $row['page_id']),
			'U_DELETE'      => append_sid("{$phpbb_admin_path}index.$phpEx", "i=k_pages&amp;mode=delete&amp;page_id=" . $row['page_id']),
			'U_LAND'        => append_sid("{$phpbb_admin_path}index.$phpEx", "i=k_pages&amp;mode=land&amp;page_id=" . $row['page_id']),
		));
	}
	$db->sql_freeresult($result);

	$template->assign_var('S_OPTION', 'manage');
}

/**
* get all pages
* don't include code files, only include pages...
*/
function get_all_available_files()
{
	global $phpbb_root_path, $phpEx, $template, $dirslist, $db, $user;

	$page_name = '';
	$i = 0;

	// --------------- //
	// For mod authors //
	// --------------- //

	/*	Allowing specific mod pages to display block
		--------------------------------------------

		If your mod uses a dedicated mod folder and you want to allow blocks to be displayed on specific pages, simply add the
		mod's folder name to the $mods_folder_array below... (we don't know which mods will be installed therefore we can't automate this).

		To prevent the dropdown box from displaying illegal pages add these to the $illegal_files_array below (see line: ~357 )
	*/


	$mods_folder_array = array("a_mod_folder");

	$sql = 'SELECT page_name
		FROM ' . K_PAGES_TABLE . '
		ORDER BY page_name ASC';
	$result = $db->sql_query($sql);

	while ($row = $db->sql_fetchrow($result))
	{
		$page_name .= $row['page_name'] . '.php, ';
	}
	$db->sql_freeresult($result);

	$arr = explode(', ', $page_name);

	$dirs = dir($phpbb_root_path);

	$dirslist = ' ';

	while ($file = $dirs->read())
	{
		if ($file != '.' && $file != '..' && stripos($file, ".php") && !stripos($file, ".bak") && !in_array($file, $arr, true))
		{
			// array of filename we don't process //
			$illegal_files = array(".htaccess", "common.$phpEx", "report.$phpEx", "feed.$phpEx", "cron.$phpEx", "config.$phpEx", "csv.$phpEx", "style.$phpEx", "sgp_ajax.$phpEx", "sgpical.$phpEx", "rss.$phpEx");

			if (!in_array($file, $illegal_files))
			{
				$dirslist .= "$file ";
			}
		}

		// Search mod folders using the $mods_folder_array (we only look one folder deep ATM) //
		if (in_array($file, $mods_folder_array, true))
		{
			search_sub_directory($mods_folder_array, $arr);
		}

	}

	closedir($dirs->handle);

	$dirslist = explode(" ", $dirslist);
	sort($dirslist);

	$phpbb_files = '';
	$files_found = 0;

	// As we use onchange event we need an empty line first //
	$phpbb_files .= '<option value="' . ' ' . '">' . ' ' . '</option>';

	foreach ($dirslist as $file)
	{
		if ($file != '')
		{
			$files_found++;
			$phpbb_files .= '<option value="' . $file  . '"' . (($files_found == 0) ? ' selected="selected"' : '') . '>' . $file . '</option>';
		}
	}

	$template->assign_vars(array(
		'S_PHPBB_FILES' => $phpbb_files,
		'S_FILES_FOUND' => $files_found,
	));
}

/**
* simply return the page/file name for clarity
**/
function get_page_filename($page_id)
{
	global $db, $template;

	$sql = 'SELECT *
		FROM ' . K_PAGES_TABLE . '
		WHERE page_id = ' . $db->sql_escape($page_id);
	$result = $db->sql_query($sql);

	if ($result = $db->sql_query($sql))
	{
		$row = $db->sql_fetchrow($result);
	}

	$template->assign_vars(array(
		'PAGE_ID'   => $row['page_id'],
		'PAGE_NAME' => $row['page_name'],
	));

	$db->sql_freeresult($result);

	return($row['page_name']);
}


/**
* search mod folders for valid files
* the admin must add the mod folder to the $mod array above
**/
function search_sub_directory($mod_folders, $arr)
{
	global $phpbb_root_path, $phpEx, $dirslist;

	foreach($mod_folders as $folder)
	{
		$dirs = dir($phpbb_root_path . $folder);

		while ($file = $dirs->read())
		{
			if ($file != '.' && $file != '..' && stripos($file, ".php") && !stripos($file, ".bak") && !in_array($folder .'/'. $file, $arr, true))
			{
				// --------------- //
				// For mod authors //
				// --------------- //

				// Not all files in a mod folder should be included in the dropdown list... //
				// To restrict specific files, add them to the $illegal_files array below... //

				$illegal_files_array = array($folder . '/' . 'dummy.$phpEx');

				$temp = $folder . '/' . $file;

				if (!in_array($temp, $illegal_files_array))
				{
					$dirslist .= $temp. " ";
				}
			}
		}
	}
}

?>