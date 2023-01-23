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

class Player extends AppModel {

/**
 * Can connect to b3Database
 *
 * @var bool
 */
	public $b3Database = true;

/**
 * Database table name
 *
 * @var string
 */
	public $useTable = 'clients';

/**
 * Database associations
 *
 * @var array
 */
	public $hasOne = 'League';

}