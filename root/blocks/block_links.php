<?php
/**
*
* @package Stargate Portal
* @author  Michael O'Toole - aka Michaelo
* @begin   Saturday, 14th November, 2005
* @copyright (c) 2005-2008 phpbbireland
* @home    http://www.phpbbireland.com
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @note: Do not remove this copyright. Just append yours if you have modified it,
*        this is part of the Stargate Portal copyright agreement...
*
* @version $Id$
*
* Updated: 18th November 2008, 08:42
*
*/

/**
* @ignore
*/

	if (!defined('IN_PHPBB'))
	{
		exit;
	}

	$phpEx = substr(strrchr(__FILE__, '.'), 1);

	global $k_config, $phpbb_root_path, $k_blocks;
	$queries = $cached_queries = 0;

	foreach ($k_blocks as $blk)
	{
		if ($blk['html_file_name'] == 'block_links.html')
		{
			$block_cache_time = $blk['block_cache_time'];
		}
	}
	$block_cache_time = (isset($block_cache_time) ? $block_cache_time : $k_config['k_block_cache_time_default']);

	$show_all_links = true;

	// retrieve portal config variables
	$k_links_to_display = $k_config['k_links_to_display'];

	if($k_links_to_display < 6 and $k_links_to_display != 0)
	{
		$show_all_links = false;
	}

	// do we have a dedicated links upload forum? If not don't show the link upload image //
	if (isset($k_config['k_links_forum_id']) && $k_config['k_links_forum_id'] != 0)
	{
		$links_forum =  append_sid("{$phpbb_root_path}posting.$phpEx", 'mode=post&amp;f=' . (int)$k_config['k_links_forum_id']);
	}
	else
	{
		$links_forum = '';
	}

	$imglist = '';

	mt_srand((double)microtime()*1000002);
	$imgs = dir($phpbb_root_path . 'images/links');

	while ($file = $imgs->read())
	{
		if (strpos($file, ".gif") || strpos($file, ".jpg") || strpos($file, ".png"))
		{
			$imglist .= "$file ";
		}
	}
	closedir($imgs->handle);

	$imglist = explode(" ", $imglist);

	$a = sizeof($imglist);

	$a = $a - 1;	// correct for loop //

	if ($a < 1)		// don't process if no images //
	{
		return;
	}

	if ($k_links_to_display > $a)	// we do not have enough images! so display what we have //
	{
		$k_links_to_display = $a;
	}

	$random = mt_rand(0, $a);

	if ($random >= ($a - $k_links_to_display))
	{
		$random = ($a - $k_links_to_display);
	}

	// The number of link images to show (scrolled if scroll set in block)
	if ($show_all_links)
	{
		$linkscontent  = '<br /> <div style="text-align: center; width: 100%; margin: 0 auto; padding: 0;">';

		for ($i = 0; $i <= $a - 1; $i++)
		{
			$image = $imglist[$i];

			if (strpos($image, '.gif'))
			{
				$lnk = explode(".gif", $image);
			}
			else if (strpos($image, '.png'))
			{
				$lnk = explode(".png", $image);
			}
			else if (strpos($image, '.jpg'))
			{
				$lnk = explode(".jpg", $image);
			}

			$lnk[0] = str_replace('+','/', $lnk[0]);
			$lnk[0] = str_replace('@','?', $lnk[0]);
			$lnk[0] = str_replace('£','+', $lnk[0]);

			// strict //
			$linkscontent .= "<a href=\"http://$lnk[0]\" ><img src=\"".$phpbb_root_path."images/links/$image\" alt=\"$lnk[0]\" /></a><br /><br />";
			// transitional //
			//$linkscontent .= "<a href=\"http://$lnk[0]\" target=\"_blank\"><img src=\"".$phpbb_root_path."images/links/$image\" alt=\"$lnk[0]\" /></a><br /><br />";
		}

		$linkscontent .= "</div>";
	}
	else
	{
		$linkscontent  = '<br /> <div style="text-align: center; width: 100%; margin: 0 auto; padding: 0;">';

		for ($i = 0; $i <= $k_links_to_display-1; $i++)
		{
			$image = $imglist[$i+$random];

			if (strstr($image, 'gif'))
			{
				$lnk = explode(".gif", $image);
			}
			else if (strstr($image, 'png'))
			{
				$lnk = explode(".png", $image);
			}
			else if (strstr($image, 'jpg'))
			{
				$lnk = explode(".jpg", $image);
			}

			$lnk[0] = str_replace('+','/', $lnk[0]);
			$lnk[0] = str_replace('@','?', $lnk[0]);
			$lnk[0] = str_replace('£','+', $lnk[0]);

			// strict //
			$linkscontent .= "<a href=\"http://$lnk[0]\"><img src=\"".$phpbb_root_path."images/links/$image\" alt=\"$lnk[0]\" /></a><br /><br />";
			// transitional //
			//$linkscontent .= "<a href=\"http://$lnk[0]\" target=\"_blank\"><img src=\"".$phpbb_root_path."images/links/$image\" alt=\"$lnk[0]\" /></a><br /><br />";
		}

		$linkscontent .= "</div>";
	}

	//if($k_links_to_display != 0) $linkscontent .= '</div>';

	$template->assign_vars(array(
		'LINKSCONTENT' 		=> $linkscontent,
		'SUBMIT_LINK' 		=> $links_forum,
		'LINKS_ERROR' 		=> true,
		'LINKS_COUNT'		=> $a,
		'LINKS_DEBUG'		=> sprintf($user->lang['PORTAL_DEBUG_QUERIES'], ($queries) ? $queries : '0', ($cached_queries) ? $cached_queries : '0', ($total_queries) ? $total_queries : '0'),
	));

?>