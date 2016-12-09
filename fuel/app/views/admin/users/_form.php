<?php echo Form::open(array("class"=>"form-horizontal")); ?>

	<fieldset>
		<div class="form-group">
			<?php echo Form::label('Username', 'username', array('class'=>'control-label')); ?>

				<?php echo Form::input('username', Input::post('username', isset($enrollment) ? $enrollment->username : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Username')); ?>

		</div>		
		<div class="form-group">
			<?php echo Form::label('Name', 'name', array('class'=>'control-label')); ?>

				<?php echo Form::input('name', Input::post('name', isset($enrollment) ? $enrollment->name : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Name')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Surname', 'surname', array('class'=>'control-label')); ?>

				<?php echo Form::input('surname', Input::post('surname', isset($enrollment) ? $enrollment->surname : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Surname')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Phone', 'phone', array('class'=>'control-label')); ?>

				<?php echo Form::input('phone', Input::post('phone', isset($enrollment) ? $enrollment->phone : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Phone')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Active', 'active', array('class'=>'control-label')); ?>

				<?php echo Form::input('active', Input::post('active', isset($enrollment) ? $enrollment->active : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Active')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Start year', 'start_year', array('class'=>'control-label')); ?>

				<?php echo Form::input('start_year', Input::post('start_year', isset($enrollment) ? $enrollment->start_year : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Start year')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('End year', 'end_year', array('class'=>'control-label')); ?>

				<?php echo Form::input('end_year', Input::post('end_year', isset($enrollment) ? $enrollment->end_year : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'End year')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Point count', 'points', array('class'=>'control-label')); ?>

				<?php echo Form::input('points', Input::post('points', isset($enrollment) ? $enrollment->points : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Point count')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Balance', 'balance', array('class'=>'control-label')); ?>

				<?php echo Form::input('balance', Input::post('balance', isset($enrollment) ? $enrollment->balance : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Balance')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Password', 'password', array('class'=>'control-label')); ?>

				<?php echo Form::input('password', Input::post('password', isset($enrollment) ? $enrollment->password : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Password')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Group', 'group_id', array('class'=>'control-label')); ?>

				<?php echo Form::input('group_id', Input::post('group_id', isset($enrollment) ? $enrollment->group_id : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Group')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Email', 'email', array('class'=>'control-label')); ?>

				<?php echo Form::input('email', Input::post('email', isset($enrollment) ? $enrollment->email : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Email')); ?>

		</div>
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>		</div>
	</fieldset>
<?php echo Form::close(); ?>