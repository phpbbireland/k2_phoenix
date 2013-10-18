<?php
/**
*
* k_newsfeeds [English]
*
* @package language (Kiss Portal Engine / Stargate Portal)
* @version $Id$
* @copyright (c) 2005-2013 phpbbireland
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
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

$lang = array_merge($lang, array(
	'ACP_FEED_MANAGE_FEED'      => 'Add or edit feed(s)',
	'ACP_FEED_EXPLAIN'          => 'Feed(s) management',
	'ADD_FEED'                  => 'Add New Feed',
	'CENTRED'                   => 'Centred',

	'FEED_ADDED'                => 'Feed successfully added',
	'FEED_ADD_FEED'             => 'ADD new feed',

	'FEED_CACHE_TIME'           => 'Cache Time',
	'FEED_CACHE_TIME_EXPLAIN'   => 'Maximum age of the cache file for a feed before it is updated, in seconds (default is 1 hour = 60 minutes = 3600 seconds).',
	'FEED_CURL'                 => 'CURL',
	'FEED_DESCRIPTION'          => 'Feed name/description',
	'FEED_DESCRIPTION_SHOW'     => 'Show name/description',

	'FEED_EDIT'                 => 'Edit Feed’s',
	'FEED_EDIT_EXPLAIN'         => 'Here you can add or edit an existing Feed entry. The Title and version number are required. You will also be able to enter details of where the Feed can be downloaded from and where the Feed itself can be found.',
	'FEED_EDIT_HEADER'          => 'Adding/Editing a feed',
	'FEED_EDIT_HEADER_EXPLAIN'  => 'Add/Edit this feed details',

	'FEED_ENABLED_EXPLAIN'      => 'Enable/Disable RSS on your site.',
	'FEED_EXPLAIN'              => 'Text of your Feed goes inhere',

	'FEED_FOPEN'                => 'FOPEN',

	'FEED_IN_DB'                => 'Feed’s in database',
	'FEED_ITEMS_LIMIT'          => 'Items limit',
	'FEED_ITEMS_LIMIT_EXPLAIN'  => 'Max Number of shown news from one RSS feed',

	'FEED_MOD_TITLE'            => 'RSS Feed Mod',
	'FEED_MOD_TITLE_EXPLAIN'    => 'Here you can configure basic behavior of lastRSS &amp; manage RSS feeds',

	'FEED_POSITION'             => 'Show this feed in position',
	'FEED_POSITION_WIDE'        => 'Leff and Right feeds are displayed in two columns, Centred feeds displayed in one column (can be mixed).',
	'FEED_POSITIONS'            => 'Position',
	'FEED_POSITION_EXPLAIN'     => 'Specify the location of this RSS block.',

	'FEED_RANDOM_LIMIT'         => 'Random limit',
	'FEED_RANDOM_LIMIT_EXPLAIN' => 'Maximum feeds to randomize in the block.',
	'FEED_REMOVED'              => 'Feed successfully removed',

	'FEED_SETTINGS'             => 'Portal Feeds',
	'FEED_SETTINGS_EXPLAIN'     => 'Feed State',
	'FEED_SHOW'                 => 'Show Feed',
	'FEED_SHOW_DESCRIPTION'     => 'Show Description',
	'FEED_SHOW_FEED'            => 'Show feed Yes/No?',
	'FEED_STATE'                => 'State',

	'FEED_TITLE'                => 'Feed Title',
	'FEED_TITLE_EXPLAIN'        => 'Short but descriptive title of the Feed.',
	'FEED_TYPE'                 => 'For downloading RSS use function',
	'FEED_TYPE_EXPLAIN'         => '(FOPEN or CURL is not enabled on every server)',

	'FEED_UPDATED'              => 'Feed successfully edited',
	'FEED_URL'                  => 'URL address of RSS feed',
	'FEED_URL_EXPLAIN'          => 'Full URL address, starting with http://...',

	'FEED_VISIT_FEED'           => 'Subscribe to feed',
));

?>