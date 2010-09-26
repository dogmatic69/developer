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

	class DevBehavior extends ModelBehavior{
		public function beforeFind($Model, $query){
			$Model->query('set profiling=1;');
			return parent::beforeFind($Model, $query);
		}

		public function afterFind($Model, $results, $primary){
			$Model->query('set profiling=0;');
			return parent::afterFind($Model, $results, $primary);
		}

		public function beforeDelete($Model, $cascade){
			$Model->query('set profiling=1;');
			return parent::beforeDelete($Model, $cascade);
		}

		public function afterDelete($Model){
			$Model->query('set profiling=0;');
			return parent::afterDelete($Model);
		}

		public function beforeSave($Model){
			$Model->query('set profiling=1;');
			return parent::beforeSave($Model);
		}

		public function AfterSave($Model, $created){
			$Model->query('set profiling=0;');
			return parent::afterSave($Model, $created);
		}
	}