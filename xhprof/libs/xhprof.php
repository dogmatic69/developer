<?php
	if(!defined('XHPROF_FLAGS_MEMORY')){
		define('XHPROF_FLAGS_MEMORY', false);
	}
	if(!defined('XHPROF_FLAGS_NO_BUILTINS')){
		define('XHPROF_FLAGS_NO_BUILTINS', false);
	}
	if(!defined('XHPROF_FLAGS_CPU')){
		define('XHPROF_FLAGS_CPU', false);
	}	

	final class Xhprof{
		public $profileFlags = array(
			XHPROF_FLAGS_MEMORY,      // track memory usage
			XHPROF_FLAGS_NO_BUILTINS, // ignore php methods
			XHPROF_FLAGS_CPU          // track cpu usage
		);

		public $profileCake = false;

		public $ignore = array(

		);

		/**
		 * name of current profile session
		 * @var string
		 */
		private $__session = '';

		/**
		 * started or not
		 * @var bool
		 */
		private $__started = false;

		/**
		 * the xprof data
		 * @var array
		 */
		private $__data = array();

		/**
		 * Is it installed?
		 */
		private $__xhprofInstalled;

		public $cakeFunctions = array(
			'pluginSplit', 'h', '__d', '__', 'getMicrotime', 'main()',

			'ClassRegistry::getInstance', 'ClassRegistry::getObject', 'ClassRegistry::isKeySet', 'ClassRegistry::init',
			'Configure::getInstance', 'Configure::read', 'Configure::write',
			'Dispatcher::dispatch', 'Dispatcher::_invoke',
			'Debugger::handleError', 'Debugger::getInstance',
			'File::exists', 'File::open', 'File::read', 'File::close', 'File::pwd', 'FileEngine::_setKey',
			'Folder::addPathElement', 'Folder::isAbsolute', 'Folder::realpath', 'Folder::cd', 'Folder::pwd', 'Folder::read', 'Folder::__tree', 'Folder::slashTerm', 'Folder::isSlashTerm', 'Folder::__construct', 'Folder::correctSlashFor', 'Folder::isWindowsPath', 'Folder::tree', 'Folder::inPath',
			'Inflector::_cache', 'Inflector::getInstance', 'Inflector::underscore', 'Inflector::camelize', 'Inflector::variable', 'Inflector::humanize',
			'Set::diff', 'Set::reverse',

			'DboSource::length', 'DboSource::cacheMethod', 'DboSource::hasResult', 'DboSource::fetchVirtualField', 'DboSource::name', 'DboSource::fetchAll', 'DboMysql::resultSet',
			'DboMysql::fetchResult', 'DboMysqlBase::column', 'DboMysql::_execute', 'DboMysqlBase::describe', 
			'ConnectionManager::getInstance', 'ConnectionManager::getDataSource',

			'App::__load', 'App::getInstance', 'App::__settings', 'App::import', 'App::__mapped', 'App::__paths', 'App::__map', 'App::__overload', 'App::__find',
			'Cache::getInstance', 'Cache::settings', 'CacheEngine::settings', 'Cache::isInitialized', 'Cache::set', 'Cache::read', 'CacheEngine::key', 'Cache::write',
			'CakeRoute::compiled', 'CakeRoute::match',
			'Router::getInstance', 'Router::url',

			'AppHelper::__construct',
			'FormHelper::create', 'FormHelper::hidden',
			'HtmlHelper::tableCells',

			'BehaviorCollection::init',

			'Object::__construct',

			'Helper::_parseAttributes', 'Helper::__formatAttribute', 'Helper::afterRender', 'Helper::setEntity', 'Helper::domId', 'Helper::tagIsInvalid', 'Helper::model',
			'I18n::getInstance', 'I18n::translate',
			'View::_loadHelpers', 'View::renderLayout',
			'Model::__construct',
			'Overloadable::__call',
			'Controller::constructClasses',
			'ModelBehavior::dispatchMethod',
			'BehaviorCollection::attach',
			'NumberHelper::precision'
		);

		/**
		 * Stop cloning
		 */
		private function __clone() {}

		private function __construct(){}

		/**
		 * Get an instance.
		 *
		 * nothing fancy here, get a singleton and if it is the first instance
		 * set some vars like the start time etc.
		 */
		public static function getInstance() {
			static $instance = array();
			if (!$instance){
				Configure::load('xhprof.config');
				$instance[0] = new Xhprof();
				$instance[0]->__xhprofInstalled =
					function_exists('xhprof_enable') &
					(bool)(XHPROF_FLAGS_MEMORY && XHPROF_FLAGS_NO_BUILTINS && XHPROF_FLAGS_CPU);
			}
			return $instance[0];

		}

		/**
		 * Starts profiling
		 * @param string $session
		 * @return bool
		 */
		public function start($session = null){
			$_this =& Xhprof::getInstance();

			if(!$session || empty($session) || !is_string($session)){
				$session = str_replace('/', '_', env('SERVER_NAME').env('REQUEST_URI'));
			}

			if(!$_this->__xhprofInstalled){
				$this->errors[] = 'xhprof does not seem to be installed';
				return false;
			}
			
			if($_this->__started === true){
				$_this->errors[] = sprintf('xprof is already started :: %s', $_this->__session);
				return false;
			}
			
			$_this->__session = $session;

			$ignore = array();
			if(!$_this->profileCake){
				$ignore = $_this->cakeFunctions;
			}
			$ignore = array_merge($ignore, $_this->ignore);			

			xhprof_enable(
				array_sum((array)$_this->profileFlags),
				array(
					'ignored_functions' =>  $ignore
				)
			);
			$_this->__started = true;
			return true;
		}

		public function stop(){
			$_this =& Xhprof::getInstance();
			if(!$_this->__started){
				$this->errors[] = 'xprof is not started';
				return false;
			}
			
			$this->__started = false;

			$_this->__data = xhprof_disable();
			return $_this->__write();
		}

		public function runs(){
			$_this =& Xhprof::getInstance();

			if($_this->__started && $_this->stop()){
				$_this->__started = false;
			}
			else{
				$_this->errors[] = 'not started';
				return false;
			}

			if(empty($_this->runs)){
				$_this->errors[] = 'No runs started';
				return false;
			}

			$links = array();
			foreach($_this->runs as $name => $run){
				if(Configure::read('debug')){
					$links[] = '<a href="'.Configure::read('Xhprof.url').'index.php?run='.$run.'&source='.$name.'" target="_blank">'.str_replace('_', '/', $name).'</a>';
					continue;
				}

				//$Object->log($name.': '.Configure::read('Developer.Xhprof.url').'index.php?run='.$run.'&source='.$name, 'xhprof');
			}

			if(!empty($links)){
				echo implode('<br/>', $links);
			}
		}

		private function __write(){
			$_this =& Xhprof::getInstance();
			$Xhprof = new XHProfRuns_Default();

			$_this->runs[$this->__session] = $Xhprof->save_run($this->__data, $this->__session, str_replace('.', '_', microtime(true)));
			unset($Xhprof, $this->__data, $this->__session);
			
			return !empty($_this->runs);
		}
	}
