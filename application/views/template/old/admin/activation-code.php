<div class="text-center">
<?php if ($this->session->flashdata('message')) { ?>
	<div class="message">
		<?php $this->session->flashdata('message'); ?>		
	</div>
<?php } ?>
	<?php echo form_open('admin/validation-token/?'.$params, ''); ?>
		<div class="form-group">
			<p>Please enter your activation code</p>
			<input type="text" name="code" placeholder="activation code">
			<input type="submit" name="submit" value="Submit">
		</div>
	<?php echo form_close(); ?>
</div>