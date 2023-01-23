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
 * @package       app.Config.Schema.data
 * @since         XLRstats v3.0
 * @version       0.1
 */

class Option {

/**
 * @var string
 */
	public $table = 'options';

/**
 * @var array
 */
	public $records = array(
		array('id' => '1', 'group' => 'website', 'name' => 'license', 'value' => '', 'locked' => '1', 'description' => 'Your XLRstats license key'),
		array('id' => '2', 'group' => 'server', 'name' => 'disqus_shortname', 'value' => '', 'locked' => '0', 'description' => '<b>[Empty]</b> Your <b>www.disqus.com shortname</b> to allow comments on several places'),
		array('id' => '3', 'group' => 'server', 'name' => 'theme', 'value' => 'default', 'locked' => '0', 'description' => '<b>[default]</b> Theme'),
		array('id' => '4', 'group' => 'server', 'name' => 'min_connections', 'value' => '10', 'locked' => '0', 'description' => '<b>[10]</b> Minimum number of connections before showing up in a league'),
		array('id' => '5', 'group' => 'server', 'name' => 'min_kills', 'value' => '100', 'locked' => '0', 'description' => '<b>[100]</b> Minimum number of kills before showing up in a league'),
		array('id' => '6', 'group' => 'server', 'name' => 'max_days', 'value' => '60', 'locked' => '0', 'description' => '<b>[60]</b> Maximum number of days before a player is considered M.I.A.'),
		array('id' => '7', 'group' => 'server', 'name' => 'hide_banned', 'value' => '1', 'locked' => '0', 'description' => '<b>[Yes]</b> Hide banned players from the leagues?'),
		array('id' => '8', 'group' => 'website', 'name' => 'show_banlist', 'value' => '1', 'locked' => '0', 'description' => '<b>[Yes]</b> Show Bans or Penalties '),
		array('id' => '9', 'group' => 'website', 'name' => 'show_bans_only', 'value' => '0', 'locked' => '0', 'description' => '<b>[No]</b> Show bans only (or also penalties and kicks)'),
		array('id' => '10', 'group' => 'server', 'name' => 'ban_dispute_link', 'value' => '', 'locked' => '0', 'description' => '<b>[Empty]</b> Link to your ban-appeal forum - leave empty to use disqus comments'),
		array('id' => '11', 'group' => 'server', 'name' => 'ban_disputable', 'value' => '1', 'locked' => '0', 'description' => '<b>[Yes]</b> Allow banned players to dispute a ban'),
		array('id' => '12', 'group' => 'server', 'name' => 'showMIA', 'value' => '1', 'locked' => '0', 'description' => '<b>[Yes]</b> Show M.I.A. playerblock'),
		array('id' => '13', 'group' => 'server', 'name' => 'opponents_count', 'value' => '15', 'locked' => '0', 'description' => '<b>[15]</b> How many opponents to show in the opponents tab on the playerstats pages'),
		array('id' => '14', 'group' => 'website', 'name' => 'homelink', 'value' => 'http://www.xlrstats.com/', 'locked' => '0', 'description' => '<b>[http://www.xlrstats.com/]</b> URL to your main community site (http://www.blah.com)'),
		array('id' => '15', 'group' => 'website', 'name' => 'tos_organisation', 'value' => 'xlrstats.com', 'locked' => '0', 'description' => '<b>[xlrstats.com]</b> Terms Of Service: your clan-, community- or organisation name'),
		array('id' => '16', 'group' => 'website', 'name' => 'tos_country', 'value' => 'The Netherlands', 'locked' => '0', 'description' => '<b>[The Netherlands]</b> Terms Of Service: your country'),
		array('id' => '17', 'group' => 'website', 'name' => 'must_accept_cookies', 'value' => '1', 'locked' => '0', 'description' => '<b>[Yes]</b> To satisfy the European Cookie Law'),
		array('id' => '18', 'group' => 'website', 'name' => 'google_analytics_account', 'value' => '', 'locked' => '1', 'description' => '<b>[Empty]</b> Your Google Ananlytics account'),
		array('id' => '19', 'group' => 'website', 'name' => 'show_donate_button', 'value' => '1', 'locked' => '1', 'description' => '<b>[No]</b> Show XLRstats donation button'),
		array('id' => '20', 'group' => 'tables', 'name' => 'table_playerstats', 'value' => 'xlr_playerstats', 'locked' => '0', 'description' => '<b>[xlr_playerstats]</b> Table name for playerstats'),
		array('id' => '21', 'group' => 'tables', 'name' => 'table_opponents', 'value' => 'xlr_opponents', 'locked' => '0', 'description' => '<b>[xlr_opponents]</b> Table name for opponents'),
		array('id' => '22', 'group' => 'tables', 'name' => 'table_bodyparts', 'value' => 'xlr_bodyparts', 'locked' => '0', 'description' => '<b>[xlr_bodyparts]</b> Table name for bodyparts'),
		array('id' => '23', 'group' => 'tables', 'name' => 'table_playerbody', 'value' => 'xlr_playerbody', 'locked' => '0', 'description' => '<b>[xlr_playerbody]</b> Table name for playerbody'),
		array('id' => '24', 'group' => 'tables', 'name' => 'table_mapstats', 'value' => 'xlr_mapstats', 'locked' => '0', 'description' => '<b>[xlr_mapstats]</b> Table name for mapstats'),
		array('id' => '25', 'group' => 'tables', 'name' => 'table_playermaps', 'value' => 'xlr_playermaps', 'locked' => '0', 'description' => '<b>[xlr_playermaps]</b> Table name for playermaps'),
		array('id' => '26', 'group' => 'tables', 'name' => 'table_weaponstats', 'value' => 'xlr_weaponstats', 'locked' => '0', 'description' => '<b>[xlr_weaponstats]</b> Table name for weaponstats'),
		array('id' => '27', 'group' => 'tables', 'name' => 'table_weaponusage', 'value' => 'xlr_weaponusage', 'locked' => '0', 'description' => '<b>[xlr_weaponusage]</b> Table name for weaponusage'),
		array('id' => '28', 'group' => 'tables', 'name' => 'table_actionstats', 'value' => 'xlr_actionstats', 'locked' => '0', 'description' => '<b>[xlr_actionstats]</b> Table name for actionstats'),
		array('id' => '29', 'group' => 'tables', 'name' => 'table_playeractions', 'value' => 'xlr_playeractions', 'locked' => '0', 'description' => '<b>[xlr_playeractions]</b> Table name for playeractions'),
		array('id' => '30', 'group' => 'tables', 'name' => 'table_history_monthly', 'value' => 'xlr_history_monthly', 'locked' => '0', 'description' => '<b>[xlr_history_monthly]</b> Table name for history_monthly'),
		array('id' => '31', 'group' => 'tables', 'name' => 'table_history_weekly', 'value' => 'xlr_history_weekly', 'locked' => '0', 'description' => '<b>[xlr_history_weekly]</b> Table name for history_weekly'),
		array('id' => '32', 'group' => 'tables', 'name' => 'table_ctime', 'value' => 'ctime', 'locked' => '0', 'description' => '<b>[ctime]</b> Table name for ctime'),
		array('id' => '33', 'group' => 'tables', 'name' => 'table_current_svars', 'value' => 'current_svars', 'locked' => '0', 'description' => '<b>[current_svars]</b> Table name for status plugin: server variables'),
		array('id' => '34', 'group' => 'tables', 'name' => 'table_current_clients', 'value' => 'current_clients', 'locked' => '0', 'description' => '<b>[current_clients]</b> Table name for status plugin: current clients')
	);
}
