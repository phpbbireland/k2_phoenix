(function(jQuery) {

if(typeof(oldIE) == 'undefined') var oldIE = false;

jQuery(document).ready(function() {
    // detect browser
    var browser = (navigator.userAgent) ? navigator.userAgent : '';
    if(typeof(clrIE) == 'boolean')
    {
        browser = 'ie';
    }
    else
    {
        browser = (browser.indexOf('Opera') >= 0) ? (
            (browser.indexOf('Opera Mini/') > 0) ? 'opera-mini' : 'opera') : (
            (browser.indexOf('Gecko/') > 0) ? 'mozilla' : (
                (browser.indexOf('WebKit/') > 0) ? 'webkit' : (
                    (browser.indexOf('MSIE') > 0) ? 'ie' : 'unknown'
                )
            )
        );
    }
    jQuery('body').addClass('browser-' + browser + ((oldIE) ? ' old-ie transform' : ''));

    // transformations
    if(!oldIE)
    {
        setTimeout("jQuery('body').addClass('transform');", 500);
        jQuery(window).load(function() { jQuery('body').addClass('transform'); });
    }

    // navigation
    jQuery('div.nav-extra').not('div.nav-extra-footer').each(function()
    {
        var count = 0;
        jQuery(this).find('a').each(function() {
            if(count > 0) jQuery(this).before(' &bull; ');
            count ++;
        });
        if(!count) jQuery(this).css('display', 'none');
    });
    
    jQuery('#footer div.nav-links > a').each(function(i)
    {
        if(i > 0) jQuery(this).before(' &bull; ');
    });
    
    jQuery('.responsive-menu-nojs .responsive-menu').each(function()
    {
    	var jQuerythis = jQuery(this),
    		link = jQuerythis.children('a'),
    		parent = jQuerythis.parents('.responsive-menu-nojs');
    	if (!link.length || !parent.length) return;
    	parent.removeClass('responsive-menu-nojs');
    	link.add(parent.find('.responsive-menu-hide')).click(function() { parent.toggleClass('responsive-menu-visible'); });
    });

    // clear divs
    jQuery('#page-body, #footer').append('<div class="clear"></div>');
    jQuery('.cp-mini:last').after('<div class="clear"></div>');
    
    // remove extra lines
    jQuery('#page-body > hr, #cp-main > hr, #page-body > form > hr').remove();
    
    // unread posts
    jQuery('dl.icon').each(function()
    {
        var bg = jQuery(this).css('background-image');
        if(bg.length && bg.indexOf('_unread') > 0)
        {
            jQuery(this).parents('li:first').addClass('unread');
        }
        else if(bg.length && bg.indexOf('forum_link') > 0)
        {
            jQuery(this).parents('li:first').addClass('forum-link');
        }
    });
    
    // topic title
    jQuery('body.section-viewtopic #page-body > h2:first').addClass('title');
    
    // index: reported/unapproved topics
    jQuery('li.row a img').each(function()
    {
        if(this.src.indexOf('icon_topic_unapproved') > 0)
        {
            jQuery(this).parents('li.row:first').addClass('unapproved');
        }
    });
    jQuery('dd.lastpost a img').each(function()
    {
        if(this.src.indexOf('icon_topic_unapproved') > 0 || this.src.indexOf('icon_topic_reported') > 0)
        {
            var prev = jQuery(this).parents('dl.icon:first').find('dt');
            if(!prev.length) return;
            if(!prev.find('div.extra').length)
            {
                prev.prepend('<div class="extra"></div>');
            }
            prev = prev.find('div.extra');
            jQuery(this).parent('a').appendTo(prev);
        }
    });
    
    // remove rounded block within rounded block
    jQuery('div.panel div.post, div.panel ul.topiclist, div.panel table.table1, div.panel dl.panel').parents('div.panel').addClass('panel-wrapper');
    
    // tabs
    jQuery('#tabs, #navigation, #minitabs').each(function()
    {
        var last = false,
            count = 0;
        jQuery('li', jQuery(this)).each(function(i)
        {
            if(i == 0) jQuery(this).addClass('first');
            last = jQuery(this);
            count ++;
        });
        if(count < 2)
        {
            jQuery(this).hide();
        }
        else
        {
            if(last !== false) last.addClass('last');
            jQuery(this).find('hr').remove();
            jQuery(this).parents('form').css('display', 'inline');
            jQuery(this).append('<div class="clear"></div>');
            jQuery(this).find('a').each(function()
            {
                if(!jQuery('span', this).length)
                {
                    jQuery(this).html('<span>' + jQuery(this).html() + '</span>');
                }
            });
        }
    });
    jQuery('#navigation').parents('.panel').removeClass('panel').addClass('cp-panel');
    
    // control panel: remove empty boxes
    jQuery('#cp-main .panel').each(function()
    {
        var inner = jQuery(this).find('.inner:first');
        if(!inner.length) return;
        if(inner.children().length < 2)
        {
            jQuery(this).hide();
        }
    });
    
    // fix right side margin
    jQuery('#page-body > p.rightside').each(function()
    {
        var next = jQuery(this).next();
        if(next.is('p') && !next.hasClass('rightside')) next.css('margin-top', 0);
    });
    
    // pm post
    jQuery('.post > div, .panel > div').addClass('inner');
    
    // emulate multiple backgrounds
    if(oldIE)
    {
        jQuery('#header').wrapInner('<div class="hdr1"></div>');
        jQuery('#footer').wrapInner('<div class="hdr1"><div class="hdr2"></div></div>');
        jQuery('body').not('.simple').find('#page-body').wrap('<div id="page-body1"><div id="page-body2"></div></div>');
        jQuery('#page-header').wrapInner('<div class="hdr1"><div class="hdr2"><div class="hdr3"><div class="hdr4"><div class="hdr5"></div></div></div></div></div>');
        jQuery('div.panel > .inner').addClass('inner-panel');
        jQuery('div.forabg, div.forumbg, div.panel-wrapper').not('.cp-panel').addClass('old-ie-wrap-1').wrapInner('<div class="hdr1-1"><div class="hdr1-2"><div class="hdr1-3"><div class="hdr1-4"><div class="hdr1-5"></div></div></div></div></div>');
        jQuery('div.post, .panel, .cp-mini, ul.topiclist li').not('.header, .panel-wrapper').addClass('old-ie-wrap-2').wrapInner('<div class="hdr2-1"><div class="hdr2-2"><div class="hdr2-3"><div class="hdr2-4"><div class="hdr2-5"><div class="hdr2-6"><div class="hdr2-last"></div></div></div></div></div></div></div>');
    }

    // search box
    jQuery('div.search-box input').focus(function() { jQuery(this).parents('.search-box').addClass('focus'); }).blur(function() { jQuery(this).parents('.search-box').removeClass('focus'); })

    // header search box
    jQuery('#search-box form').submit(function() { var value = jQuery('#search-box input:text').val(); return (value == laSearchMini || value == '') ? false : true; });
    jQuery('#search-box input:text').focus(function() { 
        if(this.value == laSearchMini) this.value = '';
        jQuery('#search-box').addClass('focused');
    }).blur(function() { 
        if(this.value == '') this.value = laSearchMini;
        jQuery('#search-box').removeClass('focused');
    });

	// shorten long links in posts
	jQuery('a.postlink').each(function() {
		var jQuerythis = jQuery(this);
		
		if (jQuerythis.children().length)
		{
			return;
		}
		
		var html = jQuerythis.html();
		if (html.length > 50 && html.indexOf('://') > 0 && html.indexOf(' ') < 0)
		{
			jQuerythis.html(html.substr(0, 39) + ' ... ' + html.substr(-10));
		}
	});

    // resize big images
    function imageClicked(event)
    {
    	var jQuerythis = jQuery(this);
    	if (jQuerythis.hasClass('zoomed-in'))
		{
			jQuerythis.removeClass('zoomed-in').css('max-width', jQuery(this).attr('data-max-width') + 'px');
		}
		else
		{
			jQuerythis.addClass('zoomed-in').css('max-width', '');
		}
    }
    function zoomClicked(event)
    {
		imageClicked.apply(jQuery(this).prev().get(0), arguments);
		event.stopPropagation();
    }
	function resizeImage(width)
	{
		var jQuerythis = jQuery(this);
		jQuerythis.wrap('<span class="zoom-container" />').attr('data-max-width', width).css({
			'max-width': width + 'px',
			cursor: 'pointer'
			}).addClass('zoom').click(imageClicked).after('<span class="zoom-image" />').next().click(zoomClicked);
	}
    function checkImage()
    {
		var maxWidth = Math.floor(this.parentNode.clientWidth - 10);
		if (this.width > maxWidth)
		{
			resizeImage.call(this, maxWidth);
		}
    }
    jQuery('.postbody img').each(function() {
    	var jQuerythis = jQuery(this);
    	if (jQuerythis.closest('a').length)
    	{
    		return;
		}
		if (this.complete)
		{
			checkImage.call(this);
		}
		else
		{
			jQuerythis.load(checkImage);
		}
	});
    
    // old browser warning
    function hasCookie(search)
    {
        var cookie = document.cookie.split(';');
        search += '=';
        for(var i=0; i<cookie.length; i++)
        {
            var c = cookie[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(search) == 0) return true;
        }
        return false;
    }
    if(oldIE && imagesetLang && !hasCookie('oldie'))
    {
        jQuery('body').prepend('<div id="old-browser" style="display: none;"></div>');
        jQuery('#old-browser').load(imagesetLang + '/oldie.txt', function() { jQuery('#old-browser').slideDown(); });
    }
});

})(jQuery);