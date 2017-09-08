<?php
/**
*
* info_sub_prfx [English]
*
* @package phpBB Extension - Add Extra Links
* @copyright (c) 2015 Sheer
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* @ignore
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

$lang = array_merge($lang, array(
	'ACP_SUB_PREFIX'			=> 'Subject Prefix',
	'ACP_SUB_PREFIX_EXPLAIN'	=> 'Here you can change extension\'s settings.',
	'ACP_SUB_PREFIX_MANAGE'		=> 'Manage',
	'FORUMS_EXPLAIN'			=> 'Forums, which will be available to choose prefix',
	'UPDATE_CONFIG_SUCCESS'		=> 'Settings were saved successfully.',
	'PREFIXES'					=> 'Prefixes',
	'PREFIX_NAME'				=> 'Prefix'
));
