<?php
/**
*
* @package phpBB Extension - Subject prefix
* @copyright (c) 2015 Sheer
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace sheer\sub_prfx\acp;

class main_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $user, $template, $request, $phpbb_container;

		$this->page_title = $user->lang('ACP_SUB_PREFIX');
		$this->tpl_name = 'acp_sub_prfx_body';

		$config_text = $phpbb_container->get('config_text');

		$prefixes		= $config_text->get('sub_prfx');
		$prefixes		= ($prefixes) ? explode(',', $prefixes) : array();

		$prefixes_second		= $config_text->get('sub_prfx_second');
		$prefixes_second		= ($prefixes_second) ? explode(',', $prefixes_second) : array();

		$forums			= $config_text->get('sub_prfx_forums');
		$forums			= ($forums) ? explode(',', $forums) : array(0);

		$exclude_forums		= $request->variable('forum_id', $forums);
		$action				= $request->variable('action', '');
		$prefixes_ary		= $request->variable('prefixes', $prefixes, true);
		$prefixes_second_ary= $request->variable('prefixes_second', $prefixes_second, true);
		$prefix_name		= $request->variable('prefix_name', '', true);
		$prefix_second_name	= $request->variable('prefix_name_second', '', true);
		$delete				= $request->variable('del', 0);

		if ($action == 'delete')
		{
			unset($prefixes[$delete]);
			$prefixes = implode(',', $prefixes);
			$config_text->set('sub_prfx', $prefixes);
			meta_refresh(3, append_sid($this->u_action));
			trigger_error($user->lang['UPDATE_CONFIG_SUCCESS'] . adm_back_link($this->u_action));
		}

		if ($action == 'delete_second')
		{
			unset($prefixes_second[$delete]);
			$prefixes_second = implode(',', $prefixes_second);
			$config_text->set('sub_prfx_second', $prefixes_second);
			meta_refresh(3, append_sid($this->u_action));
			trigger_error($user->lang['UPDATE_CONFIG_SUCCESS'] . adm_back_link($this->u_action));
		}

		$forum_list		= make_forum_select(false, false, true, true, true, false, true);
		$s_forum_options = '';
		foreach($forum_list as $key => $value)
		{
			$selected = (in_array($value['forum_id'], $forums)) ? true : false;
			$s_forum_options .='<option value="' . $value['forum_id'] . '"' . (($selected) ? ' selected="selected"' : '') . (($value['disabled']) ? ' disabled="disabled" class="disabled-option"' : '') . '>' . $value['padding'] . $value['forum_name'] . '</option>';
		}

		$template->assign_vars(array(
			'S_SELECT_FORUM'		=> true,
			'S_FORUM_OPTIONS'		=> $s_forum_options,
			'PREFIX_NAME'			=> $prefix_name,
			)
		);

		foreach($prefixes as $key => $value)
		{
			$template->assign_block_vars('prefixes', array(
				'KEY'			=> $key,
				'PREFIX'		=> $value,
				'U_DELETE'		=> $this->u_action . '&amp;action=delete&amp;del=' .$key. '',
				)
			);
		}

		foreach($prefixes_second as $key => $value)
		{
			$template->assign_block_vars('prefixes_second', array(
				'KEY'			=> $key,
				'PREFIX'		=> $value,
				'U_DELETE'		=> $this->u_action . '&amp;action=delete_second&amp;del=' .$key. '',
				)
			);
		}

		add_form_key('sheer/sub_prfx');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('sheer/sub_prfx'))
			{
				trigger_error('FORM_INVALID');
			}
			$config_text->set('sub_prfx_forums', implode(',', $exclude_forums));

			$prefixes_ary = implode(',', $prefixes_ary);
			if ($prefix_name)
			{
				if($prefixes_ary)
				{
					$prefixes_ary .= ',' . $prefix_name;
				}
				else
				{
					$prefixes_ary = $prefix_name;
				}
			}
			$prefixes_second_ary = implode(',', $prefixes_second_ary);
			if ($prefix_second_name)
			{
				if($prefixes_second_ary)
				{
					$prefixes_second_ary .= ',' . $prefix_second_name;
				}
				else
				{
					$prefixes_second_ary = $prefix_second_name;
				}
			}
			$config_text->set('sub_prfx', $prefixes_ary);
			$config_text->set('sub_prfx_second', $prefixes_second_ary);

			meta_refresh(3, append_sid($this->u_action));
			trigger_error($user->lang['UPDATE_CONFIG_SUCCESS'] . adm_back_link($this->u_action));
		}
	}
}
