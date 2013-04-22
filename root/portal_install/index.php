<?php
/**
*
* @author michaelo phpbbireland@gmail.com - http://www.phpbbireland.com
*
* @package sgp
* @version 1.0.19
* @copyright (c) 2005-2011 Michael O'Toole (phpbbireland.com)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
define('UMIL_AUTO', true);
define('IN_PHPBB', true);

// correct root for poral as we install using root/portal/index.php //

$phpbb_root_path = './../';

$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);

$user->session_begin();
$auth->acl($user->data);
$user->setup();

if (!file_exists($phpbb_root_path . 'umil/umil_auto.' . $phpEx))
{
	trigger_error('Please download the latest UMIL (Unified MOD Install Library) from: <a href="http://www.phpbb.com/mods/umil/">phpBB.com/mods/umil</a>', E_USER_ERROR);
}

// The name of the mod to be displayed during installation.
$mod_name = 'KISS_PORTAL_ENGINE';

$version_config_name = 'portal_version';
$language_file = 'portal_install_umil';
$logo_img = 'portal_install/portal_install.png';

include($phpbb_root_path . 'portal_install/sql_data.' . $phpEx);

$versions = array(

	// Version 1.0.1
	'1.0.0a' => array(
	),
	// Version 1.0.2
	'1.0.0b' => array(
	),
	// Version 1.0.3
	'1.0.0c' => array(
	),
	// Version 1.0.4
	'1.0.0d' => array(
	),
	// Version 1.0.5
	'1.0.0e' => array(
	),
	// Version 1.0.6
	'1.0.0f' => array(
	),
	// Version 1.0.7
	'1.0.0g' => array(
	),
	// Version 1.0.8
	'1.0.0h' => array(
	),
	// Version 1.0.9
	'1.0.0i' => array(
	),
	// Version 1.0.10
	'1.0.0j' => array(
	),
	// Version 1.0.11
	'1.0.0k' => array(
	),
	// Version 1.0.12
	'1.0.0l' => array(
	),
	// Version 1.0.13
	'1.0.0m' => array(
	),
	// Version 1.0.14
	'1.0.0n' => array(
	),
	// Version 1.0.15
	'1.0.15' => array(
	),
	// Version 1.0.16
	'1.0.16' => array(
	),
	// Version 1.0.17
	'1.0.17'	=> array(
		'permission_add' => array(
			array('a_k_portal', 1),
			array('a_k_tools', 1),
			array('u_k_tools', 1),
		),

		'permission_set' => array(
			array('ROLE_ADMIN_FULL', 'a_k_portal'),
			array('ROLE_ADMIN_FULL', 'a_k_tools'),
		),

		'config_add' => array(
			array('portal_enabled', 1),
			array('portal_build', '311-019'),
			array('blocks_enabled', 1),
			array('blocks_width', '190'),
			array('force_default_if_style_missing', 1),
		),

		'users_add' => array(
			array('user_left_blocks', '2'),
			array('user_center_blocks', '2'),
			array('user_right_blocks', '2'),
		),

		'table_add' => array(
			array('phpbb_k_blocks', array(
					'COLUMNS' => array(
						'id'				=> array('UINT', NULL, 'auto_increment'),
						'ndx'				=> array('UINT', '0'),
						'title'				=> array('VCHAR:50', ''),
						'position'			=> array('CHAR:1', 'L'),
						'type'				=> array('CHAR:1', 'H'),
						'active'			=> array('BOOL', '1'),
						'html_file_name'	=> array('VCHAR', ''),
						'var_file_name'		=> array('VCHAR', 'none.gif'),
						'img_file_name'		=> array('VCHAR', 'none.gif'),
						'view_all'			=> array('BOOL', '1'),
						'view_groups'		=> array('VCHAR:100', ''),
						'view_pages'		=> array('VCHAR:100', ''),
						'groups'			=> array('UINT', '0'),
						'scroll'			=> array('BOOL', '0'),
						'block_height'		=> array('USINT', '0'),
						'has_vars'			=> array('BOOL', '0'),
						'is_static'			=> array('BOOL', '0'),
						'minimod_based'		=> array('BOOL', '0'),
						'mod_block_id'		=> array('UINT', '0'),
						'block_cache_time'	=> array('UINT', '600'),
					),
					'PRIMARY_KEY'	=> 'id',
				),
			),

			array('phpbb_k_menus', array(
					'COLUMNS'	=> array(
						'm_id'			=> array('UINT', NULL, 'auto_increment'),
						'ndx'			=> array('UINT', '0'),
						'menu_type'		=> array('USINT', '0'),
						'name'			=> array('VCHAR:50', ''),
						'link_to'		=> array('VCHAR', ''),
						'extern'		=> array('BOOL', '0'),
						'menu_icon'		=> array('VCHAR:30', 'none.gif'),
						'append_sid'	=> array('BOOL', '1'),
						'append_uid'	=> array('BOOL', '0'),
						'view_all'		=> array('BOOL', '1'),
						'view_groups'	=> array('VCHAR:100', ''),
						'soft_hr'		=> array('BOOL', '0'),
						'sub_heading'	=> array('BOOL', '0'),
					),
					'PRIMARY_KEY'	=> 'm_id',
				),
			),

			array('phpbb_k_blocks_config', array(
					'COLUMNS'	=> array(
						'id'					=> array('USINT', NULL, 'auto_increment'),
						'use_external_files'	=> array('BOOL', '0'),
						'update_files'			=> array('BOOL', '0'),
						'layout_default'		=> array('BOOL', '2'),
						'portal_config'			=> array('VCHAR:10', 'Site'),
					),
				'PRIMARY_KEY'	=> 'id',
				),
			),

			array('phpbb_k_blocks_config_vars', array(
					'COLUMNS'	=> array(
						'config_name'		=> array('VCHAR', ''),
						'config_value'		=> array('VCHAR', ''),
						'is_dynamic'		=> array('BOOL', '0'),
					),
					'PRIMARY_KEY'	=> 'config_name',
					'KEYS'			=> array('is_dynamic'	=> array('INDEX', 'is_dynamic'),
					),
				),
			),

			array('phpbb_k_resources', array(
				'COLUMNS'	=> array(
					'id'	=> array('UINT', NULL, 'auto_increment'),
					'word'	=> array('VCHAR:30', ''),
					'type'	=> array('CHAR:1', 'V'),
					),
					'PRIMARY_KEY'	=> 'id',
				),
			),

			array('phpbb_k_pages', array(
				'COLUMNS'	=> array(
					'page_id'	=> array('UINT', NULL, 'auto_increment'),
					'page_name'	=> array('VCHAR_UNI:100', ''),
					),
					'PRIMARY_KEY'	=> 'page_id',
				),
			),
		),

		'module_add' => array(
			array('acp', '0', 'ACP_CAT_PORTAL'),
			array('acp', 'ACP_CAT_PORTAL', 'ACP_K_CONFIG'),
			array('acp', 'ACP_CAT_PORTAL', 'ACP_K_BLOCKS'),
			array('acp', 'ACP_CAT_PORTAL', 'ACP_K_MENUS'),
			array('acp', 'ACP_CAT_PORTAL', 'ACP_K_VARIABLES'),

			array('acp', 'ACP_K_CONFIG',	array(
					'module_basename' => 'k_config',
				),
			),
			array('acp', 'ACP_K_BLOCKS',	array(
					'module_basename' => 'k_blocks',
				),
			),
			array('acp', 'ACP_K_MENUS',	array(
					'module_basename' => 'k_menus',
				),
			),
			array('acp', 'ACP_K_VARIABLES',	array(
					'module_basename' => 'k_vars',
				),
			),
			array('acp', 'ACP_K_VARIABLES',	array(
					'module_basename' => 'k_resources',
				),
			),
			array('acp', 'ACP_K_VARIABLES',	array(
					'module_basename' => 'k_pages',
				),
			),


			array('acp', 'ACP_CAT_PORTAL', 'ACP_K_TOOLS'),

			array('ucp', '0', 'UCP_K_BLOCKS'),
			array('ucp', 'UCP_K_BLOCKS', array(
					'module_basename'	=> 'k_blocks',
					'modes'				=> array('info', 'arrange', 'edit', 'delete', 'width'),
					'module_auth'		=> 'u_k_tools',
				),
			),

		),

		'table_column_add' => array(
			array('phpbb_icons', 'icons_group', array('BOOL', 0)),
			array('phpbb_smilies', 'smiley_group', array('BOOL', 0)),
			array('phpbb_users', 'user_left_blocks', array('VCHAR', '')),
			array('phpbb_users', 'user_center_blocks', array('VCHAR', '')),
			array('phpbb_users', 'user_right_blocks', array('VCHAR', '')),
		),

		'table_insert' => array(
			array($k_blocks_table, $k_blocks_array),
			array($k_blocks_config_table, $k_blocks_config_array),
			array($k_blocks_config_vars_table, $k_blocks_config_vars_array),
			array($k_menus_table, $k_menus_array),
			array($k_pages_table, $k_pages_array),
			array($k_resources_table, $k_resources_array),
		),

		// purge the cache
		'cache_purge' => array('', 'imageset', 'template', 'theme'),
	),
	// Version 1.0.18
	'1.0.18' => array(
		'config_update' => array(
			array('portal_build', '311-018'),
		),
	),
	// Version 1.0.19
	'1.0.19' => array(
		'config_update' => array(
			array('portal_build', '311-019'),
		),
	),
	// Version 1.0.20
	'1.0.20' => array(
		'config_update' => array(
			array('portal_build', '311-020'),
		),
	),

);//versions


include($phpbb_root_path . 'umil/umil_auto.' . $phpEx);

?>