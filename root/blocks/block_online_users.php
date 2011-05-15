<?php
/**
*
* @package Stargate Portal
* @author  Michael O'Toole - aka Michaelo
* @begin   Saturday, April 1st, 2005
* @copyright (c) 2005-20010 phpbbireland
* @home    http://www.phpbbireland.com
* @source  Rework of code from functions.php @copyright (c) 2005 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @note: Do not remove this copyright. Just append yours if you have modified it,
*        this is part of the Stargate Portal copyright agreement...
*
* @version $Id$
*
* Updated: 06 March 2010
*
*/

/**
* @ignore
*/

if (!defined('IN_PHPBB'))
{
	exit;
}


$queries = $cached_queries = 0;

/* already processed by phpBB common code section */

$template->assign_vars(array(
	'ONLINE_USERS_DEBUG'	=> sprintf($user->lang['PORTAL_DEBUG_QUERIES'], ($queries) ? $queries : '0', ($cached_queries) ? $cached_queries : '0', ($total_queries) ? $total_queries : '0'),
));

?>