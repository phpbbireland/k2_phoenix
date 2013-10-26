<?php
/**
*
* @author Michael O'Toole (michaelo) http://phpbbireland.com
*
* @package acp (Stargate Portal)
* @version $Id: acp_k_vars.php 305 2009-01-01 16:03:23Z Michealo $
* @copyright (c) 2005-2009 phpbbireland.com
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
			'version'  => '1.0.20',
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