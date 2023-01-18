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

App::uses('UsersController', 'Users.Controller');
App::uses('AuthComponent', 'Controller/Component');

// make dashboard use debug so we have less problems with the cache after making changes
Configure::write('debug', 2);

/**
 * Class AppUsersController
 */
class AppUsersController extends UsersController {

/**
 * Name
 *
 * @var string
 */
	public $name = 'AppUsers';

/**
 * Components
 *
 * @var array
 */
	public $components = array(
		'RequestHandler',
		'Session',
		'Cookie',
		'Paginator',
		'Security',
		'Search.Prg',
		'Users.RememberMe',
		'DataTable',
	);

	//-------------------------------------------------------------------

/**
 * Executes logic before action
 */
	public function beforeFilter() {
		parent::beforeFilter();

		// Disable DebugKit for others than Super Admins
		if (AuthComponent::user('group_id') != '1') {
			$this->Components->unload('DebugKit.Toolbar');
		}

		// Change the layout for users plugin to default Dashboard layout

		if ($this->isAuthorized()) {
			$this->layout = 'Dashboard.dashboard';
		}

		$this->User = ClassRegistry::init('Dashboard.AppUser'); //Use extended model AppUser
		$this->set('model', 'AppUser');
	}

	//-------------------------------------------------------------------

/**
 * Override the _setupAuth() from the Users Plugin
 */
	protected function _setupAuth() {
		if (!is_null(Configure::read('Users.allowRegistration')) && !Configure::read('Users.allowRegistration')) {
			$this->Auth->deny('add');
		}
		if ($this->request->action == 'register') {
			$this->Components->disable('Auth');
		}

		$this->Auth->authenticate = array(
			'Form' => array(
				'fields' => array(
					'username' => 'email',
					'password' => 'password'),
				'userModel' => 'Dashboard.AppUser',
				'scope' => array(
					'AppUser.active' => 1,
					'AppUser.email_verified' => 1)));

		$this->Auth->loginRedirect = array('admin' => false, 'plugin' => null, 'controller' => 'pages', 'action' => 'display', 'server' => Configure::read('server_id'));
		$this->Auth->logoutRedirect = array('admin' => false, 'plugin' => null, 'controller' => 'pages', 'action' => 'display', 'server' => Configure::read('server_id'));
	}

	//-------------------------------------------------------------------

/**
 * User Profile action
 *
 * @return void
 */
	public function edit() {
		$this->layout = 'default';
		if (!$this->user) {
			$this->Session->setFlash(__d('users', 'Hey buddy, you need to login first!'));
			$this->redirect(array(
				'controller' => 'app_users',
				'action' => 'login'
			));
		}
		parent::edit();
	}

	//-------------------------------------------------------------------

/**
 * User register action
 *
 * @return void
 */
	public function add() {
		$this->layout = 'Dashboard.user';

		if ($this->Auth->user()) {
			$this->Session->setFlash(__d('users', 'You are already registered and logged in!'));
			$this->redirect('/');
		}

		if (!empty($this->request->data)) {
			if (Configure::read('globals.advanced.subDomains')) {
				$this->request->data['ServerGroup']['ServerGroup'] = $this->Session->read('server_group_id');
			} else {
				$this->request->data['ServerGroup']['ServerGroup'] = 1;
			}

			$user = $this->User->register($this->request->data);
			if ($user !== false) {
				$this->_sendVerificationEmail($this->User->data);
				$this->Session->setFlash(__d('users', 'Your account has been created. You should receive an e-mail shortly to authenticate your account. Once validated you will be able to login.'));
				$this->redirect(array('action' => 'login'));
			} else {
				unset($this->request->data[$this->modelClass]['password']);
				unset($this->request->data[$this->modelClass]['temppassword']);
				$this->Session->setFlash(__d('users', 'Your account could not be created. Please, try again.'), 'default', array('class' => 'message warning'));
			}
		}
	}

	//-------------------------------------------------------------------

/**
 * Admin Index
 *
 * Lists users via dataTables handled admin_indexJson()
 */
	public function admin_index() {
	}

	//-------------------------------------------------------------------

/**
 * Returns an array of users and pass data to plugin view file at
 * Users/json/admin_index_json.ctp to be processed by dataTables.
 *
 * If subDomain option is set to true in global config, subdomain admins can list only users
 * belong to the subdomain.
 *
 * Super Admins can list all users.
 *
 * Sample data returned:
 * Array
 * (
 *      [sEcho] => 1
 *      [iTotalRecords] => 38
 *      [iTotalDisplayRecords] => 38
 *      [aaData] => Array
 *          (
 *              [0] => Array
 *                  (
 *                      [0] => 1                        // User Id
 *                      [1] => superuser                // Name
 *                      [2] => Super Admin              // Group Name
 *                      [3] => superuser@example.com    // Email
 *                      [4] => 1                        // Email Verified
 *                      [5] => 1                        // Active
 *                      [6] => 2013-03-30 19:38:12      // Joined
 *                      [7] => 2013-10-27 14:41:24      // Last Login
 *                      [8] =>                          // Empty field for action buttons
 *                  )
 *          )
 * )
 *
 * @return mixed
 */
	public function admin_indexJson() {
		$options = array(
			'fields' => array(
				'AppUser.id',
				'AppUser.username',
				'Group.name',
				'AppUser.email',
				'AppUser.email_verified',
				'AppUser.active',
				'AppUser.created',
				'AppUser.last_login',
			)
		);

		if (Configure::read('globals.advanced.subDomains') && $this->user['Group']['level'] < 100) {
			$options['joins'] = array(
				array('table' => 'server_groups_users',
					'alias' => 'ServerGroupUsers',
					'type' => 'INNER',
					'conditions' => array(
						'ServerGroupUsers.server_group_id' => $this->Session->read('server_group_id'),
						'ServerGroupUsers.user_id = AppUser.id'
					)
				)
			);
			$options['group'] = array('group' => 'AppUser.id');
		}

		$this->paginate = $options;

		$this->DataTable->emptyElements = 1;
		$data = $this->DataTable->getResponse('AppUser');
		//pr($data);

		if ($this->request->is('requested')) {
			return $data;
		} else {
			$this->set('users', $data);
		}
		return null;
	}

	//-------------------------------------------------------------------

/**
 * Admin add
 *
 * If the user is an admin, new users are assigned a server group id automatically. When subDomain is set to true,
 * this is the current server group id. In a normal installation, this is the default server group id which is "1".
 *
 * Super Admins can choose the server group when adding new users.
 *
 * @return void
 */
	public function admin_add() {
		if (!empty($this->request->data)) {
			$this->request->data['AppUser']['tos'] = true;
			$this->request->data['AppUser']['email_verified'] = true;

			// automatic server group id assignment for lower level admins
			if ($this->user['Group']['level'] < 100) {
				if (Configure::read('globals.advanced.subDomains')) {
					$this->request->data['ServerGroup']['ServerGroup'] = $this->Session->read('server_group_id');
				} else {
					$this->request->data['ServerGroup']['ServerGroup'] = 1;
				}
			}

			if ($this->User->add($this->request->data)) {
				$this->Session->setFlash(__d('users', 'The User has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The User could not be added. Please, try again.', true));
			}
		}

		/*
		 * Return a list of user groups with the same level or lower level than the admin so that an admin
		 * cannot add a higher level admin than himself
		 */
		$groups = $this->User->Group->find('list', array(
				'conditions' => array(
					'level <=' => $this->user['Group']['level']
				)
			)
		);
		$this->set('groups', $groups);

		//Set user groups only for super admins
		if ($this->user['Group']['level'] == 100) {
			$serverGroups = $this->User->ServerGroup->find('list');
			$this->set('serverGroups', $serverGroups);
		}
	}

	//-------------------------------------------------------------------

/**
 * Edit user data.
 *
 * If subDomain option is set to true in global config, subdomain admins:
 * - cannot edit non subdomain users
 * - cannot change a user's server group.
 *
 * Admins:
 * - cannot set a user as Super Admin
 *
 * @param null $userId
 * @return void
 */
	public function admin_edit($userId = null) {
		if (!$userId && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data)) {
			if ($this->User->saveAll($this->data)) {
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}

		if (empty($this->data)) {
			$this->data = $this->User->read(null, $userId);

			//Make sure an admin cannot edit a higher level admin account
			if ($this->user['Group']['level'] < $this->data['Group']['level']) {
				$this->Session->setFlash(__('You are not authorised to edit this user', true));
				$this->redirect(array('action' => 'index'));
			}

			//prevent admins accessing non subdomain users in a subdomain installation
			if (Configure::read('globals.advanced.subDomains') && $this->user['Group']['level'] < 100) {
				$userServerGroups = array();

				if (isset($this->data['ServerGroup'])) {
					foreach ($this->data['ServerGroup'] as $n) {
						$userServerGroups[] = $n['id'];
					}
				}

				if (!in_array($this->Session->read('server_group_id'), $userServerGroups)) {
					$this->Session->setFlash(__('Invalid User', true));
					$this->redirect(array('action' => 'index'));
				}
			}
		}

		/*
		 * Return a list of user groups with the same level or lower level than the admin so that an admin
		 * cannot set a higher level admin than himself
		 */
		$groups = $this->User->Group->find('list', array(
				'conditions' => array(
					'level <=' => $this->user['Group']['level']
				)
			)
		);
		$this->set('groups', $groups);

		//Set user groups only for super admins
		if ($this->user['Group']['level'] == 100) {
			$serverGroups = $this->User->ServerGroup->find('list');
			$this->set('serverGroups', $serverGroups);
		}
	}

	//-------------------------------------------------------------------

/**
 * Delete a user account
 *
 * Admins cannot delete a Super Admin account
 *
 * @param string $userId User ID
 * @return void
 */
	public function admin_delete($userId = null) {
		//Make sure admins cannot delete higher level admins
		$targetUser = $this->User->read(null, $userId);
		if ($this->user['Group']['level'] < $targetUser['Group']['level']) {
			$this->Session->setFlash(__('You are not authorised to delete this user', true));
			$this->redirect(array('action' => 'index'));
		}

		if ($this->User->delete($userId)) {
			$this->Session->setFlash(__('User "%s" is deleted successfully!', $targetUser['AppUser']['username']));
		} else {
			$this->Session->setFlash(__('Invalid User'));
		}

		$this->redirect(array('action' => 'index'));
	}

	//-------------------------------------------------------------------

/**
 * Common login action
 *
 * @return void
 */
	public function login() {
		$this->layout = 'Dashboard.user';

		if ($this->Auth->user()) {
			$this->Session->setFlash(__('You are already logged in!'));
			$this->redirect('/');
		}

		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->getEventManager()->dispatch(new CakeEvent('Users.afterLogin', $this, array(
					'isFirstLogin' => !$this->Auth->user('last_login')
				)));

				$this->User->id = $this->Auth->user('id');
				$this->User->saveField('last_login', date('Y-m-d H:i:s'));

				if ($this->here == $this->Auth->loginRedirect) {
					$this->Auth->loginRedirect = '/';
				}
				$this->Session->setFlash(sprintf(__d('users', '%s you have successfully logged in'), $this->Auth->user('username')));
				if (!empty($this->request->data)) {
					$data = $this->request->data[$this->modelClass];
					if (empty($this->request->data[$this->modelClass]['remember_me'])) {
						$this->RememberMe->destroyCookie();
					} else {
						$this->_setCookie();
					}
				}

				if (empty($data['return_to'])) {
					$data['return_to'] = null;
				}

				$this->redirect($this->Auth->redirect($data['return_to']));
			} else {
				$this->Session->setFlash(__d('users', 'Invalid e-mail / password combination.  Please try again'));
			}
		}
		if (isset($this->request->params['named']['return_to'])) {
			$this->set('return_to', urldecode($this->request->params['named']['return_to']));
		} else {
			$this->set('return_to', false);
		}
		$allowRegistration = Configure::read('Users.allowRegistration');
		$this->set('allowRegistration', (is_null($allowRegistration) ? true : $allowRegistration));
	}

	//-------------------------------------------------------------------

/**
 * Allows the user to enter a new password, it needs to be confirmed by entering the old password
 *
 * @return void
 */
	public function change_password() {
		$this->layout = 'Dashboard.user';
		parent::change_password();
	}

	//-------------------------------------------------------------------

/**
 * Reset Password Action
 *
 * Handles the trigger of the reset, also takes the token, validates it and let the user enter
 * a new password.
 *
 * @param string $token Token
 * @param string $user User Data
 * @return void
 */
	public function reset_password($token = null, $user = null) {
		$this->layout = 'Dashboard.user';
		parent::reset_password($token, $user);
	}

}