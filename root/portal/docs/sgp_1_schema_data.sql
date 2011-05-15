INSERT INTO phpbb_k_acronyms (acronym_id, acronym, meaning, lang) VALUES
(1, ' SGP ', 'Stargate Portal (the original phpBB3 Portal by Michaelo and the Stargate Team)', 'en'),
(2, ' IntegraMod ', 'The best fully integrated phpBB pre-mod version ever.', 'en'),
(3, ' IM3 ', 'A fully integrated phpBB3 forum, incorporating IntegraMod, Stargate Portal and hundreds of mods..', 'en'),
(4, ' phpbb ', 'The best forum software ever...', 'en'),
(5, ' Stargate Portal ', 'The original and best portal for phpBB3', 'en');

INSERT INTO phpbb_k_blocks (id, ndx, title, position, type, active, html_file_name, php_file_name, img_file_name, view_by, groups, scroll, block_height, has_vars, is_static, minimod_based) VALUES
(1, 1, 'Site Navigator',		'L', 'H', 1, 'block_menus.html',				'', 'menu_links.gif',		1, 0, 0, 0, 0, 0, 0),
(2, 2, 'Sub_Menu',				'L', 'H', 1, 'block_sub_menus.html',			'', 'menu_links.gif',		1, 0, 0, 0, 0, 0, 0),
(3, 3, 'Style Select',			'L', 'H', 1, 'block_style_select.html',			'', 'menu_gallery.png',		1, 0, 0, 0, 0, 0, 0),
(4, 4, 'Online Users',			'L', 'H', 1, 'block_online_users.html',			'', 'none.gif',				1, 0, 0, 0, 0, 0, 0),
(5, 5, 'Last Online',			'L', 'H', 1, 'block_last_online.html',			'', 'mini_team.gif',		1, 0, 0, 0, 1, 0, 0),
(6, 6, 'Recent Topics',			'L', 'H', 0, 'block_recent_topics.html',		'', 'mini_message.png',		1, 0, 1, 200, 1, 0, 0),
(7, 7, 'Bot Tracker',			'L', 'H', 1, 'block_bot_tracker.html',			'', 'mini_user.png',		1, 0, 0, 0, 1, 0, 0),
(8, 8, 'Search',				'L', 'H', 1, 'block_search.html',				'', 'menu_search.png',		1, 0, 0, 0, 0, 0, 0),
(9, 9, 'Style Development',		'L', 'H', 1, 'block_styles_status.html',		'', 'menu_gallery.png',		1, 0, 0, 0, 1, 0, 0),
(10, 10, 'Categories',			'L', 'H', 1, 'block_forum_categories.html',		'', 'none.gif',				1, 0, 0, 0, 0, 0, 0),
(11, 11, 'Books',				'L', 'H', 1, 'block_books.html',				'', 'mini_books.gif',		1, 0, 0, 0, 0, 0, 0),
(12, 12, '',					'C', 'H', 1, 'block_welcome_message.html',		'', 'none.gif',				1, 0, 0, 0, 0, 0, 0),
(13, 13, 'Announcements',		'C', 'H', 1, 'block_announcements.html',		'', 'mini_announce.png',	1, 0, 0, 0, 1, 0, 0),
(14, 14, 'Recent Topics',		'C', 'H', 1, 'block_recent_topics_wide.html',	'', 'mini_message.png',		1, 0, 0, 200, 1, 0, 0),
(15, 15, 'News Report',			'C', 'H', 1, 'block_news_advanced.html',		'', 'menu_exclamation.png', 1, 0, 0, 0, 1, 0, 0),
(16, 16, 'Unresolved/Bugs',		'C', 'H', 1, 'block_unresolved_errs.html',		'', 'menu_ladybug.png',		1, 0, 0, 0, 0, 0, 0),
(17, 17, 'Rss',					'C', 'H', 0, 'block_rss_feeds.html',			'', 'mini_announce.png',	1, 0, 0, 0, 0, 0, 0),
(18, 18, 'User Information',	'R', 'H', 1, 'block_user_information.html',		'', 'mini_user.png',		1, 0, 0, 0, 0, 0, 0),
(19, 20, 'The Team',			'R', 'H', 1, 'block_the_team.html',				'', 'mini_team.gif',		1, 0, 0, 0, 1, 0, 0),
(20, 21, 'Top Posters',			'R', 'H', 1, 'block_top_posters.html',			'', 'menu_rating.png',		1, 0, 0, 0, 1, 0, 0),
(21, 22, 'Top Referers',		'R', 'H', 1, 'block_top_referers.html',			'', 'menu_links.png',		1, 0, 0, 0, 1, 0, 0),
(22, 23, 'Most Active Topics',	'R', 'H', 1, 'block_top_topics.html',			'', 'menu_notes.gif',		1, 0, 0, 0, 1, 0, 0),
(23, 24, 'Site Statistics',		'R', 'H', 1, 'block_statistics.html',			'', 'mini_statistics.gif',  1, 0, 0, 0, 0, 0, 0),
(24, 25, 'Clock',				'R', 'H', 1, 'block_clock.html',				'', 'menu_clock.gif',		1, 0, 0, 0, 0, 0, 0),
(25, 26, 'MP3 Player',			'R', 'H', 1, 'block_mp3_player.html',			'', 'mini_mp3.gif',			1, 0, 0, 0, 0, 0, 0),
(26, 27, 'Links',				'R', 'H', 1, 'block_links.html',				'', 'menu_ff.png',			1, 0, 1, 0, 0, 0, 0),
(27, 28, 'Link to us',			'R', 'H', 1, 'block_link_to_us.html',			'', 'menu_ff.png',			1, 0, 0, 0, 0, 0, 0),
(28, 29, 'Site Survey',			'R', 'H', 1, 'block_site_survey.html',			'', 'mini_statistics.gif',  1, 0, 0, 0, 0, 0, 0),
(29, 30, 'Top Downloads',		'R', 'H', 1, 'block_top_downloads.html',		'', 'none.gif',				0, 0, 0, 0, 0, 0, 0),
(30, 31, 'Translate',			'R', 'H', 1, 'block_translate.html',			'', 'mini_bf_trans.gif',	1, 0, 0, 0, 0, 0, 0),
(31, 32, 'Portal Status',		'R', 'H', 1, 'block_portal_status.html',		'', 'mini_statistics.gif',  1, 0, 0, 0, 0, 0, 0),
(32, 33, 'Downloads',			'R', 'H', 1, 'block_downloads.html',			'', 'none.gif',				5, 0, 0, 0, 0, 0, 0),
(33, 34, 'IRC Chat',			'R', 'H', 1, 'block_irc.html',					'', 'menu_staff.png',		1, 0, 0, 0, 1, 0, 0),
(34, 35, 'Age Ranges',			'R', 'H', 1, 'block_age_ranges.html',			'', 'menu_user.png',		1, 0, 0, 0, 1, 0, 0),
(35, 36, 'Poll',				'R', 'H', 0, 'block_poll.html',					'', 'menu_rating.png',		1, 0, 0, 0, 1, 0, 0),
(37, 19, 'Cloud 9',				'R', 'H', 1, 'block_cloud.html',				'', 'menu_modules.png',		1, 0, 0, 0, 0, 0, 0),
(36, 12, 'Block development',	'L', 'H', 1, 'block_dev_status.html',			'', 'menu_modules.png',		1, 0, 0, 0, 1, 0, 0);

INSERT INTO phpbb_k_blocks_config (id, blocks_width, blocks_enabled, use_external_files, update_files, layout_default, portal_version, portal_config) VALUES
(1, 180, 1, 0, 0, 2, 'RC1', 'Site...');

INSERT INTO phpbb_k_blocks_config_vars (config_name, config_value, is_dynamic) VALUES
('allow_acronyms', '0', 1),
('allow_announce', '1', 0),
('allow_bot_display', '1', 0),
('allow_footer_images', '1', 0),
('allow_news', '1', 0),
('allow_rotating_logos', '1', 0),
('announce_type', '0', 1),
('display_blocks_global', '1', 0),
('k_show_smilies', '1', 0),
('link_forum_id', '5', 0),
('link_to_us_image', 'phpbbireland.gif', 0),
('links_scroll_amount', '0', 0),
('links_scroll_direction', '0', 0),
('max_announce_item_length', '400', 0),
('max_news_item_length', '350', 0),
('max_last_online', '10', 0),
('news_type', '0', 1),
('number_of_announce_items_to_display', '5', 0),
('number_of_bots_to_display', '10', 0),
('number_of_links_to_display', '5', 0),
('number_of_news_items_to_display', '5', 0),
('number_of_recent_topics_to_display', '25', 0),
('number_of_topics_per_forum', '5', 0),
('number_of_team_members_to_display', '10', 0),
('number_of_top_posters_to_display', '10', 0),
('poll_forum_id', '2', 0),
('poll_position', 'right', 0),
('poll_post_id', '0', 0),
('poll_topic_id', '0', 0),
('poll_view', 'full', 0),
('rand_banner', '0', 0),
('rss_feeds_cache_time', '3600', 0),
('rss_feeds_items_limit', '5', 0),
('rss_feeds_random_limit', '4', 0),
('rss_feeds_type', 'fopen', 0),
('show_top_posters', '1', 0),
('use_cookies', '1', 0),
('num_refviews', '5', 0),
('referrals_enabled', '1', 0),
('rand_header', '1', 0),
('opt_irc_channels', '#stargateportal', 0),
('search_days', '7', 0),
('post_types', '1', 0),
('max_top_topics', '5', 0),
('age_range_interval', '15', 0),
('age_range_start', '1', 0),
('age_upper_limit', '101', 0),
('show_lb_ipsmuy', '111111', 0),
('show_rb_ipsmuy', '011100', 0),
('cloud_max_tags', '30', 0),
('cloud_movie', 'tagcloud.swf', 0),
('cloud_width', '156', 0),
('cloud_height', '156', 0),
('cloud_bg_colour', '272829', 0),
('cloud_speed', '150', 0),
('cloud_mode', 'both', 0),
('cloud_tcolour', 'FFFFFF', 0),
('cloud_tcolour2', '99ccff', 0),
('cloud_hicolour', '00ff00', 0),
('cloud_distr', '1', 0),
('cloud_wmode', 'transparent', 0),
('mini_mod_block_count', '3', 0),
('mini_mod_style_count', '5', 1),
('mini_mod_mod_count', '5', 0);


INSERT INTO phpbb_k_cloud (tag_id, is_active, tag, link, rel, font_size, colour, colour2, hcolour, text) VALUES
(1, 1, 1, 'http://www.phpbbireland.com', 'tag', '14', '669933', '333333', 'FF0000', 'Stargate Portal'),
(2, 1, 1, 'http://www.phpbb.com', 'tag', '12', '66CC33', 'FFCCFF', '00CC00', 'phpBB'),
(3, 1, 1, 'http://www.stargate-portal.com', 'tag', '14', 'FF3300', 'CC3366', '33CC00', 'Dev Site'),
(4, 1, 1, 'http://www.integramod.com/forum/portal.php', 'tag', '14', '66CCFF', 'FFCCFF', '99FF66', 'IntegraMOD3');


INSERT INTO phpbb_k_quotes (quote_id, quote, author) VALUES
(1, 'Anyone who lives within their means suffers from a lack of imagination.', 'Oscar Wilde'),
(2, 'I was working on the proof of one of my poems all the morning, and took out a comma. In the afternoon I put it back again.', 'Oscar Wilde');

INSERT INTO phpbb_k_menus (m_id, ndx, menu_type, name, link_to, append_sid, append_uid, menu_icon, view_by, soft_hr, sub_heading) VALUES
(1, 1, 1,	'Main Menu',		'',													0, 0, 'none.gif',					1, 0, 1),
(2, 2, 1,	'Portal',			'portal.php',										0, 0, 'menu_home.png',				1, 0, 0),
(3, 3, 1,	'Forum',			'index.php',										0, 0, 'menu_home2.png',				1, 0, 0),
(4, 4, 1,	'Navigator',		'',													0, 0, 'none.gif',					1, 0, 1),
(5, 5, 1,	'Album',			'inprogress.php',									0, 0, 'menu_edit_img.png',			1, 0, 0),
(6, 6, 1,	'Bookmarks',		'ucp.php?i=main&amp;mode=bookmarks',				0, 0, 'menu_bookmark.png',			2, 0, 0),
(7, 7, 1,	'Downloads',		'inprogress.php',									0, 0, 'menu_ff.png',				2, 0, 0),
(8, 8, 1,	'Links',			'inprogress.php',									0, 0, 'menu_link.gif',				1, 0, 0),
(9, 9, 1,	'Members',			'memberlist.php',									0, 0, 'menu_chat.png',				2, 0, 0),
(10, 10, 1, 'Ratings',			'index.php',										0, 0, 'menu_rating.png',			1, 0, 0),
(11, 11, 1, 'Rules',			'basic_rules.php',									0, 0, 'menu_terms_of_use.png',		1, 0, 0),
(12, 12, 1, 'Staff',			'memberlist.php?mode=leaders',						0, 0, 'menu_staff.png',				2, 0, 0),
(13, 13, 1, 'Statistics',		'inprogress.php',									0, 0, 'menu_pie.png',				1, 0, 0),
(14, 14, 1, 'UCP',				'ucp.php',											0, 0, 'menu_links.gif',				2, 0, 0),
(15, 15, 1, 'Chat',				'chat/index.php',									0, 0, 'menu_chat.png',				2, 0, 0),
(16, 16, 1, 'Admin Menu',		'',													0, 0, 'none.gif',					5, 0, 1),
(17, 17, 1, 'ACP',				'adm/index.php',									1, 0, 'menu_work.png',				5, 0, 0),
(18, 18, 1, 'REFRESH_ALL',		'sgp_refresh.php',									1, 0, 'menu_bin.png',				5, 0, 0),
(19, 1, 2,	'Mini Menu',		'',													0, 0, 'submenu',					1, 0, 1),
(20, 2, 2,	'Main Site Link',	'http://www.phpbbireland.com/forum/portal.php',		1, 0, 'menu_phpireland_globe.gif',	1, 0, 0),
(21, 3, 2,	'Old Web Pages',	'',													0, 0, 'none.gif',					1, 0, 1),
(22, 4, 2,	'About',			'web_page.php?mode=about',							0, 0, 'menu_bulb2.png',				1, 0, 0),
(23, 5, 2,	'Web Pages',		'web_page.php?mode=welcome',						0, 0, 'menu_ff.png',				1, 0, 0),
(24, 6, 2,	'Module Help',		'web_page.php?mode=modules',						0, 0, 'menu_search.png',			1, 0, 0),
(25, 7, 2,	'Web Pages',		'',													0, 0, 'none.gif',					1, 0, 1),
(26, 8, 2,	'About',			'web_page.php?mode=about',							0, 0, 'menu_links.png',				1, 0, 0),
(27, 1, 3,	'Test Header Item', '',													0, 0, 'menu_umberela.png',			1, 0, 0);

INSERT INTO phpbb_k_modules (mod_id, mod_link_id, mod_type, mod_origin, mod_name, mod_author, mod_link, mod_author_co, mod_support_link, mod_copyright, mod_thumb, mod_last_update, mod_details, mod_download_count, mod_status, mod_version) VALUES
(1, 0, 'welcome',		1, 'Welcome',			'Stargate Development Team',	'http://www.phpbbireland.com',	'None',						'http://www.phpbbireland.com',	'&copy; phpbbireland.com 2005-2009',	'logo_portal_red.png',	'Mon 25 Aug 2008', 'Welcome back [you]...&lt;br /&gt;&lt;br /&gt;\r\n&lt;strong&gt;phpbbireland.com &lt;/strong&gt; is powered by &lt;strong&gt;phpBB&lt;/strong&gt; ($phpbb_version)  and &lt;strong&gt; Stargate Portal &lt;/strong&gt;($portal_version).', 0, 100, '0.0.0'),
(2, 0, 'style',			1, 'prosilver',			'phpBB',						'http://www.phpbb.com',			'Michaelo',					'http://www.phpbbireland.com',	'&copy; phpBB 2005',					'',						'Mon 25 Aug 2008', 'Default proslver style', 1, 90, '3.0.4'),
(4, 2, 'style',			2, 'subsilver2',		'phpBB',						'http://www.phpbb.com',			'Michaelo',					'http://www.phpbbireland.com',	'&copy; 2005 phpBB Group',				'',						'Mon 25 Aug 2008', 'Default subsilver style.', 0, 90, '3.0.4'),
(5, 0, 'block',			1, 'Demo Block',		'Michaelo',						'http://www.phpbbireland.com',	'None',						'http://www.phpbbireland.com',	'&copy; phpbbireland',					'',						'Mon 25 Aug 2008', 'Demo Block only', 0, 50, '0.0.0'),
(6, 0, 'portal_status', 1, 'Stargate Portal',	'Michaelo',						'http://www.phpbbireland.com',	'phpbbireland dev team',	'',								'&copy; Michael O''Toole 2005-2009',	'',						'Mon 25 Aug 2008', 'Stargate Portal (the original phpBB3 portal), is a fully integrated portal system for your phpBB3 board.', 0, 0, '0.0.0');

INSERT INTO phpbb_k_newsfeeds (feed_id, feed_title, feed_show, feed_url, feed_position, feed_description) VALUES
(1, 'phpBB.com', 1, 'http://www.phpbb.com/feeds/rss/', 1, 1);

INSERT INTO phpbb_k_referer (id, host, hits, firstvisit, lastvisit, enabled) VALUES
(1, 'phpbbireland.com', 1, 1220665580, 1220665604, 1);


INSERT INTO phpbb_k_web_pages (id, active, page_name, page_type, last_updated, body, head, foot, external_file) VALUES
(1, 1, 'about', 'B', 'Mon 25 Aug 2008', '&lt;body id=&quot;phpBB&quot; class=&quot;about ltr&quot; &gt;\r\n	&lt;div class=&quot;outside&quot;&gt;\r\n		&lt;div class=&quot;top-left&quot;&gt;&lt;/div&gt;&lt;div class=&quot;top-center&quot;&gt;&lt;/div&gt;&lt;div class=&quot;top-right&quot;&gt;&lt;/div&gt;\r\n			&lt;div class=&quot;inside&quot;&gt;\r\n				&lt;div id=&quot;wrap&quot;&gt;\r\n					&lt;div class=&quot;header&quot;&gt;\r\n						&lt;h1&gt;&lt;a href=&quot;/&quot;&gt;phpBB &amp;bull; Creating Communities Worldwide&lt;/a&gt;&lt;/h1&gt;\r\n					&lt;/div&gt;\r\n					&lt;a name=&quot;start_here&quot;&gt;&lt;/a&gt;\r\n					&lt;div id=&quot;page-body&quot; style=&quot;padding-top:5px;&quot;&gt;\r\n					&lt;ul class=&quot;linklist navlinks&quot;&gt;\r\n						&lt;li&gt;&lt;a href=&quot;portal.php&quot;&gt;Home&lt;/a&gt;\r\n							&lt;strong&gt;&amp;#8249;&lt;/strong&gt; &lt;a href=&quot;web_page.php?mode=about&quot;&gt;About&lt;/a&gt;\r\n						&lt;/li&gt;\r\n					&lt;/ul&gt;\r\n\r\n					&lt;div id=&quot;main&quot;&gt;\r\n						&lt;h2 class=&quot;imgrep about&quot;&gt;About Portal Web Pages&lt;/h2&gt;\r\n						&lt;p&gt;&lt;strong&gt;Portal Web Pages&lt;/strong&gt; allow you to add additional pages to your site. These page consist of standard HTML code, so you can design a page in your favourite WYSIWYG editor and simply copy the contents into a new web page...&lt;/p&gt;\r\n						&lt;p&gt;For convenience we divided pages into headers, bodies and footers, this allows reuse of headers and footers are these are often common to other pages...&lt;/p&gt;\r\n						&lt;p&gt;This page serves as an example...&lt;/p&gt;\r\n						&lt;p&gt;&lt;/p&gt;\r\n					&lt;/div&gt;\r\n					&lt;div id=&quot;extras&quot;&gt;\r\n						&lt;div class=&quot;mini-panel sections&quot;&gt;\r\n							&lt;div class=&quot;inner&quot;&gt;&lt;span class=&quot;corners-top&quot;&gt;&lt;span&gt;&lt;/span&gt;&lt;/span&gt;\r\n								&lt;h3&gt;&lt;a href=&quot;web?mode=about&quot;&gt;About section&lt;/a&gt;&lt;/h3&gt;\r\n								&lt;ul class=&quot;menu&quot;&gt;\r\n									&lt;li&gt;&lt;a href=&quot;web_page.php?mode=welcome&quot;&gt;Welcome&lt;/a&gt;&lt;/li&gt;\r\n									&lt;li&gt;&lt;a href=&quot;web_page.php?mode=download&quot;&gt;Download&lt;/a&gt;&lt;/li&gt;\r\n									&lt;li&gt;&lt;a href=&quot;web_page.php?mode=features&quot;&gt;The features&lt;/a&gt;&lt;/li&gt;\r\n									&lt;li&gt;&lt;a href=&quot;web_page.php?mode=history&quot;&gt;The history&lt;/a&gt;&lt;/li&gt;\r\n									&lt;li&gt;&lt;a href=&quot;web_page.php?mode=team&quot;&gt;The team&lt;/a&gt;&lt;/li&gt;\r\n									&lt;li&gt;&lt;a href=&quot;http://www.phpbbireland.com/phpBB3/portal.php&quot;&gt;The Demo Site&lt;/a&gt;&lt;/li&gt;\r\n									&lt;li class=&quot;last&quot;&gt;&lt;a href=&quot;http://www.phpbbireland.com/portal/portal.php&quot;&gt;The Development Site&lt;/a&gt;&lt;/li&gt;\r\n								&lt;/ul&gt;\r\n								&lt;span class=&quot;corners-bottom&quot;&gt;&lt;span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/div&gt;		\r\n							&lt;/div&gt;\r\n						&lt;/div&gt;\r\n					&lt;/div&gt;\r\n				&lt;/div&gt;', 3, 4, ''),
(2, 1, 'welcome', 'B', 'Mon 25 Aug 2008', '&lt;body id=&quot;phpBB&quot; class=&quot;welcome ltr&quot; &gt;\r\n\r\n&lt;div class=&quot;outside&quot;&gt;\r\n	&lt;div class=&quot;top-left&quot;&gt;&lt;/div&gt;&lt;div class=&quot;top-center&quot;&gt;&lt;/div&gt;&lt;div class=&quot;top-right&quot;&gt;&lt;/div&gt;\r\n		&lt;div class=&quot;inside&quot;&gt;\r\n			&lt;div id=&quot;wrap&quot;&gt;\r\n				&lt;div class=&quot;header&quot;&gt;\r\n				&lt;h1&gt;&lt;a href=&quot;/&quot;&gt;phpBB ??? Creating Communities Worldwide&lt;/a&gt;&lt;/h1&gt;\r\n			&lt;/div&gt;\r\n			&lt;a name=&quot;start_here&quot;&gt;&lt;/a&gt;\r\n			&lt;div id=&quot;page-body&quot; style=&quot;padding-top:5px;&quot;&gt;\r\n				&lt;ul class=&quot;linklist navlinks&quot;&gt;\r\n					&lt;li&gt;&lt;a href=&quot;portal.php&quot;&gt;Home&lt;/a&gt;\r\n						&lt;strong&gt;&amp;#8249;&lt;/strong&gt; &lt;a href=&quot;web_page.php?mode=welcome&quot;&gt;Welcome&lt;/a&gt;\r\n					&lt;/li&gt;\r\n				&lt;/ul&gt;\r\n				&lt;div id=&quot;main&quot;&gt;\r\n					&lt;h2 class=&quot;imgrep about&quot;&gt;About IntergaMod&lt;/h2&gt;\r\n					&lt;p&gt;&lt;strong&gt;IntegraMod Portal&lt;/strong&gt; is the same as the Stargate but with all the mods included... The aim was to build a replacement for the IM Portal for the next generation of IntegraMOD...&lt;/p&gt;\r\n					&lt;p&gt;In the beginning there were many who questioned the logic of developing a portal for what was a pre-beta product, nevertheless I was not put off as for me it was a learning experience and I needed to learn... Over time the code has changed primarily to keep pace with phpBB update but quite a bit of the original code is still present...&lt;/p&gt;\r\n					&lt;p&gt;The portal is fully configurable in the ACP, I have includes many of the more useful blocks as well as one or two nice mods... For a full list of features see the &lt;a href=&quot;web_page.php?mode=features&quot;&gt;features...&lt;/a&gt;&lt;/p&gt;\r\n					&lt;p&gt;&lt;/p&gt;\r\n				&lt;/div&gt;\r\n				&lt;div id=&quot;extras&quot;&gt;\r\n					&lt;div class=&quot;mini-panel sections&quot;&gt;\r\n						&lt;div class=&quot;inner&quot;&gt;&lt;span class=&quot;corners-top&quot;&gt;&lt;span&gt;&lt;/span&gt;&lt;/span&gt;\r\n							&lt;h3&gt;&lt;a href=&quot;web_page.php?mode=about&quot;&gt;Welcome section&lt;/a&gt;&lt;/h3&gt;\r\n							&lt;ul class=&quot;menu&quot;&gt;\r\n								&lt;li&gt;&lt;a href=&quot;web_page.php?mode=about&quot;&gt;About&lt;/a&gt;&lt;/li&gt;\r\n								&lt;li&gt;&lt;a href=&quot;web_page.php?mode=download&quot;&gt;Download&lt;/a&gt;&lt;/li&gt;\r\n								&lt;li&gt;&lt;a href=&quot;web_page.php?mode=features&quot;&gt;The features&lt;/a&gt;&lt;/li&gt;\r\n								&lt;li&gt;&lt;a href=&quot;web_page.php?mode=history&quot;&gt;The history&lt;/a&gt;&lt;/li&gt;\r\n								&lt;li&gt;&lt;a href=&quot;web_page.php?mode=team&quot;&gt;The team&lt;/a&gt;&lt;/li&gt;\r\n								&lt;li&gt;&lt;a href=&quot;http://www.phpbbireland.com/phpBB3/portal.php&quot;&gt;The Demo Site&lt;/a&gt;&lt;/li&gt;\r\n								&lt;li class=&quot;last&quot;&gt;&lt;a href=&quot;http://www.phpbbireland.com/portal.php&quot;&gt;The Maint Site&lt;/a&gt;&lt;/li&gt;\r\n							&lt;/ul&gt;\r\n						&lt;span class=&quot;corners-bottom&quot;&gt;&lt;span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/div&gt;		\r\n						&lt;/div&gt;\r\n					&lt;/div&gt;\r\n				&lt;/div&gt;\r\n			&lt;/div&gt;', 3, 4, ''),
(3, 1, 'blue', 'H', 'Mon 25 Aug 2008', '&lt;!DOCTYPE html PUBLIC &quot;-//W3C//DTD XHTML 1.0 Strict//EN&quot; &quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd&quot;&gt;\n&lt;html xmlns=&quot;http://www.w3.org/1999/xhtml&quot; dir=&quot;ltr&quot; lang=&quot;en-gb&quot; xml:lang=&quot;en-gb&quot;&gt;\n&lt;head&gt;\n&lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=UTF-8&quot; /&gt;\n&lt;meta http-equiv=&quot;content-style-type&quot; content=&quot;text/css&quot; /&gt;\n&lt;meta http-equiv=&quot;content-language&quot; content=&quot;en-gb&quot; /&gt;\n&lt;meta http-equiv=&quot;imagetoolbar&quot; content=&quot;no&quot; /&gt;\n&lt;meta name=&quot;resource-type&quot; content=&quot;document&quot; /&gt;\n&lt;meta name=&quot;distribution&quot; content=&quot;global&quot; /&gt;\n&lt;meta name=&quot;copyright&quot; content=&quot;2002-2006 phpBB Group&quot; /&gt;\n&lt;meta name=&quot;keywords&quot; content=&quot;&quot; /&gt;\n&lt;meta name=&quot;description&quot; content=&quot;&quot; /&gt;\n&lt;title&gt;phpbbireland.com &amp;bull; Portal&lt;/title&gt;\n&lt;link rel=&quot;shortcut icon&quot; href=&quot;http:www.phpbbireland/favicon.ico&quot; /&gt;&lt;link rel=&quot;icon&quot; href=&quot;favicon.ico&quot; type=&quot;image/x-icon&quot; /&gt;\n&lt;link href=&quot;./styles/web/theme/common.css&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot; media=&quot;screen, projection&quot; /&gt;\n&lt;link href=&quot;./styles/web/theme/links.css&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot; media=&quot;screen, projection&quot; /&gt;\n&lt;link href=&quot;./styles/web/theme/content.css&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot; media=&quot;screen, projection&quot; /&gt;\n&lt;link href=&quot;./styles/web/theme/buttons.css&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot; media=&quot;screen, projection&quot; /&gt;\n&lt;link href=&quot;./styles/web/theme/cp.css&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot; media=&quot;screen, projection&quot; /&gt;\n&lt;link href=&quot;./styles/web/theme/forms.css&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot; media=&quot;screen, projection&quot; /&gt;\n&lt;link href=&quot;./styles/web/theme/tweaks.css&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot; media=&quot;screen, projection&quot; /&gt;\n&lt;link href=&quot;./styles/web/theme/colours.css&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot; media=&quot;screen, projection&quot; /&gt;\n&lt;link href=&quot;./styles/web/theme/website.css&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot; media=&quot;screen, projection&quot; /&gt;\n&lt;link href=&quot;./styles/web/theme/headers.css&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot; media=&quot;screen, projection&quot; /&gt;\n&lt;link href=&quot;./styles/web/theme/titles.css&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot; media=&quot;screen, projection&quot; /&gt;\n&lt;link href=&quot;./styles/web/theme/navigation.css&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot; media=&quot;screen, projection&quot; /&gt;\n&lt;link href=&quot;./styles/web/theme/documentation.css&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot; media=&quot;screen, projection&quot; /&gt;\n&lt;link href=&quot;./styles/web/theme/silver.css&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot; media=&quot;screen, projection&quot; /&gt;\n&lt;link href=&quot;./styles/web/theme/portal_adds.css&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot; media=&quot;screen, projection&quot; /&gt;\n&lt;/head&gt;', 0, 0, ''),
(4, 1, 'blue', 'F', 'Mon 25 Aug 2008', '&lt;div id=&quot;page-footer&quot;&gt;\n	&lt;div class=&quot;copyright&quot;&gt;Powered by &lt;a href=&quot;http://www.phpbb.com/&quot;&gt;phpBB&lt;/a&gt;  &amp;copy; 2000, 2002, 2005, 2007 phpBB Group&lt;/div&gt;\n&lt;div&gt;\n	&lt;a id=&quot;bottom&quot; name=&quot;bottom&quot; accesskey=&quot;z&quot;&gt;&lt;/a&gt;\n	&lt;div class=&quot;bottom-left&quot;&gt;&lt;/div&gt;&lt;div class=&quot;bottom-center&quot;&gt;&lt;/div&gt;&lt;div class=&quot;bottom-right&quot;&gt;\n&lt;/div&gt;\n&lt;/body&gt;\n&lt;/html&gt;', 0, 0, '');
