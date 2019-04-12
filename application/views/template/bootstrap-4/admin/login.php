<!-- login page -->
<?php
  $attributes = array(
                  'class' => 'form',
                  'id'    => 'login'
                ); 
  echo form_open('admin/check-login', $attributes); 
?>
  <div class="form-group">
    <div class="input-group">
      <input type="email" class="form-control form-control-sm" placeholder="Email" aria-label="Recipient's username" aria-describedby="basic-addon2" name="email" value="<?php echo set_value('email'); ?>">
      <div class="input-group-append">
        <span class="input-group-text" id="basic-addon2"><i class="far fa-envelope"></i></span>
      </div>
    </div>
  </div>
  <div class="form-error">
    <?php echo form_error('email'); ?>
  </div>
  <div class="form-group">
    <div class="input-group">
      <input type="password" class="form-control form-control-sm" placeholder="Password" aria-label="Recipient's username" aria-describedby="basic-addon2" name="password" value="<?php echo set_value('password') ?>">
      <div class="input-group-append">
        <span class="input-group-text" id="basic-addon2"><i class="fas fa-lock"></i></span>
      </div>
    </div>
  </div>
  <div class="form-error">
    <?php echo form_error('password'); ?>
  </div>
  <div class="text-left d-flex flex-row justify-content-between">
    <div class="form-check">
      <input type="checkbox" name="accept_terms" class="form-check-input" id="exampleCheck1">
      <label class="form-check-label" for="exampleCheck1">Remember Me</label>
    </div>
    <button type="submit" class="sign-in btn btn-primary btn-block btn-flat">Sign In</button>
  </div>
<?php echo form_close(); ?>
<ul class="list-unstyled m-0 d-flex flex-wrap flex-column">
  <li><p>- OR -</p></li>
  <li><a href="" class="facebook btn btn-sm btn-block"><i class="fab fa-facebook-square"></i> Sign in using Facebook</a></li>
  <li><a href="" class="google btn btn-sm btn-block"><i class="fab fa-google-plus"></i> Sign in using Gmail</a></li>
  <li><a href="<?php echo base_url('admin/forgot-password'); ?>">I forgot my password</a></li>
  <li><a href="<?php echo base_url('admin/register'); ?>">Register a new membership</a></li>
</ul>