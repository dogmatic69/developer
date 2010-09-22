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