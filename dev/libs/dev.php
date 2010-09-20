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

	function autoAssetLinks(){
		pr(getcwd());
		exit;
		$Folder = new Folder(APP.'views'.DS.'themed'.DS);
		$folders = $Folder->read();
		$folders = $folders[0];
		if(!is_dir(getcwd().DS.'theme')){
			$Folder->create(getcwd().DS.'theme', 0755);
		}
		foreach((array)$folders as $folder){
			if(is_dir(APP.'views'.DS.'themed'.DS.$folder.DS.'webroot'.DS) && !is_dir(getcwd().DS.'theme'.DS.$folder.DS)){
				symlink(
					APP.'views'.DS.'themed'.DS.$folder.DS.'webroot'.DS,
					'theme'.DS.$folder
				);
			}
		}
		unset($Folder);

		$plugins = App::objects('plugin');
		foreach($plugins as $plugin){
			if(is_dir(App::pluginPath($plugin).'webroot'.DS) && !is_dir(getcwd().DS.Inflector::underscore($plugin))){
				symlink(
					App::pluginPath($plugin).'webroot'.DS,
					Inflector::underscore($plugin)
				);
			}

		}
	}
