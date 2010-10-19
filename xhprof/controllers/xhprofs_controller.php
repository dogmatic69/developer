<?php
	/*
	 * Controller to view profiles by xhprof
	 *
	 * Copyright (c) 2010 Carl Sutton ( dogmatic69 )
	 *
	 * @filesource
	 * @copyright Copyright (c) 2010 Carl Sutton ( dogmatic69 )
	 * @link http://www.infinitas-cms.org
	 * @package developer
	 * @subpackage developer.xhprof
	 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
	 * @since o.1
	 *
	 * @author dogmatic69
	 *
	 * Licensed under The MIT License
	 * Redistributions of files must retain the above copyright notice.
	 */

	class XhprofsController extends XhprofAppController {
		public $name = 'Xhprofs';

		public $uses = array();

		public $helpers = array(
			'Filter.Filter'
		);

		public $xhprofSessions = array();
		public $xhprofData = array();

		public function beforeFilter() {
			parent::beforeFilter();

			$this->Folder = new Folder(Configure::read('Xhprof.output'));
			$files = $this->Folder->read();
			
			foreach($files[1] as $file) {
				$data = explode('.', $file, 2);
				$this->xhprofData[]['Xhprof'] = array(
					'session' => $data[1],
					'time' => $data[0]
				);

				$this->xhprofSessions[$data[1]] = Inflector::humanize($data[1]);
			}
		}

		public function admin_index() {
			$filterOptions = $this->Filter->filterOptions;
			$filterOptions['fields'] = array(
				'xhprof_session' => $this->xhprofSessions
			);

			$this->set('filterOptions', $filterOptions);
			$this->set('xhprofData', $this->xhprofData);
		}

		public function admin_view($id = null){
			
			if(!$id || !is_file(Configure::read('Developer.Xhprof.output').$id)){
				$this->Session->setFlash(__('Invalid Xhprof session selected', true));
				$this->redirect($this->referer());
			}

			App::import('Lib', 'Developer.XhprofDisplay', array('file' => 'xhprof/xhprof_display.php'));
			App::import('Lib', 'Developer.XhprofLib', array('file' => 'xhprof/xhprof_lib.php'));
			App::import('Lib', 'Developer.CallgraphUtils', array('file' => 'xhprof/callgraph_utils.php'));
			App::import('Lib', 'Developer.XhprofRuns', array('file' => 'xhprof/xhprof_runs.php'));

			$parts = explode('.', $id);
			$parts[0] = str_replace('_', '.', $parts[0]);

			var_dump(XHPROF_STRING_PARAM);
			$params = array(
				'run'        => array(XHPROF_STRING_PARAM, ''),
                'wts'        => array(XHPROF_STRING_PARAM, ''),
                'symbol'     => array(XHPROF_STRING_PARAM, ''),
                'sort'       => array(XHPROF_STRING_PARAM, 'wt'), // wall time
                'run1'       => array(XHPROF_STRING_PARAM, ''),
                'run2'       => array(XHPROF_STRING_PARAM, ''),
                'source'     => array(XHPROF_STRING_PARAM, 'xhprof'),
                'all'        => array(XHPROF_UINT_PARAM, 0),
			);

			global $sortable_columns;
			$sortable_columns = array(1);
			// pull values of these params, and create named globals for each param
			xhprof_param_init($params);

			$vbar  = ' class="vbar"';
			$vwbar = ' class="vwbar"';
			$vwlbar = ' class="vwlbar"';
			$vbbar = ' class="vbbar"';
			$vrbar = ' class="vrbar"';
			$vgbar = ' class="vgbar"';			

			displayXHProfReport(
				new XHProfRuns_Default(),
				$params,
				'xhprof',
				$id,
				'', //$params['wts'],
				$parts[1], //$params['symbol'],
				$params['sort'],
				$params['run1'],
				$params['run2']
			);
			
			/*$run_desc = '';
			$XHProfRuns_Default = new XHProfRuns_Default();
			$xhprof_data = $XHProfRuns_Default->get_run(
				$parts[0],
				$parts[1],
				&$run_desc
			);

			profiler_single_run_report(
				$params,
				$xhprof_data,
				$run_desc,
				'', //$symbol,
				'',
				$parts[0]
			);*/
			exit;
		}
	}
