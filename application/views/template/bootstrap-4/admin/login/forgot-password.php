<h3>Forgot Your Password ?</h3>
<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>

<?php if ($this->session->flashdata('message')) { ?>
<div class="message-box">
	<?php echo $this->session->flashdata('message'); ?>
</div>
<?php } ?>

<?php
	$attributes = array('class' => 'form text-left my-2 py-2'); 
	echo form_open('admin/forgot-password', $attributes); 
?>
  <div class="form-group">
    <label class="heading" for="inputEmail">Email Address</label>
    <input type="email" name="email" class="form-control form-control-sm">
    <small class="form-text text-muted">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</small>
  </div>
  <div class="form-group">
    <button type="submit" class="btn btn-success btn-block" name="submit">Reset Password</button>
  </div>
<?php echo form_close(); ?>