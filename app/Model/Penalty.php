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
 * @package       app.Model
 * @since         XLRstats v3.0
 * @version       0.1
 */

class Penalty extends AppModel {

/**
 * Use the XLRstats database
 *
 * @var bool
 */
	public $b3Database = true;

/**
 * Model name
 *
 * @var string
 */
	public $name = 'Penalty';

/**
 * Database table name
 *
 * @var string
 */
	public $useTable = 'penalties';

/**
 * Database associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Player' => array(
			'className' => 'Player',
			'foreignKey' => 'client_id'
		),
		'Admin' => array(
			'className' => 'Player',
			'foreignKey' => 'admin_id',
		)
	);

}