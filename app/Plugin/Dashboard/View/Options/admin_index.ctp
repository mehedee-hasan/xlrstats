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
 * @package       app.Plugin.Dashboard.View.Options
 * @since         XLRstats v3.0
 * @version       0.1
 */

$this->set('title_for_layout', __('Options • XLRstats'));
?>

<script type="text/javascript" charset="utf-8">
	//Set X-editable mode
	$.fn.editable.defaults.mode = 'inline';
</script>

<div class="page-header">
	<h1><?php echo __('Options'); ?>
		<small> - <?php echo __('Global Options'); ?></small>
	</h1>
</div>

<div>
	<blockquote>
		<?php
		echo __('<i>These are the global options that apply to all servers. You can however override each option
		for a server in the "Server Options" section of that specific server except for "locked" options. Lock the option
		if you do not want it to be overridden in server specific options. <strong>Click to Change!</strong></i>');
		?>
	</blockquote>
</div>

<div class="option-tabs">

	<ul class="nav nav-tabs">
		<li class="active"><a href="#server" data-toggle="tab">XLRstats Options</a></li>
		<li><a href="#website" data-toggle="tab">Website Options</a></li>
		<li><a href="#tables" data-toggle="tab">Database Tables</a></li>
	</ul>

	<div class="tab-content">

		<div id="server" class="tab-pane active">
			<?php echo $this->element('Dashboard.options', array('group' => 'server')); ?>
		</div>

		<div id="website" class="tab-pane">
			<?php echo $this->element('Dashboard.options', array('group' => 'website')); ?>
		</div>

		<div id="tables" class="tab-pane">
			<?php echo $this->TwitterBootstrap->alert(__('<b>WARNING:</b> This is for advanced users only. Do not change table names if you don\'t know what you\'re doing!'), array('style' => 'error'));?>
			<?php echo $this->element('Dashboard.options', array('group' => 'tables')); ?>
		</div>

	</div>
</div>
