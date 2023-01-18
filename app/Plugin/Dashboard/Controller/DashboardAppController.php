<?php
/**
 * XLRstats : Real Time Player Stats (http://www.xlrstats.com)
 * (CC) BY-NC-SA 2005-2013, Mark Weirath, Özgür Uysal
 *
 * Licensed under the Creative Commons BY-NC-SA 3.0 License
 * Redistributions of files must retain the above copyright notice.
 *
 * @link          http://www.xlrstats.com
 * @license       Creative Commons BY-NC-SA 3.0 License (http://creativecommons.org/licenses/by-nc-sa/3.0/)
 * @package       app.Plugin.Dashboard.Controller
 * @since         XLRstats v3.0
 * @version       0.1
 */

App::uses('AppController', 'Controller');
App::uses('AuthComponent', 'Controller/Component');

// make dashboard use debug so we have less problems with the cache after making changes
Configure::write('debug', 2);

/**
 * Class DashboardAppController
 */
class DashboardAppController extends AppController {

/**
 * Executes logic before action
 */
	public function beforeFilter() {
		/*
		 * We do not use the default layout name 'default' for dashboard plugin so that we can use application's
		 * default layout when necessary.
		 */
		$this->layout = 'Dashboard.dashboard';

		parent::beforeFilter();

		// Disable DebugKit for others than Super Admins
		if (AuthComponent::user('group_id') != '1') {
			$this->Components->unload('DebugKit.Toolbar');
		}
	}
}
