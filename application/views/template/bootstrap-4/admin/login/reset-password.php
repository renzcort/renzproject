<div class="reset-password" id="login">
  <h3>Reset Your Password</h3>
  <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>

  <?php if ($this->session->flashdata('message')) { ?>
  <div class="message-box">
    <?php echo $this->session->flashdata('message'); ?>
  </div>
  <?php } ?>

  <?php
    $attributes = array('class' => 'form text-left my-2 py-2'); 
    echo form_open($action, $attributes); 
  ?>
    <div class="form-group">
      <label class="heading" for="inputNewPassword">New Password</label>
      <input type="password" name="password" class="form-control form-control-sm">
    </div>
    <div class="form-error"><?php echo form_error('password'); ?></div>
    <div class="form-group">
      <label class="heading" for="inputpasswordconf">Password Confirmation</label>
      <input type="password" name="passconf" class="form-control form-control-sm">
    </div>
    <div class="form-error"><?php echo form_error('passconf'); ?></div>
    <div class="form-group">
      <button type="submit" class="btn btn-success btn-block" name="submit">Change Password</button>
    </div>

  <?php echo form_close(); ?>
</div>