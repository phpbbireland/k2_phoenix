<?php
/**
*
* common [English]
*
* @package language (Kiss Portal Engine)
* @version $Id:$
* @copyright (c) 2005 phpbireland
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
* @note: Do not remove this copyright. Just append yours if you have modified it, this is part of the Kiss Portal Engine copyright
* @updated 09 May 2011
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//
// Portal Menu Names + add you menu language variables here! //

$lang = array_merge($lang, array(
	'ACP'              => 'Admin CP',
	'ALBUM'            => 'Album',
	'BOOKMARKS'        => 'Bookmarks',
	'CATEGORIES'       => 'Categories',
	'SGP_Blog'         => 'SGP Integrated Blog',
	'DOWNLOADS'        => 'Downloads',
	'FORUM'            => 'Forum',
	'KB'               => 'Knowledge Base',
	'LINKS'            => 'Links',
	'LINKS_MENU'       => 'Links Menu',
	'MEMBERS'          => 'Members',
	'PORTAL'           => 'Portal',
	'HOME'             => 'Home',
	'RATINGS'          => 'Latest Ratings',
	'REFRESH_ALL'      => 'Refresh All',
	'RULES'            => 'Site Rules',
	'SITE_NAVIGATOR'   => 'Navigator',
	'STATISTICS'       => 'Statistics',
	'SITE_RULES'       => 'Site Rules',
	'SITE_STATISTICS'  => 'Site Statistics',
	'STAFF'            => 'Staff',
	'STYLES_DEMO'      => 'Styles Demo',
	'STYLE_SELECT'     => 'Style Select',
	'UCP'              => 'User CP',
	'UNRESOLVED/BUGS'  => 'Unresolved/Bugs',
	'UPLOAD'           => 'Upload Images',
	'USER_INFORMATION' => 'User Information',
	'WELCOME'          => 'Welcome',
));

// Portal Block Names + add your block name language variables here! //
$lang = array_merge($lang, array(
	'ACP_SMALL'         => 'Admin CP',
	'ANNOUNCEMENTS'     => 'Announcements',
	'BIRTHDAY'          => 'Birthday',
	'BLOG'              => 'SGP Integrated Blog',
	'BOARD_MINI_NAV'    => 'Sub Nav',
	'BOARD_STYLE'       => 'Board Style',
	'BOARD_NAV'         => 'Board Navigation',
	'BOT_TRACKER'       => 'Bot Tracker',
	'BOT_TRACKER_SMALL' => 'Bot Tracker',
	'BOOKS'             => 'Books',
	'CALENDAR'          => 'Calendar',
	'CHAT'              => 'Chat',
	'CLOCK'             => 'Clock',
	'DOWNLOADS'         => 'Downloads',
	'FM_RADIO'          => 'FM Radio',
	'FORUM_CATEGORIES'  => 'Forum categories',
	'GALLERY'           => 'Gallery',
	'LINKS'             => 'Links',
	'MAIN_MENU'         => 'Board Navigation',
	'MEMBERS'           => 'Members',
	'MP3_PLAYER'        => 'Mp3 player',
	'NEWS'              => 'News',
	'NEWS_REPORT'       => 'Site News Report',
	'PORTAL'            => 'Portal',
	'PORTAL_STATUS'     => 'Portal Status',
	'RECENT_TOPICS'     => 'Recent Topics',
	'SELECT_STYLE'      => 'Select a new style',
	'SITE_LINK_TXT'     => 'Link to us',
	'STAFF'             => 'Staff',
	'STATISTICS'        => 'Statistics',
	'STATS'             => 'Statistics',
	'STYLE_STATUS'      => 'Styles Status',
	'SUB_MENU'          => 'Sub Menu',
	'TEAM'              => 'The Team',
	'TOP_10_PICS'       => 'Top 10 Rated Pictures',
	'TOP_DOWNLOADS'     => 'Top Downloads',
	'TOP_POSTERS'       => 'Top Posters',
	'TOP_TOPICS_DAYS'   => 'in the last %d days',
	'UNRESOLVED'        => 'Unresolved',
	'UCP'               => 'User CP',
	'USER_INFO'         => 'User Information',
	'WELCOME_SITE'      => 'Welcome to<br /><strong>%s</strong>',
	'YOUR_PROFILE'      => 'User profile',
	'CLOUD9_LINKS'      => 'Cloud9 Links',
	'CLOUD9_SEARCHES'   => 'Cloud9 Searches',
	'NO_BLOCKD_IN_DEVELOPMENT' => 'No blocks in development!',
));

// Block Names
$lang = array_merge($lang, array(
	'ADMIN_OPTIONS'           => 'Admin Options',
	'BUG_TRACKER'             => 'Bug Tracker',
	'TRANSLATE'               => 'Translate',
	'TRANSLATE_SITE'          => '<strong>Translate site to...</strong>',
	'TRANSLATE_RESET'         => '<strong>Reset to original language</strong>',
	'ANNOUNCEMENTS_AND_NEWS'  => 'News and Announcements',
));

// Acronyms
$lang = array_merge($lang, array(
	'ACRONYMS'               => 'Acronyms',
	'ALLOW_ACRONYMS'         => 'Process Local Acronyms (built in) in posts',
	'ALLOW_ACRONYMS_EXPLAIN' => 'Allow local acronyms in posts',
));

// IRC Channel(s)
$lang = array_merge($lang, array(
	'IRC'          => 'IRC',
	'IRC_POPUP'    => 'Popup IRC Channel',
	'SIGNED_OFF'   => 'Signed off',
	'NO_JAVA_SUP'  => 'No java support',
	'NO_JAVA_VER'  => 'Sorry, but you need a Java 1.4.x enabled browser to use PJIRC',
));

// Age ranges
$lang = array_merge($lang, array(
	'AGE_RANGE'        => 'Age range',
	'AVERAGE_AGE'      => 'Average age',
	'COUNT'            => 'Count',
	'NONE'             => 'None found.',
	'PERCENT'          => 'Percent',
	'TOTAL_AGE'        => 'Total age',
	'TOTAL_AGE_COUNTS' => 'Total age counts',
	'YEARS'            => 'years.',
));

// RSS Newsfeeds
$lang = array_merge($lang, array(
	'NO_CURL'               => 'curl not installed. Use fopen instead (change in ACP)',
	'NO_FOPEN'              => 'fopen not installed. Use curl instead (change in ACP)',
	'RSS_CACHE_ERROR'       => 'Sorry, no RSS items found in the cache file.',
	'RSS_FEED_ERROR'        => 'Or something wrong with RSS feed.',
	'RSS_LIST_ERROR'        => 'Could not get RSS list.',
	'RSS_ERROR'             => 'RSS Error - Check feed link (above) to confirm.',
	'LOG_RSS_CACHE_CLEANED' => 'RSS cache cleared',
));

// HTTP Referrals
$lang = array_merge($lang, array(
	'TOT_REF' => 'Total Referrals',
	'LIMITS'  => 'Limits',
	'SHOWN'   => 'shown.',
));

// Mini Mods
$lang = array_merge($lang, array(
	'VERSION'        => 'Version',
	'CHECK_VERSION'  => 'Check for updates',
));

?>