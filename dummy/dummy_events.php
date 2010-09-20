<?php
	/* 
	 * Short Description / title.
	 * 
	 * Overview of what the file does. About a paragraph or two
	 * 
	 * Copyright (c) 2010 Carl Sutton ( dogmatic69 )
	 * 
	 * @filesource
	 * @copyright Copyright (c) 2010 Carl Sutton ( dogmatic69 )
	 * @link http://www.infinitas-cms.org
	 * @package {see_below}
	 * @subpackage {see_below}
	 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
	 * @since {check_current_milestone_in_lighthouse}
	 * 
	 * @author {your_name}
	 * 
	 * Licensed under The MIT License
	 * Redistributions of files must retain the above copyright notice.
	 */

	class DummyEvents extends AppEvents{
		public function onPluginRollCall(){
			return array(
				'name' => 'Dummy Data',
				'description' => 'Generate random test data that makes sence',
				'icon' => '/dummy/img/icon.png',
				'author' => 'Infinitas',
				'dashboard' => array('plugin' => 'dummy', 'controller' => 'dummy_tables', 'action' => 'index'),
			);
		}

		public function onAdminMenu(&$event){
			$id = isset($event->Handler->params['pass'][0]) ? $event->Handler->params['pass'][0] : '';

			$menu['main']['Dashboard'] = array('plugin' => 'dummy', 'controller' => 'dummy_tables', 'action' => 'index');
			switch($event->Handler->params['controller']){
				case 'dummy_fields':
					$menu['main']['Generate Data']     = array('plugin' => 'dummy', 'controller' => 'dummy_tables', 'action' => 'generate', $id);
					$menu['main']['Re-analyze Table'] = array('plugin' => 'dummy', 'controller' => 'dummy_tables', 'action' => 'analyze', $id);
					$menu['main']['Truncate']         = array('plugin' => 'dummy', 'controller' => 'dummy_tables', 'action' => 'truncate', $id);
					break;

				default:
					$menu['main']['Generate All']   = array('plugin' => 'dummy', 'controller' => 'dummy_tables', 'action' => 'generate_all');
					$menu['main']['Re-analyze All'] = array('plugin' => 'dummy', 'controller' => 'dummy_tables', 'action' => 'analyze_all');
					break;
			}

			return $menu;
		}
	}