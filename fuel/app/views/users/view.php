<div class="row">
	<?php if($user->id == Auth::get_user_id()[1]) { ?>
	<a href="/users/edit" class="btn btn-primary pull-right"> <span class="fa fa-pencil"></span> <?=__('user.view.btn')?></a>
	<?php }?>
</div>

<div class="row">
	<div class="col-md-6">

		<p>
			<strong><?=__('user.field.username')?>:</strong>
			<?=$user->username?></p>
		<p>
			<strong><?=__('user.field.name')?>:</strong>
			<?=$user->get_fullname()?></p>
		<p>
			<strong><?=__('user.field.group')?>:</strong>
			<?=\Auth::group()->get_name($user->group_id)?></p>
		<p>
			<strong><?=__('user.field.iban.')?>:</strong>
			<a class="iban-link iban-show-0" onclick="showIban('0');"><?=__('user.field.iban.show')?></a>
			<span class="iban iban-0"><?=$user->iban?></span>
		</p>
		<p>
			<strong><?=__('user.field.phone')?>:</strong>
			<?=$user->phone?></p>
		<p>
			<strong><?=__('user.field.start_year')?>:</strong>
			<?=$user->start_year == 0 ? __('user.view.na') : $user->start_year?></p>
		<p>
			<strong><?=__('user.field.end_year')?>:</strong>
			<?=$user->end_year == 0 ? __('user.view.na') : $user->end_year?></p>
		<p>
			<strong><?=__('user.field.email')?>:</strong>
			<?=$user->email?></p>

	</div>
	<div class="col-md-6">
		<?php
			$end_year = $user->end_year;
			$start_year = $user->start_year;
		?>
		<div class="col-md-10 hidden-xs- hidden-sm  clickable">
			<div class="framed2 portrait-container">
				<img class="img-responsive portrait" src="<?=$user->avatar == '' ? '../../assets/img/wall/placeholder.jpg': '../../'.$user->avatar?>">
				<div class="info">
					<p class="start"><?=$start_year == 0? '' : $start_year?></p>
					<p class="end"><?=$end_year == 0? '' : $end_year?></p>
					<p class="name"><?=$user->get_fullname()?></p>
				</div>
			</div>
		</div>
	</div>
</div>

<?php

echo Asset::css('wall.css')?>