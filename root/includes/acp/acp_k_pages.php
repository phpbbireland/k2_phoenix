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
		global $config, $SID, $phpbb_root_path, $phpbb_admin_path, $phpEx;

		include($phpbb_root_path . 'includes/sgp_functions.' . $phpEx);

		$user->add_lang('acp/k_pages');
		$this->tpl_name = 'acp_k_pages';
		$this->page_filename = 'ACP_PAGES';

		$form_key = 'acp_k_pages';
		add_form_key($form_key);

		//$s_hidden_fields = '';

		$mode = request_var('mode', '');
		$page_id = request_var('page_id', 0);
		$action	= request_var('config', '');
		$tag_id = request_var('tag_id', '');

		$submit = (isset($_POST['submit'])) ? true : false;

		if($tag_id != '')
		{
			$mode = 'add';
		}

		switch($action)
		{
			case 'config':
				$template->assign_var('MESSAGE', $user->lang['SWITCHING']);

				meta_refresh (1, "{$phpbb_root_path}adm/index.$phpEx$SID&amp;i=k_vars&amp;mode=config&amp;switch=k_pages");
			break;

			default:
			break;
		}


		if ($submit && !check_form_key($form_key))
		{
			$submit = false;
			$mode = '';
			trigger_error($user->lang['FORM_INVALID'] . basename(dirname(__FILE__)) . '/' . basename(__FILE__) . ', line ' . __LINE__);
		}


		$template->assign_vars(array(
			'U_BACK'	=> "{$phpbb_root_path}adm/index.$phpEx$SID&amp;i=k_pages&mode=manage",
			'U_ADD'		=> "{$phpbb_root_path}adm/index.$phpEx$SID&amp;i=k_pages&amp;mode=add",
			'U_EDIT'	=> "{$phpbb_root_path}adm/index.$phpEx$SID&amp;i=k_pages&amp;mode=edit" . '&amp;page_id=' . $page_id,
			'U_DELETE'	=> "{$phpbb_root_path}adm/index.$phpEx$SID&amp;i=k_pages&amp;mode=delete" . '&amp;page_id=' . $page_id,
			'U_MANAGE'	=> "{$phpbb_root_path}adm/index.$phpEx$SID&amp;i=k_pages&amp;mode=manage",
			'S_OPT'		=> 'S_MANAGE',
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
						trigger_error($user->lang['ERROR_PORTAL_PAGES'] . basename(dirname(__FILE__)) . '/' . basename(__FILE__) . ', line ' . __LINE__);
					}

					$cache->destroy('sql', K_PAGES_TABLE);

					$template->assign_vars(array(
						'S_OPTION'	=> 'processing',
						'MESSAGE'	=> $user->lang['REMOVING_PAGES'] . $page_name,
					));

					meta_refresh(1, "{$phpbb_root_path}adm/index.$phpEx$SID&amp;i=k_pages&amp;mode=manage");
					break;
				}
				else
				{
					confirm_box(false, sprintf("%s (%s)", $user->lang['CONFIRM_DELETE'], $page_name), build_hidden_fields(array(
						'id'		=> $page_id,
						'mode'		=> $mode,
						'action'	=> 'delete'))
					);
				}

				$template->assign_var('MESSAGE', $user->lang['ACTION_CANCELLED']);

				meta_refresh(1, "{$phpbb_root_path}adm/index.$phpEx$SID&amp;i=k_pages&amp;mode=manage");
			break;

			case 'add':
				if ($submit)
				{
					// drop extension
					$tag_id = str_replace('.php', '', $tag_id);

					// skip the spacer //
					if($tag_id == '..')
					{
						$template->assign_vars(array(
							'S_OPTION'	=> 'processing', // not lang var
							'MESSAGE'	=> sprintf($user->lang['ERROR_PAGE'], $tag_id),
						));
						meta_refresh(3, "{$phpbb_root_path}adm/index.$phpEx$SID&amp;i=k_pages&amp;mode=manage");
						return;
					}

					$sql_array = array(
						'page_name'	=> $tag_id,
                    );

		           $db->sql_query('INSERT INTO ' . K_PAGES_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_array));

					meta_refresh(1, "{$phpbb_root_path}adm/index.$phpEx$SID&amp;i=k_pages&amp;mode=manage");

					$template->assign_vars(array(
						'S_OPTION'	=> 'processing', // not lang var
						'MESSAGE'	=> $user->lang['ADDING_PAGES'],
					));

					$cache->destroy('sql', K_PAGES_TABLE);
					break;
				}
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
	global $db, $template;//, $s_hidden_fields;

	$sql = 'SELECT *
		FROM ' . K_PAGES_TABLE ;

	$result = $db->sql_query($sql);

	while ($row = $db->sql_fetchrow($result))
	{
		$template->assign_block_vars('phpbbpages', array(
			'S_PAGE_ID'		=> $row['page_id'],
			'S_PAGE_NAME'	=> $row['page_name'],
		));
	}
	$db->sql_freeresult($result);

	$template->assign_var('S_OPTION', 'manage');
}

/**
* get all pages not used so far...
* don't include code files, only include pages...
*/
function get_all_available_files()
{
	global $phpbb_root_path, $phpEx, $template, $dirslist, $db, $user;
	$page_name = '';
	$i = 0;

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

	$dirslist = ".. ";

	while ($file = $dirs->read())
	{
		if (stripos($file, ".php") && !stripos($file, ".bak") && !in_array($file, $arr, true))
		{
			// array of filename we don't process... store in databse and add code to facilitate add/edit/delete later //
			$illegal_files = array("common.php", "report.php", "feed.php", "cron.php", "config.php", "csv.php", "style.php", "sgp_refresh.php", "sgp_ajax.php", "sgpical.php", "rss.php");

			if(!in_array($file, $illegal_files))
			{
				$dirslist .= "$file ";
			}
		}

	}
	closedir($dirs->handle);

	$dirslist = explode(" ", $dirslist);
	sort($dirslist);
	for ($i = 0; $i < sizeof($dirslist); $i++)
	{
		if ($dirslist[$i] != '')
		{
			$template->assign_block_vars('phpbb_pages', array(
				'S_PHPBB_FILES'	=> $dirslist[$i]
			));
		}
	}
}

/**
* simply return the page/file name for clarity
**/
function get_page_filename($page_id)
{
	global $db, $template;//, $s_hidden_fields;

	$sql = 'SELECT *
		FROM ' . K_PAGES_TABLE . '
		WHERE page_id = ' . $db->sql_escape($page_id);
	$result = $db->sql_query($sql);

	if ($result = $db->sql_query($sql))
	{
		$row = $db->sql_fetchrow($result);
	}

	$template->assign_vars(array(
		'PAGE_ID'	=> $row['page_id'],
		'PAGE_NAME'	=> $row['page_name'],
	));

	$db->sql_freeresult($result);

	return($row['page_name']);
}
?>