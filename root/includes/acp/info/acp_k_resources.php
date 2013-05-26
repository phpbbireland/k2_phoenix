<?php
/**
*
* @author Michael O'Toole (michaelo) http://phpbbireland.com
*
* @package acp (Stargate Portal)
* @version $Id: acp_k_resources.php 305 2009-01-01 16:03:23Z Michealo $
* @copyright (c) 2008 Michael O'Toole - aka michaelo
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

class acp_k_resources_info
{
	function module()
	{
		return array(
			'filename' => 'acp_k_resources',
			'title'    => 'ACP_K_RESOURCES',
			'version'  => '1.0.20',
			'modes'    => array(
				'select' => array('title' => 'ACP_K_RESOURCES', 'auth' => 'acl_a_k_tools', 'cat' => array('ACP_K_TOOLS')),
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