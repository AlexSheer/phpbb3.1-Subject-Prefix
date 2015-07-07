<?php
/**
*
* @package phpBB Extension - Subject prefix
* @copyright (c) 2015 Sheer
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace sheer\sub_prfx\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
/**
* Assign functions defined in this class to event listeners in the core
*
* @return array
* @static
* @access public
*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'							=> 'load_language_on_setup',
			'core.posting_modify_submit_post_before'	=> 'modify_subject',
			'core.posting_modify_template_vars'			=> 'edit_subject',
		);
	}

	/** @var \phpbb	emplate	emplate */
	protected $template;

	//** @var string phpbb_root_path */
	protected $phpbb_root_path;

	/** @var \phpbb\request\request_interface */
	protected $request;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\config\db_text */
	protected $config_text;

	/** @var \phpbb\user\user */
	protected $user;

	/**
	* Constructor
	*/
	public function __construct(
		$phpbb_root_path,
		\phpbb\template\template $template,
		\phpbb\request\request_interface $request,
		\phpbb\config\config $config,
		\phpbb\config\db_text $config_text,
		\phpbb\user $user
	)
	{
		$this->phpbb_root_path = $phpbb_root_path;
		$this->template = $template;
		$this->request = $request;
		$this->config = $config;
		$this->user = $user;
		$this->config_text = $config_text;
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'sheer/sub_prfx',
			'lang_set' => 'sub_prfx',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function modify_subject($event)
	{
		$post_data = $event['post_data'];
		$forums = explode(',', $this->config['sub_prfx_forums']);
		if(!isset($event['post_data']['topic_id']) && in_array($event['post_data']['forum_id'], $forums))
		{
			$prefix =			$this->request->variable('subprfx', 0);
			$prefix_second =	$this->request->variable('subprfx_second', 0);

			$options = $options_second = array(0 => $this->user->lang['SELECT']);
			$options =			array_merge($options, explode(',', (string) $this->config_text->get('sub_prfx')));
			$options_second =	array_merge($options_second, explode(',', (string) $this->config_text->get('sub_prfx_second')));

			if($prefix)
			{
				$second = '';
				if($prefix_second)
				{
					$second = '['.$options_second[$prefix_second] . ']';
				}
				$post_data['post_subject'] = '['. $options[$prefix] . ']' . $second.$event['post_data']['post_subject'];
				$event['post_data'] = $post_data;
			}
		}
	}

	public function edit_subject($event)
	{
		$forums = explode(',', $this->config['sub_prfx_forums']);
		if (in_array($event['forum_id'], $forums) && !$event['topic_id'])
		{
			$prefix =			$this->request->variable('subprfx', 0);
			$subprfx_second =	$this->request->variable('subprfx_second', 0);

			$options = $options_second = array(0 => $this->user->lang['SELECT']);
			$options =			array_merge($options, explode(',', (string) $this->config_text->get('sub_prfx')));
			$options_second =	array_merge($options_second, explode(',', (string) $this->config_text->get('sub_prfx_second')));

			$select = '';
			if($options[1])
			{
				foreach($options as $key => $value)
				{
					$select .= '<option value="' . $key . '"' . (($key == $prefix) ? ' selected="selected"' : '') . '>' . $value . '</option>';
				}
			}

			$select_second = '';
			if($options_second[1])
			{
				foreach($options_second as $key => $value)
				{
					$select_second .= '<option value="' . $key . '"' . (($key == $subprfx_second) ? ' selected="selected"' : '') . '>' . $value . '</option>';
				}
			}

			$this->template->assign_vars(array(
				'S_SELECT'			=> $select,
				'S_SELECT_SECOND'	=> $select_second,
			));
		}
	}
}
