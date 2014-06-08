<?php
/**
*
* @package acp (Kiss Portal Engine)
* @version $Id$
* @copyright (c) 2005-2013 phpbbireland
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

/**
* @package module_install
*/
class acp_k_vars_info
{
	function module()
	{
		return array(
			'filename' => 'acp_k_vars',
			'title'    => 'ACP_K_VARS',
			'version'  => '1.0.21',
			'modes'    => array(
				'config'  => array('title' => 'ACP_K_VARS_CONFIG','auth' => 'acl_a_k_portal', 'cat' => array('ACP_K_TOOLS')),
			),
		);
	}

	function install()
	{
	}

	function uninstall()
	{
	}
}

?>