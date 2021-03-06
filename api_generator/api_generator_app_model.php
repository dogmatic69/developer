<?php
/**
 * ApiGenerator App Model class
 *
 * Base model class for models in ApiGenerator
 *
 * PHP 5.2+
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2008-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2008-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org
 * @package       api_generator
 * @subpackage    
 * @since         ApiGenerator 0.1
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 **/
ConnectionManager::create(
	'infinitasapi',
	array(
		'driver' => 'mysqli',
		'persistent' => true,
		'host' => 'localhost',
		'login' => 'infinitas_api',
		'password' => 'infinitas_api',
		'database' => 'infinitas_api',
		'prefix' => '',
		'port' => '',
		'encoding' => 'utf8'
	)
);

class ApiGeneratorAppModel extends AppModel {
	public $useDbConfig = 'infinitasapi';
/**
 * Inflect a slashed path to url safe path. Trims ApiGenerator.filePath off as well.
 *
 * @param string $slashPath The slashed path to slug.
 * @return string
 **/
	public function slugPath($slashPath, $stripBase = true) {
		if ($stripBase) {
			$basePath = Configure::read('ApiGenerator.filePath');
			$slashPath = trim($slashPath, $basePath);
		}
		$slugPath = strtolower(Inflector::slug($slashPath, '-'));
		return $slugPath;
	}
/**
 * Make a slug
 *
 * @param string $name Make a slug
 * @return string
 **/
	protected function _makeSlug($name) {
		return str_replace('_', '-', Inflector::underscore($name));
	}

}
