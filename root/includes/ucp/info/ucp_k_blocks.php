<?php
/**
*
* @package ucp
* @version $Id$
* @copyright (c) 2005 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @package module_install
*/
class ucp_k_blocks_info
{
	function module()
	{
		return array(
			'filename'  => 'ucp_k_blocks',
			'title'     => 'UCP_K_BLOCKS',
			'version'   => '1.0.20',
			'modes'     => array(
				'info'     => array('title' => 'UCP_K_BLOCKS_INFO', 'auth' => '', 'cat' => array('UCP_K_BLOCKS')),
				'arrange'  => array('title' => 'UCP_K_BLOCKS_ARRANGE', 'auth' => '', 'cat' => array('UCP_K_BLOCKS')),
				'edit'     => array('title' => 'UCP_K_BLOCKS_EDIT', 'auth' => '', 'cat' => array('UCP_K_BLOCKS')),
				'delete'   => array('title' => 'UCP_K_BLOCKS_DELETE', 'auth' => '', 'cat' => array('UCP_K_BLOCKS')),
				'width'    => array('title' => 'UCP_K_BLOCKS_WIDTH', 'auth' => '', 'cat' => array('UCP_K_BLOCKS')),
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