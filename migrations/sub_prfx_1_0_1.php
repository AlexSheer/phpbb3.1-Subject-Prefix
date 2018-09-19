<?php
/**
*
* @package phpBB Extension - Subject prefix
* @copyright (c) 2015 Sheer
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace sheer\sub_prfx\migrations;

class sub_prfx_1_0_1 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['sub_prfx_version']) && version_compare($this->config['sub_prfx_version'], '1.0.1', '>=');
	}

	static public function depends_on()
	{
		return array('\sheer\sub_prfx\migrations\sub_prfx_1_0_0');
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
			array('config.update', array('sub_prfx_version', '1.0.1')),
			array('config.remove', array('sub_prfx_forums', '')),
			array('config_text.add', array('sub_prfx_forums', '')),
		);
	}
}