<?php
/**
*
* @author Martin Larsson (NeXur) http://phpbbireland.com
*
* @package acp (Stargate Portal)
* @version $Id: acp_k_referrals.php 305 2009-01-01 16:03:23Z Michealo $
* @copyright (c) 2008 Martin Larsson - aka NeXur
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

class acp_k_referrals_info
{
	function module()
	{
		return array(
			'filename' => 'acp_k_referrals',
			'title'    => 'ACP_K_REFERRALS',
			'version'  => '1.0.1',
			'modes'    => array(
				'select' => array('title' => 'ACP_K_REFERRALS', 'auth' => 'acl_a_k_tools', 'cat' => array('ACP_K_TOOLS')),
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