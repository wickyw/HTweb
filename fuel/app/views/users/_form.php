<?php echo Form::open(array("class"=>"form-horizontal")); ?>

	<fieldset>
		<div class="col-md-3">
			<div class="form-group">
				<?php echo Form::label('Email', 'email', array('class'=>'control-label')); ?>

					<?php echo Form::input('email', Input::post('email', isset($enrollment) ? $enrollment->email : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Email')); ?>

			</div>
			<div class="form-group">
				<?php echo Form::label('Phone', 'phone', array('class'=>'control-label')); ?>

					<?php echo Form::input('phone', Input::post('phone', isset($enrollment) ? $enrollment->phone : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Phone')); ?>

			</div>
		</div>
		<div class="col-md-3 col-md-offset-3">
			<div class="form-group">
				<?php echo Form::label('Change password', 'password', array('class'=>'control-label')); ?>
				<?php echo Form::input('old_password', Input::post('old_password'), array('class' => 'col-md-4 form-control', 'placeholder'=>'Current password', 'type' => 'password')); ?>
				
				<?php echo Form::input('password', Input::post('password'), array('class' => 'col-md-4 form-control', 'placeholder'=>'New password', 'type' => 'password')); ?>
				<br><br>
				<?php echo Form::input('password2', Input::post('password2'), array('class' => 'col-md-4 form-control', 'placeholder'=>'Re-type password', 'type' => 'password')); ?>

			</div>
			<div class="form-group">
				<label class='control-label'>&nbsp;</label>
				<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>		
			</div>
		</div>
		
		
	</fieldset>
<?php echo Form::close(); ?>