<?php
/**
*	Original code and idea from the Top Referers block in the SiteStats module
*	copyright: Marc Ferran (c) 2003-2004
*	contact: http://www.phpmix.com
*
*   Ported and rewritten for PhpBB3 and Stargate Portal by: NeXur
*
* @package Kiss Portal
* @author  Martin Larsson - aka NeXur
* @begin   Thursday, 5th September, 2008
* @copyright (c) 2008 Martin Larsson - aka NeXur
* @home    http://www.phpbbireland.com
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @note:   Do not remove this copyright. Just append yours if you have modified it,
*          this is part of the Stargate Portal copyright agreement...
*
* @version $Id: block_top_referrals.php 307 2010-11-07 16:05:35Z michealo $
*
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

global $k_config, $k_blocks;
$queries = $cached_queries = 0;
$total_hits = 0;

foreach ($k_blocks as $blk)
{
	if ($blk['html_file_name'] == 'block_top_referrals.html')
	{
		$block_cache_time = $blk['block_cache_time'];
	}
}
$block_cache_time = (isset($block_cache_time) ? $block_cache_time : $k_config['k_block_cache_time_default']);

// portal config values //
$num_refviews = $k_config['k_referrals_to_display'];

$http_referrals = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

if ($http_referrals)
{
	$http_host = $_SERVER['HTTP_HOST'];

	$int_check = strpos($http_referrals, $http_host);

	// check if an internal referrals?
	if (!$int_check)
	{
		$order   = array("http://www.", "https://www.");
		$replace = array("http://", "https://");
		$http_referrals = str_replace($order, $replace, $http_referrals);

		$http_url = parse_url($http_referrals);
		$http_host = $http_url['host'];

		// Do we have a host in the URL?
		if ($http_host)
		{
			$http_time = time();

			$sql = 'SELECT * FROM '.K_REFERRALS_TABLE."  WHERE host = '" . $db->sql_escape($http_host) . "'";
			$result = $db->sql_query($sql, $block_cache_time);

			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			if ($row)
			{
				$sql2 = 'UPDATE ' . K_REFERRALS_TABLE .
				' SET hits = ' . ($row['hits']+1) . ' , '.
				' lastvisit = ' . $http_time .
				" WHERE host = '" . $db->sql_escape($http_host) . "'";
				$db->sql_query($sql2);
			}
			else
			{
				$sql2 = 'INSERT INTO '.K_REFERRALS_TABLE.' (host, hits, firstvisit, lastvisit, enabled)' .
				" VALUES ('" . $db->sql_escape($http_host) . "' , 1 , " . $http_time . ' , ' . $http_time . ' , 1 )';
				$db->sql_query($sql2);
			}
		}
	}
}

// lets see how many referrals in total (include all)//
$sql = "SELECT hits, SUM(hits)
	FROM " . K_REFERRALS_TABLE . "
	WHERE enabled = 1";
$result = $db->sql_query($sql, $block_cache_time);
$row = $db->sql_fetchrow($result);
$total_hits = $row['SUM(hits)'];
$db->sql_freeresult($result);

$sql = 'SELECT *
		FROM '. K_REFERRALS_TABLE . '
		WHERE enabled = 1 ORDER BY hits DESC, lastvisit DESC';
$result = $db->sql_query_limit($sql, $num_refviews, 0, $block_cache_time);

if (!$result)
{
	trigger_error('ERROR_PORTAL_HTTP');
}

while ($row = $db->sql_fetchrow($result))
{
	$host_name = $row['host'];
	if (strlen($row['host']) > 17)
	{
		$host_name = sgp_checksize ($row['host'], 15);
	}

	$template->assign_block_vars('datarow', array(
		'S_HTTP_HOST'		=> $host_name,
		'S_HHTP_HOST_FULL'	=> $row['host'],
		'U_HTTP_HOST'		=> 'http://'.$row['host'],
		'S_HITS'		=> $row['hits']
	));
}
$db->sql_freeresult($result);

$template->assign_vars(array(
	'S_REF_LIMIT'	=> $num_refviews,
	'S_TOT_REF'		=> $total_hits,
	'TOP_REFERRALS_DEBUG'	=> sprintf($user->lang['PORTAL_DEBUG_QUERIES'], ($queries) ? $queries : '0', ($cached_queries) ? $cached_queries : '0', ($total_queries) ? $total_queries : '0'),
));

?>