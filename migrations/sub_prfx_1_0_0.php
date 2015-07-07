<?php
/**
*
* @package phpBB Extension - Subject prefix
* @copyright (c) 2015 Sheer
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace sheer\sub_prfx\migrations;

class sub_prfx_1_0_0 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return;
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\dev');
	}

	public function update_schema()
	{
		return array(
		);
	}

	public function revert_schema()
	{
		return array(
		);
	}

	public function update_data()
	{
		return array(
			// Current version
			array('config.add', array('sub_prfx_version', '1.0.0')),
			array('config.add', array('sub_prfx_forums', '')),
			array('config_text.add', array('sub_prfx', '')),
			array('config_text.add', array('sub_prfx_second', '')),
			// ACP
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_SUB_PREFIX')),
			array('module.add', array('acp', 'ACP_SUB_PREFIX', array(
				'module_basename'	=> '\sheer\sub_prfx\acp\main_module',
				'module_langname'	=> 'ACP_SUB_PREFIX_MANAGE',
				'module_mode'		=> 'manage',
				'module_auth'		=> 'ext_sheer/sub_prfx && acl_a_board',
			))),
		);
	}
}