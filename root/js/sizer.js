<script type="text/JavaScript">
	/***
	*  Copyright phpbbireland 2008 (Michaelo)
	*  Automatically correct css tags based on the width of the browser window.
	*  This will correct stretching when post contain the (code=php) bbcode in portal and viewtopics pages.
	*
	*  This code will be replaced with automatic calculation later...
	***/

	/* not all that familiar with javascript so... remove 'px' from BLOCK_WIDTH */
	/*
	var temp = '{BLOCK_WIDTH}';
	var portal_block_width = temp[0] + temp[1] + temp[2];
	var phpbb_const = 275;
	*/

	var size = 0;

	/* get width of browser windows */
	var page_width = window.innerWidth != null ? window.innerWidth : document.documentElement && document.documentElement.clientWidth ? document.documentElement.clientWidth : document.body != null ? document.body.clientWidth : null;

	/* approximate the width for tags that will stretch and set them... that is, protect viewtopics from stretching and portal page */
	if(page_width < 801) size = 350;
	else
	if(page_width < 1025) size = 550;
	else
	if(page_width < 1281) size = 795;
	else
	if(page_width < 1481) size = 845;
	else
	if(page_width > 1281) size = 1200;

    document.write('<style type="text/css">dl.codebox { width:auto; max-width:'+size+'px; overflow:auto; }</style>');
	//document.write('<style type="text/css">.news { width:auto; max-width:'+(size)+'px;  }</style>');
</script>