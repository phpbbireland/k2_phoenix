<?php
/**
*
* @package acp Kiss Portal Engine
* @version $Id: acp_k_referrals.php 312 2009-01-02 02:51:12Z Michealo $
* @copyright (c) 2008 Martin Larsson - aka NeXur
* @maintained by phpbbireland.com - Mike & prosk8er
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

class acp_k_referrals
{
	var $u_action;

	function main($id, $mode)
	{
		global $db, $user, $auth, $template, $cache;
		global $config, $SID, $phpbb_root_path, $phpbb_admin_path, $phpEx;

		include($phpbb_root_path . 'includes/sgp_functions.'.$phpEx);

		$message ='';

		$user->add_lang('acp/k_referrals');
		$this->tpl_name = 'acp_k_referrals';
		$this->page_title = 'ACP_K_REFERRALS';

		$form_key = 'acp_k_referrals';
		add_form_key($form_key);

		// Set up general vars
		$action = request_var('action', '');
		$action = (isset($_POST['edit'])) ? 'edit' : $action;
		$action = (isset($_POST['add'])) ? 'add' : $action;
		$action = (isset($_POST['save'])) ? 'save' : $action;

		$sql = 'SELECT config_name, config_value
			FROM ' . K_BLOCKS_CONFIG_VAR_TABLE . '';

		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$k_config[$row['config_name']] = $row['config_value'];
		}

		// ======================================================
		//		[ MAIN PROCESS ]
		// ======================================================

		//
		// Get POST/GET variables...
		//

		$start = intval( (isset($_POST['start'])) ? request_var('start', 0) : ( (isset($_GET['start'])) ? request_var('start', 0) : 0 ) );
		$sort_method = ( (isset($_POST['sort'])) ? request_var('sort', '') : ( (isset($_GET['sort'])) ? request_var('sort', '') : 'hits' ) );
		$sort_order  = ( (isset($_POST['order'])) ? request_var('order', '') : ( (isset($_GET['order'])) ? request_var('order', '') : 'DESC' ) );
		$filter_flag = ( (isset($_POST['filter'])) ? request_var('filter', '') : ( (isset($_GET['filter'])) ? request_var('filter', '') : 'disabled' ) );

		$enable	= request_var('enable', 0);
		$delete	= request_var('delete', 0);
		$delete_all  = request_var('deleteall', 0);


		//$id_list	= ( ( isset($_POST['id_list']) ) ? $_POST['id_list'] : ( (isset($_GET['id_list'])) ? $_GET['id_list'] : array()));
		$id_list = request_var('id_list', array(0));

		//Rows to show from blocksetting * 2
		$rows_per_page = $k_config['k_referrals_to_display'];
		if (!is_numeric($rows_per_page))
		{
			$rows_per_page = 10;
		}
		$rows_per_page *= 2;

		// If the form was submitted, display the update successful message...
		//
		switch ($action)
		{
			case 'update_k_referrals_to_display':

				$config_k_referrals_to_display = request_var('k_referrals_to_display', 0);

				if ($action == 'update_k_referrals_to_display')
				{
					$db->sql_query('UPDATE ' . K_BLOCKS_CONFIG_VAR_TABLE . ' SET config_value = ' . $config_k_referrals_to_display . ' WHERE config_name = "k_referrals_to_display"');
					$message = $user->lang['CONFIG_UPDATED'];
				}
				$db->sql_query($sql);
				trigger_error($message . adm_back_link($this->u_action));
			break;

			default:
			break;
		}

		//
		// Check which mode we should operate in...
		//
		if ($enable)
		{
			for ($i = 0; $i < count($id_list); $i++)
			{
				$sql = 'UPDATE ' . K_REFERRALS_TABLE .
					" SET enabled = " . (($filter_flag == 'enabled') ? 0 : 1 ) .
					" WHERE id = " . (int)$id_list[$i];

				if (!$result = $db->sql_query($sql))
				{
					trigger_error(GENERAL_ERROR, $user->lang['NO_UPDATE_HTTP_REFERRALS'] . " (id=" . $id_list[$i] . ")", '', __LINE__, __FILE__, $sql);
				}
			}
		}
		else if ($delete)
		{
			for ($i = 0; $i < count($id_list); $i++)
			{
				$sql = 'DELETE FROM '.K_REFERRALS_TABLE." WHERE id = ".$id_list[$i];
				if (!$result = $db->sql_query($sql))
				{
					trigger_error($user->lang['ERROR_PORTAL_HTTP_DELETE'] , '', __LINE__, __FILE__, $sql);
				}
			}
		}
		else if ($delete_all)
		{
			$sql = 'DELETE FROM '.K_REFERRALS_TABLE. '
				WHERE enabled = '.( ($filter_flag == 'enabled') ? 1 : 0 );

			if (!$result = $db->sql_query($sql))
			{
				trigger_error($user->lang['ERROR_PORTAL_HTTP_DELETE'] , '', __LINE__, __FILE__, $sql);
			}
		}

		//
		// Setup report variables...
		//
		$a_sort_method = array(
			'host'	 => $user->lang['HOST'],
			'hits'	 => $user->lang['HITS'],
			'firstvisit' => $user->lang['FIRST_VISIT'],
			'lastvisit'  => $user->lang['LAST_VISIT'],
		);
		$s_sort_method = '';

		foreach ($a_sort_method as $s_value => $s_text)
		{
			$selected = ($s_value == $sort_method) ? ' selected' : '';
			$s_sort_method .= '<option value="'.$s_value.'"'.$selected.'>'.$s_text.'</option>';
		}

		//
		// Get total records count, for pagination...
		//
		$total_rows = array();
		$sql = 'SELECT COUNT(*) AS total FROM '.K_REFERRALS_TABLE.' WHERE enabled = 0';

		if (!$result = $db->sql_query($sql))
		{
			trigger_error($user->lang['ERROR_PORTAL_HTTP_QUERY'] , '', __LINE__, __FILE__, $sql);
		}

		$row = $db->sql_fetchrow($result);
		$total_rows[0] = $row['total'];
		$sql = 'SELECT COUNT(*) AS total FROM '.K_REFERRALS_TABLE.' WHERE enabled = 1';

		if (!$result = $db->sql_query($sql))
		{
			trigger_error($user->lang['ERROR_PORTAL_HTTP_QUERY'] , '', __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);
		$total_rows[1] = $row['total'];
		$total_now = ($filter_flag == 'enabled') ? 1 : 0;

		//
		// Default process is report...
		//
		switch ($sort_method)
		{
			case 'host':
			$order_by = 'host '.$sort_order;
			break;
			case 'firstvisit':
			$order_by = 'firstvisit '.$sort_order;
			break;
			case 'lastvisit':
			$order_by = 'lastvisit '.$sort_order;
			break;
			default:
			case 'hits':
			$order_by = 'hits '.$sort_order.', lastvisit DESC';
			break;
		}
		$sql = 'SELECT * FROM '.K_REFERRALS_TABLE. '
			WHERE enabled = '.( ($filter_flag == 'enabled') ? 1 : 0 ). '
			ORDER BY '.$order_by.' LIMIT '.$start.', '.$rows_per_page;

		if (!$result = $db->sql_query($sql))
		{
			trigger_error($user->lang['ERROR_PORTAL_HTTP_QUERY'] , '', __LINE__, __FILE__, $sql);
		}
		$rowset = $db->sql_fetchrowset($result);
		$rowset_count = count($rowset);

		//
		// Set template variables and send to browser...
		//
		$template->set_filenames(array(
			'body' => 'adm/style/acp_k_referrals.html')
		);

		if ($rowset_count > 0)
		{
			for ($i = 0; $i < $rowset_count; $i++)
			{
				$template->assign_block_vars('datarow', array(
					'ID'		=> $rowset[$i]['id'],
					'HOST'	    => $rowset[$i]['host'],
					'HITS'	    => $rowset[$i]['hits'],
					'FIRST_VISIT'   => create_date('Y-m-d H:i:s', $rowset[$i]['firstvisit'], $config['board_timezone']),
					'LAST_VISIT'    => create_date('Y-m-d H:i:s', $rowset[$i]['lastvisit'], $config['board_timezone'])
				));
			}
			$template->assign_block_vars('ok_referrals_sw', array());
		}
		else
		{
			$template->assign_block_vars('no_referrals_sw', array());
		}
		$template->assign_vars(array(
			'ASC_SELECTED'		=> ($sort_order != 'DESC') ? 'selected="selected"' : '',
			'DESC_SELECTED'		=> ($sort_order == 'DESC') ? 'selected="selected"' : '',
			'DISABLED_SELECTED'	=> ($filter_flag != 'enabled') ? 'checked="checked"' : '',
			'ENABLED_SELECTED'	=> ($filter_flag == 'enabled') ? 'checked="checked"' : '',

			'L_TITLE'		=> $user->lang['REFERRALS_MANAGEMENT'],
			'L_EXPLAIN'		=> $user->lang['REFERRALS_MANAGEMENT_EXPLAIN'].$user->lang['ENABLED'].'('.$total_rows[1].'), '.$user->lang['DISABLED'].'('.$total_rows[0].')',
			'U_FORM_ACTION'		=> append_sid(@basename(__FILE__)),
			'L_SELECT_FILTER'	=> $user->lang['SELECT_FILTER'],
			'L_ENABLED'		=> $user->lang['ENABLED'],
			'L_DISABLED'		=> $user->lang['DISABLED'],
			'L_GO'			=> $user->lang['GO'],
			'L_SELECT_SORT_METHOD'  => $user->lang['SELECT_SORT_METHOD'],
			'L_SORT'		=> $user->lang['SORT'],
			'L_ORDER'		=> $user->lang['ORDER'],
			'L_SORT_DESCENDING'     => $user->lang['SORT_DESCENDING'],
			'L_SORT_ASCENDING'	=> $user->lang['SORT_ASCENDING'],
			'L_REFERRALS_HOST'	=> $user->lang['HOST'],
			'L_REFERRALS_HITS'	=> $user->lang['HITS'],
			'L_FIRST_VISIT'		=> $user->lang['FIRST_VISIT'],
			'L_LAST_VISIT'		=> $user->lang['LAST_VISIT'],
			'L_NO_REFERRALS'	=> ($filter_flag == 'enabled') ? $user->lang['NO_ENABLED_REFERRALS'] : $user->lang['NO_DISABLED_REFERRALS'],
			'L_MARK'		=> $user->lang['MARK'],
			'L_MARK_ALL'		=> $user->lang['MARK_ALL'],
			'L_UNMARK_ALL'	    	=> $user->lang['UNMARK_ALL'],
			'L_ENABLE_MARKED'	=> ($filter_flag == 'enabled') ? $user->lang['DISABLE_MARKED'] : $user->lang['ENABLE_MARKED'],
			'L_DELETE_MARKED'	=> $user->lang['DELETE_MARKED'],
			'L_DELETE_ALL'	    	=> $user->lang['DELETE_ALL'],
			'L_NO_ITEMS_MARKED'     => $user->lang['NO_ITEMS_MARKED'],
			'L_PLEASE_CONFIRM'	=> $user->lang['PLEASE_CONFIRM'],

			'PAGINATION'		=> generate_pagination(append_sid($phpbb_admin_path."index.php?filter=$filter_flag&amp;sort=$sort_method&amp;order=$sort_order&amp;i=k_referrals"), $total_rows[$total_now], $rows_per_page, $start),
			'PAGE_NUMBER'		=> sprintf($user->lang['PAGE_OF'], ( floor( $start / $rows_per_page ) + 1 ), ceil( $total_rows[$total_now] / $rows_per_page )),
			'REFERRALS_COUNT'	=> $k_config['k_referrals_to_display'],
			'S_SORT_METHOD'		=> $s_sort_method,
			'S_ACTION'		=> $this->u_action . '&amp;action=k_referrals_to_display',
		));
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
		return (!empty($translate)) ? strtr(@gmdate($format, $gmepoch + (3600 * $tz)), $translate) : @gmdate($format, $gmepoch + (3600 * $tz));
	}
}

?>