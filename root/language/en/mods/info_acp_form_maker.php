<?php
/**
 * Form template generator
 * @package form_maker
 * @link http://www.phpbbireland.com
 * @author phpbbireland@gmail.com
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 1.0.0
 */


/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

// Create the lang array if it does not already exist
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// Merge the following language entries into the lang array
$lang = array_merge($lang, array(
	'ACP_FORM_MAKER'              => 'Form Maker',
	'ACP_CAT_FORM_MAKER'          => 'Form Maker',
	'ACP_CAT_FORM_MAKER_EXPLAIN'  => 'Here you manage your forms. ',
	'ACP_FORM_MAKER'              => 'phpBB Form Creator',
	'ACP_FORM_MAKER_CONFIG'       => 'Form Maker Config',
	'acl_a_form_maker'            => array('lang' => 'Can manage Form Maker', 'cat' => 'posting'),
));

?>