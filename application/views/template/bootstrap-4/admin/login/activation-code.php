<div class="box-body activation-code" id="login">
	<h1>Activated your Account</h1>
	<p class="lead">We have sent you an email. Complete the process of creating your account by clicking the link in that email.</p>
	<?php
		$attributes = array('class' => 'form form-inline');
		echo form_open($action, $attributes);
	?>
	<div class="d-flex flex-column flex-wrap justify-content-center align-items-center" style="width: 100%;">
		<?php if ($this->session->flashdata('message')) { ?>
		<div class="message-box">
			<?php echo $this->session->flashdata('message'); ?>
		</div>
		<?php } ?>
		<label class="heading" for="inputActivationCode">Activation Code</label>
		<div class="form-group">
			<input type="text" name="code" class="form-control mr-1">
			<button type="submit" class="btn btn-success" name="submit">Activated</button>
		</div>
		<div class="form-error"><?php echo form_error('code'); ?></div>
	</div>
	<?php form_close(); ?>
</div>