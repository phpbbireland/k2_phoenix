/*
	Check IE
*/
(function()
{
	if(navigator && navigator.appVersion)
	{
		var v = navigator.appVersion,
			pos = v.indexOf('MSIE ');
		if(pos)
		{
			v = v.substr(pos + 5);
			var list = v.split('.', 2);
			if(list.length == 2)
			{
				v = parseInt(list[0]);
				if(v)
				{
					phpBB.ie = v;
				}
			}
		}
	}
})();

jQuery(document).ready(function()
{
	jQuery('.phpbb').addClass('js');

	/*
		Test browser capabilities
	*/
	var rootElement = jQuery('.phpbb');
	if(phpBB.ie) rootElement.addClass('ie' + phpBB.ie);
	rootElement.addClass(phpBB.ie && phpBB.ie < 8 ? 'no-tables' : 'display-table');
	rootElement.addClass(phpBB.ie && phpBB.ie < 9 ? 'no-rgba' : 'has-rgba');
	if(!phpBB.ie)
	{
		var browser = (navigator.userAgent) ? navigator.userAgent : '';
		if(browser.indexOf('Opera') >= 0)
		{
			rootElement.addClass('browser-opera');
		}
		else if(browser.indexOf('WebKit') > 0)
		{
			rootElement.addClass('browser-webkit');
		}
		else if(browser.indexOf('Gecko') > 0)
		{
			rootElement.addClass('browser-mozilla');
		}
	}
	
	/*
		IE7 stuff
	*/
	if(phpBB.ie && phpBB.ie < 8)
	{
		jQuery('div.layout-wrapper').each(function(i)
		{
			jQuery(this).children().each(function(j)
			{
				jQuery(this).wrapInner('<td class="' + jQuery(this).attr('class') + ((j == 0) ? ' first' : '') + '" />').children().unwrap();
			});
			jQuery(this).wrapInner('<table class="layout-wrapper" cellspacing="0" cellpadding="0"><tbody><tr></tr></tbody></table>').children().unwrap();
		});
	}
	jQuery('.phpbb .layout-wrapper > div:last, .phpbb .layout-wrapper > tbody > tr > td:last').css('border-right-width', 0);
	
	/*
		Navigation
	*/
	jQuery('p.autologin').each(function()
	{
		jQuery(this).attr('title', jQuery(this).text());
	});

	/*
		Jump box
	*/
	function setupJumpBox()
	{
		var data = jQuery('#jumpbox-data option'),
			list = [],
			levels = {},
			lastLevel = -1;
		if(!data.length || data.length != phpBB.jumpBoxData.length)
		{
			jQuery('#jumpbox-data').remove();
			return false;
		}
		for(var i=0; i<phpBB.jumpBoxData.length; i++)
		if(phpBB.jumpBoxData[i].id >= 0)
		{
			var level = phpBB.jumpBoxData[i].level.length;
			phpBB.jumpBoxData[i].level = level;
			phpBB.jumpBoxData[i].name = jQuery.trim(data.eq(i).text());
			if(!phpBB.jumpBoxData[i].selected) phpBB.jumpBoxData[i].selected = false;
			// find parent item
			levels[level] = list.length;
			lastLevel = level;
			phpBB.jumpBoxData[i].prev = (level > 0) ? levels[level - 1] : -1;
			list.push(phpBB.jumpBoxData[i]);
		}
		phpBB.jumpBoxData = list;
		jQuery('#jumpbox-data').remove();
		return (list.length > 0);
	}
	if(typeof(phpBB.jumpBoxAction) != 'undefined')
	{
		if(setupJumpBox())
		{
			// setup full jumpbox
			var text = phpBB.jumpBoxText(phpBB.jumpBoxData);
			jQuery('.phpbb .nav-jumpbox').each(function()
			{
				jQuery(this).addClass('popup-trigger').append('<div class="popup popup-list">' + text + '</div>');
			});
			jQuery('#jumpbox:has(select):not(#cp-main #jumpbox)').each(function()
			{
				var select = jQuery('select', this).get(0),
					val = (select && select.options.length) ? ((select.selectedIndex > 1) ? select.options[select.selectedIndex].value : select.options[0].value) : '',
					title = (select && select.options.length) ? ((select.selectedIndex > 1) ? select.options[select.selectedIndex].text : select.options[0].text) : '';
				if(val)
				{
					for(var i=0; i<phpBB.jumpBoxData.length; i++)
					{
						if(phpBB.jumpBoxData[i].id > 0 && phpBB.jumpBoxData[i].id == val)
						{
							title = phpBB.jumpBoxData[i].name;
						}
					}
				}
				if(title.length)
				{
					jQuery('input[type="submit"]', this).remove();
					jQuery('select', this).replaceWith('<div class="jumpbox popup-trigger popup-up right"><a class="button" href="javascript:void(0);"><span></span>' + title + '</a><div class="popup popup-list">' + text + '</div></div>');
					jQuery(this).addClass('jumpbox-js');
				}
			});
			jQuery('.phpbb .nav-forum').each(function()
			{
				function checkLink(link, id)
				{
					// split link
					link += ' ';
					var list = link.split(id),
						total = list.length - 1;
					for(var i=0; i<total; i++)
					if(list[i].length > 0 && list[i + 1].length > 0)
					{
						// check if previous and next characters are numbers
						var char1 = list[i].charCodeAt(list[i].length - 1),
							char2 = list[i + 1].charCodeAt(0);
						if((char1 < 48 || char1 > 57) && (char2 < 48 || char2 > 57)) return true;
					}
					return false;
				}
				
				function findItems(num, showNested)
				{
					var item = phpBB.jumpBoxData[num],
						current = false,
						list = [];
					for(var i=item.prev + 1; i<phpBB.jumpBoxData.length; i++)
					{
						var item2 = phpBB.jumpBoxData[i];
						if(item2.level < item.level)
						{
							// another category
							return list;
						}
						if(item2.level == item.level)
						{
							if(item2.prev != item.prev)
							{
								// belongs to another category
								return list;
							}
							current = (i == num);
							if(current != item2.selected)
							{
								var item2 = jQuery.extend({}, item2, true);
								item2.selected = current;
							}
							list.push(item2);
						}
						else if(showNested && current)
						{
							if(item2.selected)
							{
								var item2 = jQuery.extend({}, item2, true);
								item2.selected = false;
							}
							list.push(item2);
						}
					}
					return list;
				}
				
				var title = jQuery.trim(jQuery(this).text()),
					found = [];
				// find all entries with same name
				for(var i=0; i<phpBB.jumpBoxData.length; i++)
				{
					if(phpBB.jumpBoxData[i].name == title)
					{
						found.push(i);
					}
				}
				if(!found.length) return;
				var num = found[0];
				if(found.length > 1)
				{
					var found2 = [],
						link = jQuery('a', this).attr('href');
					// find all entries with same link
					for(var i=0; i<found.length; i++)
					{
						if(checkLink(link, phpBB.jumpBoxData[found[i]].id))
						{
							found2.push(found[i]);
						}
					}
					if(!found2.length) return;
					num = found2[0];
				}
				// found 1 or more items. get items in same category + nested items
				var list = findItems(num, !jQuery(this).hasClass('hide-nested'));
				if(list.length < 2) return;
				// create popup
				var text = phpBB.jumpBoxText(list, phpBB.jumpBoxData[num].level);
				jQuery('a.text', this).addClass('text-popup');
				jQuery(this).addClass('popup-trigger').append('<div class="popup popup-list">' + text + '</div>');
			});
		}
	}
	
	/*
		Headers
	*/
	jQuery('.phpbb .page-content > h2, .phpbb #cp-main > h2').addClass('header');
	jQuery('.phpbb h2.header').not('.header-outer, .not-header').addClass('header-outer').wrapInner('<div class="header-left"><div class="header-right"><div class="header-inner"></div></div></div>');

	/*
		Tables
	*/
	jQuery('.phpbb table.table1').attr('cellspacing', '1');
	
	/*
		Inner blocks
	*/
	jQuery('.phpbb div.navbar').not('.panel').addClass('panel').wrapInner('<div class="inner"></div>');
	jQuery('.phpbb ul.navbar').wrap('<div class="panel navbar"><div class="inner"></div></div>');
	
	jQuery('.phpbb .post > div').not('.post-outer > div, .post-wrap').addClass('post-content-wrap');
	jQuery('.phpbb .panel > div').not('.panel-outer > div').addClass('inner');
	
	jQuery('.phpbb div.panel div.post, .phpbb div.panel ul.topiclist, .phpbb div.panel table.table1, .phpbb div.panel dl.panel').parents('.phpbb div.panel').addClass('panel-wrapper').find('.inner:first').addClass('inner-first');
	jQuery('.phpbb #cp-main .panel').each(function()
	{
		var inner = jQuery(this).find('.inner:first');
		if(!inner.length) return;
		if(inner.children().length < 2)
		{
			jQuery(this).hide();
		}
	});

	jQuery('.phpbb .topiclist > li.row').not('.row-outer').addClass('row-outer').wrapInner('<div class="row-wrap row-left"><div class="row-wrap row-right"><div class="row-inner"></div></div></div>').find('.row-wrap.row-left').before('<div class="row-wrap row-top"><span class="row-left"></span><span class="row-right"></span></div>').after('<div class="row-wrap row-bottom"><span class="row-left"></span><span class="row-right"></span></div>');
	
	jQuery('.phpbb .panel, .phpbb .rules, .phpbb .cp-mini').not('.panel-outer, .rules').addClass('panel-outer').wrapInner('<div class="panel-wrap row-left"><div class="panel-wrap row-right"><div class="panel-inner"></div></div></div>').find('.panel-wrap.row-left').before('<div class="panel-wrap row-top"><span class="row-left"></span><span class="row-right"></span></div>').after('<div class="panel-wrap row-bottom"><span class="row-left"></span><span class="row-right"></span></div>');

	jQuery('.phpbb .post').not('.post-outer').addClass('post-outer').wrapInner('<div class="post-wrap row-left"><div class="post-wrap row-right"><div class="row-inner"></div></div></div>').find('.post-wrap.row-left').before('<div class="post-wrap row-top"><span class="row-left"></span><span class="row-right"></span></div>').after('<div class="post-wrap row-bottom"><span class="row-left"></span><span class="row-right"></span></div>');
	
	/*
		Toggle forums
	*/
	phpBB.hiddenForums = phpBB.getCookie('hidden');
	if(phpBB.hiddenForums == null)
	{
		phpBB.hiddenForums = [];
	}
	else
	{
		phpBB.hiddenForums = phpBB.hiddenForums.split(',');
	}
	jQuery('.phpbb ul.topiclist.forums').each(function(i)
	{
		var id = jQuery(this).data('id');
		if(!id) return;
		jQuery(this).attr('id', 'phpbb-cat-' + id);
		if(jQuery('li.row.unread', this).length > 0)
		{
			jQuery('.header', jQuery(this).prev()).addClass('unread');
		}
		jQuery(this).prev().click(function() {
			if(jQuery(this).hasClass('over-link')) return;
			var hidden = jQuery('.header', this).hasClass('inactive');
			phpBB.setHiddenForum(jQuery(this).next().data('id'), !hidden);
			jQuery(this).next().slideToggle(150);
			jQuery('.header', this).toggleClass('inactive');
		}).addClass('expandable').find('a').hover(function() {
			jQuery(this).parents('ul').toggleClass('over-link');
		});
	});
	for(var i=0; i<phpBB.hiddenForums.length; i++)
	{
		jQuery('#phpbb-cat-' + phpBB.hiddenForums[i]).each(function()
		{
			jQuery(this).slideToggle(0);
			jQuery('.header', jQuery(this).prev()).addClass('inactive');
		});
	}

	/*
		Expand menu
	*/
	jQuery('.phpbb .menu > li.expandable').click(function()
	{
		jQuery(this).toggleClass('collapsed').parent().next().slideToggle(150);
	});
	
	/*
		Popups
	*/
	jQuery('.phpbb .popup input, .phpbb .popup select').focus(function() { jQuery(this).parents('.popup').addClass('active'); }).blur(function() { jQuery(this).parents('.popup').removeClass('active'); });
	jQuery('.phpbb .popup-list > ul > li, .phpbb .popup-list > ol > li > ul > li').addClass('popup-link');

	/*
		Inputs
	*/
	jQuery('.phpbb input[type="text"], .phpbb input[type="password"], .phpbb input[type="email"], .phpbb textarea').change(function() { jQuery(this).toggleClass('not-empty', jQuery(this).val().length > 0); }).each(function()
	{
		jQuery(this).toggleClass('not-empty', jQuery(this).val().length > 0);
	});

	/*
		Forgot password link
	*/
	var item = jQuery('#phpbb-sendpass');
	if(item.length)
	{
		var itemLink = item.find('.data-register').text(),
			itemText = item.find('.data-forgot').text();
		if(itemLink.indexOf('mode=register'))
		{
			item.html('<a class="button2" href="' + itemLink.replace(/mode=register/, 'mode=sendpassword') + '">' + itemText + '</a>').css('display', '');
		}
	}

	/*
		Content size
	*/
	if(jQuery('.phpbb .forum-wrapper').length)
	{
		phpBB.resizeContent();
		jQuery(window).on('resize load', function() { phpBB.resizeContent(); });
	}
});

/*
	Resize window
*/
phpBB.resizeContent = function()
{
	var content = jQuery('.phpbb .forum-wrapper'),
		h = content.height(),
		pageHeight = jQuery('.phpbb').height();
	if(!pageHeight)
	{
		return;
	}
	var diff = pageHeight - h;
	h = Math.max(400, Math.floor(jQuery(window).height() - diff));
	jQuery('.phpbb .forum-wrapper').css('min-height', h + 'px');
};

/*
	Jump box data
*/
phpBB.jumpBoxText = function(list)
{
	var levelDiff = (arguments.length > 1) ? arguments[1] : 0,
		text = '<ul>',
		count = 0,
		maxLevel = 0,
		lastLevel = -1,
		rows = false,
		noHighlight = false,
		limit = (phpBB.ie && phpBB.ie < 8) ? 0 : (list.length > 30 ? 25 : list.length);
	for(var i=0; i<list.length; i++)
	{
		if(limit > 0 && count >= limit)
		{
			if(!rows)
			{
				text = '<ol><li>' + text;
				rows = true;
			}
			text += '</ul></li><li><ul>';
			count = 0;
		}
		count ++;
		var diff = list[i].level - levelDiff;
		if(diff > 4) diff = 4;
		text += '<li class="popup-link nowrap level-' + diff;
		if(diff == 0)
		{
			if(lastLevel != 0) text += ' level-root';
			else noHighlight = true;
		}
		lastLevel = diff;
		if(list[i].selected) text += ' row-new';
		if(list[i].name.length > 40) text += ' long';
		text += '">';
		if(list[i].url)
		{
			text += '<a href="' + list[i].url + '">';
		}
		else
		{
			text += '<a href="javascript:void(0);" onclick="phpBB.jumpBox(' + list[i].id + '); return false;">';
		}
		if(diff > 0)
		{
			maxLevel = Math.max(maxLevel, diff);
			text += '<span class="level">';
			for(var j=0; j<diff; j++) text += '- ';
			text += '</span> ';
		}
		text += list[i].name;
		text += '</a></li>';
	}
	if(rows)
	{
		for(var i=count; i<limit; i++)
		{
			text += '<li class="popup-link empty"></li>';
		}
	}
	text += '</ul>' + (rows ? '</li></ol>' : '');
	if(!noHighlight && maxLevel > 0)
	{
		// highlight root categories
		var tag = (list.length > limit) ? 'ol' : 'ul';
		text = text.replace('<' + tag + '>', '<' + tag + ' class="show-levels">');
	}
	return text;
};

phpBB.jumpBox = function(id)
{
	var d = new Date(),
		itemId = 'form-' + d.getTime();
	jQuery('body').after('<div id="' + itemId + '" style="display: none;"><form action="' + phpBB.jumpBoxAction + '" method="post"><input type="hidden" name="f" value="' + id + '" /></form></div>');
	jQuery('#' + itemId + ' form').get(0).submit();
};

phpBB.setCookie = function(name, value) 
{
	var argv = arguments;
	var argc = arguments.length;
	var expires = (argc > 2) ? argv[2] : null;
	var path = (argc > 3) ? argv[3] : null;
	var domain = (argc > 4) ? argv[4] : null;
	var secure = (argc > 5) ? argv[5] : false;
	document.cookie = name + "=" + escape(value) +
		((expires == null) ? "" : ("; expires=" + expires.toGMTString())) +
		((path == null) ? "" : ("; path=" + path)) +
		((domain == null) ? "" : ("; domain=" + domain)) +
		((secure == true) ? "; secure" : "");
};

phpBB.getCookieVal = function(offset) 
{
	var endstr = document.cookie.indexOf(";",offset);
	if (endstr == -1)
	{
		endstr = document.cookie.length;
	}
	return unescape(document.cookie.substring(offset, endstr));
};

phpBB.getCookie = function(name) 
{
	var arg = name + "=";
	var alen = arg.length;
	var clen = document.cookie.length;
	var i = 0;
	while (i < clen) 
	{
		var j = i + alen;
		if (document.cookie.substring(i, j) == arg)
			return phpBB.getCookieVal(j);
		i = document.cookie.indexOf(" ", i) + 1;
		if (i == 0)
			break;
	} 
	return null;
};

phpBB.setHiddenForum = function(id, hide)
{
	function updateCookie()
	{
		var str = phpBB.hiddenForums.join(','),
			d = new Date();
		d.setTime(d.getTime() + 30*24*60*60*1000);
		phpBB.setCookie('hidden', str, d);
	}
	for(var i=0; i<phpBB.hiddenForums.length; i++)
	{
		if(phpBB.hiddenForums[i] == id)
		{
			// found it
			if(hide) return;
			phpBB.hiddenForums.splice(i, 1);
			updateCookie();
			return;
		}
	}
	if(!hide) return;
	phpBB.hiddenForums.push(id);
	updateCookie();
};
