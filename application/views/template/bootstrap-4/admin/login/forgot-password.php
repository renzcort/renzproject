<div class="forgot-password" id="login">
  <h3>Forgot Your Password ?</h3>
  <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
  <?php if ($this->session->flashdata('message')) { 
    echo '<div class="message-box">'; 
    echo $this->session->flashdata('message');
    echo '</div>';
  } ?>
  <?php
    $attributes = array('class' => 'form text-left my-2 py-2');
    echo form_open($action, $attributes);
  ?>
  <div class="form-group">
    <label class="heading" for="inputEmail">Email Address</label>
    <input type="email" name="email" class="form-control form-control-sm">
    <small class="form-text text-muted">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</small>
  </div>
  <div class="form-error"><?php echo form_error('email'); ?></div>
  <div class="form-group">
    <button type="submit" class="btn btn-success btn-block" name="submit">Reset Password</button>
  </div>
  <?php echo form_close(); ?>
</div>