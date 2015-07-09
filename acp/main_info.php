<?php
/**
*
* @package phpBB Extension - Subject prefix
* @copyright (c) 2015 Sheer
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace sheer\sub_prfx\acp;

class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\sheer\sub_prfx\acp\main_module',
			'version'	=> '1.0.0',
			'title' => 'ACP_SUB_PREFIX',
			'modes'		=> array(
				'settings'	=> array(
					'title' => 'ACP_SUB_PREFIX_MANAGE',
					'auth' => 'ext_sheer/sub_prfx && acl_a_board',
					'cat' => array('ACP_SUB_PREFIX')
				),
			),
		);
	}
}
