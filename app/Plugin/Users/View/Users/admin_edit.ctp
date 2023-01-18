<?php
/**
 * Copyright 2010 - 2012, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2012, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
	<div class="users form">
		<?php echo $this->Form->create($model); ?>
		<fieldset>
			<legend><?php echo __d('users', 'Edit User'); ?></legend>
			<?php
			echo $this->Form->input('id');
			echo $this->Form->input('username', array(
				'label' => __d('users', 'Username')));
			echo $this->Form->input('email', array(
				'label' => __d('users', 'Email')));
			echo $this->Form->input('group_id');
			echo $this->Form->input('ServerGroup', array(
				'type' => 'select',
				'multiple' => true,
			));
			echo $this->Form->input('active', array(
				'label' => __d('users', 'Active')));
			?>
		</fieldset>
		<?php echo $this->Form->end('Submit'); ?>
	</div>
<?php echo $this->element('Users/admin_sidebar'); ?>