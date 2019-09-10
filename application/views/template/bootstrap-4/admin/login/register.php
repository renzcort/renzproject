<!-- login page -->
<div class="register" id="login">
  <?php
    $attributes = array(
                    'class' => 'form',
                    'id'    => 'register'
                  ); 
    echo form_open('admin/register', $attributes); 
  ?>
    <div class="form-group">
      <div class="input-group">
        <input type="text" class="form-control form-control-sm" placeholder="Username" aria-label="Recipient's username" aria-describedby="basic-addon2" name="username" value="<?php echo set_value('username'); ?>">
        <div class="input-group-append">
          <span class="input-group-text" id="basic-addon2"><i class="far fa-envelope"></i></span>
        </div>
      </div>
    </div>
    <div class="form-error"><?php echo form_error('username'); ?></div>
    <div class="form-group">
      <div class="input-group">
        <input type="email" class="form-control form-control-sm" placeholder="Email" aria-label="Recipient's username" aria-describedby="basic-addon2" name="email" value="<?php echo set_value('email'); ?>">
        <div class="input-group-append">
          <span class="input-group-text" id="basic-addon2"><i class="far fa-envelope"></i></span>
        </div>
      </div>
    </div>
    <div class="form-error"><?php echo form_error('email'); ?></div>
    <div class="form-group">
      <div class="input-group">
        <input type="password" class="form-control form-control-sm" placeholder="Password" aria-label="Recipient's username" aria-describedby="basic-addon2" name="password">
        <div class="input-group-append">
          <span class="input-group-text" id="basic-addon2"><i class="fas fa-lock"></i></span>
        </div>
      </div>
    </div>
    <div class="form-error"><?php echo form_error('password'); ?></div>
    <div class="form-group">
      <div class="input-group">
        <input type="password" class="form-control form-control-sm" placeholder="Passconf" aria-label="Recipient's username" aria-describedby="basic-addon2" name="passconf">
        <div class="input-group-append">
          <span class="input-group-text" id="basic-addon2"><i class="fas fa-lock"></i></span>
        </div>
      </div>
    </div>
    <div class="form-error"><?php echo form_error('passconf'); ?></div>
    <div class="text-left d-flex flex-row justify-content-between">
      <div class="form-check">
        <input type="checkbox" name="aggreement" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">I agree to the <a href="#">terms</a></label>
        <div class="form-error"><?php echo form_error('aggreement'); ?></div>
      </div>
      <div class="sign-up">
       <button type="submit" name="create" class="sign-in btn btn-primary btn-block btn-flat">Sign Up</button>
      </div>
    </div>
  <?php echo form_close(); ?>
  <ul class="list-unstyled m-0 d-flex flex-wrap flex-column">
    <li><p>- OR -</p></li>
    <li><a href="" class="facebook btn btn-sm btn-block"><i class="fab fa-facebook-square"></i> Sign in using Facebook</a></li>
    <li><a href="" class="google btn btn-sm btn-block"><i class="fab fa-google-plus"></i> Sign in using Gmail</a></li>
    <li><a href="">I forgot my password</a></li>
    <li><a href="">Register a new membership</a></li>
  </ul>
</div>