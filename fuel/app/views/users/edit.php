<h2>Editing User</h2>
<br>

<?php echo render('users/_form'); ?>
<p>
	<?php echo Html::anchor('users/view/'.$enrollment->id, 'View'); ?> |
	<?php echo Html::anchor('users', 'Back'); ?></p>
