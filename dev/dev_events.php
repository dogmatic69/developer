<?php
	/**
	 * events for random bits of code that can help you out with development
	 * 
	 * Copyright (c) 2010 Carl Sutton ( dogmatic69 )
	 * 
	 * @filesource
	 * @copyright Copyright (c) 2010 Carl Sutton ( dogmatic69 )
	 * @link http://www.infinitas-cms.org
	 * @package Developer.dev
	 * @subpackage Developer.dev.events
	 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
	 * @since 0.1
	 * 
	 * @author dogmatic69
	 * 
	 * Licensed under The MIT License
	 * Redistributions of files must retain the above copyright notice.
	 */

	class DevEvents extends AppEvents{
		public function onRequestDone(){
			/**
			 * dump an array of data from Apc to see what is going on
			 */
			//outputApcData();
			return;
			$DB = ConnectionManager::getDataSource('default');
			$skip = array(
				'SHOW FULL COLUMNS FROM',
				'SELECT CHARACTER_SET_NAME'
			);
			$profiles = array();
			foreach($DB->query('show profiles;') as $k => $profile){
				$explain = true;
				foreach($skip as $miss){
					$explain &= !strstr($profile[0]['Query'], $miss);
				}
				if(!isset($profile[0]['Query']) || !$explain){
					continue;
				}
				pr($profile[0]);
				$profiles[] = array_merge(
					$profile[0],
					array(
						'profile' => $DB->query(sprintf('show profile for query %s;', $profile[0]['Query_ID'])),
						'explain' => $DB->query(sprintf('EXPLAIN %s;', $profile[0]['Query']))
					)
				);
			}
			echo '<div style="background:#ffffff";><table><tr>
				<th>ID</th>
				<th colspan="7">Query</th>
				<th style="width:100px;">Status</th>
				<th style="width:100px;">Duration</th></tr>';
			foreach($profiles as $profile){
				echo '<tr style="border-top:1px solid;">
					<td>', $profile['Query_ID'], '</td>
					<td colspan="7">', $profile['Query'], '</td>
					<td>Total: </td><td>', $profile['Duration'], '</td></tr>';
				foreach((array)$profile['explain'] as $explain) {
					$_extra = '<table>';
					foreach($profile['profile'] as $_p){
						$_extra .= '<tr><td>'.$_p['PROFILING']['Status'].'</td><td>'.$_p['PROFILING']['Duration'].'</td></tr>';
					}
					$_extra .= '</table>';
					echo '<tr>
						<td>', $explain[0]['select_type'], '&nbsp;</td>
						<td>', $explain[0]['table'], '&nbsp;</td>
						<td>', $explain[0]['type'], '&nbsp;</td>
						<td>', $explain[0]['possible_keys'], '&nbsp;</td>
						<td>', $explain[0]['key'], ' (', $explain[0]['key_len'], ')&nbsp;</td>
						<td>', $explain[0]['ref'], '</td><td>', $explain[0]['rows'],'&nbsp;</td>
						<td>', $explain[0]['Extra'], '&nbsp;</td>
						<td colspan="5">', $_extra, '</td>
					</tr>';
				}
			}
			echo '</table></div>';
		}

		public function onAttachBehaviors(&$event){
			if(is_subclass_of($event->Handler, 'Model') && isset($event->Handler->_schema) && is_array($event->Handler->_schema)) {
				$event->Handler->Behaviors->attach('Dev.Dev');
			}
		}
	}

	function outputApcData(){
		$data = array();
		if(function_exists('apc_cache_info')){
			$data = apc_cache_info();
		}

		$tds = str_repeat('<td>%s</td>', count($data['cache_list'][0]));
		echo '<table>'.call_user_func_array('sprintf', array('a' => '<tr>'.$tds.'</tr>') + array_keys($data['cache_list'][0]));
		foreach($data['cache_list'] as $cache){
			echo call_user_func_array('sprintf', array('<tr>'.$tds.'</tr>') + $cache);
		}
		echo '</table>';
	}