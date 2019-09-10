<div class="register-box">
  <div class="register-logo">
    <a href="../../index2.html"><b>Admin</b>LTE</a>
  </div>

  <div class="register-box-body">
    <?php if ($this->session->flashdata('message')) { ?>
    <p class="login-box-msg">
      <?php echo $this->session->flashdata('message'); ?>
    </p>
  <?php } ?>

    <?php //echo validation_errors(); ?>
    <form action="<?php echo base_url('admin/register'); ?>" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Username" name="username" value="<?php echo set_value('username') ?>">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <p class="form-error"><?php echo form_error('username'); ?></p>
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo set_value('email') ?>">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <p class="form-error"><?php echo form_error('email'); ?></p>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password" value="<?php echo set_value('password') ?>">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <p class="form-error"><?php echo form_error('password'); ?></p>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Retype password" name="passconf" value="<?php echo set_value('passconf') ?>">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>
      <p class="form-error"><?php echo form_error('passconf'); ?></p>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" name="accept_terms"> I agree to the <a href="#">terms</a>
            </label>
          </div>
        </div>
        <p class="form-error"><?php echo form_error('accept_terms'); ?></p>
          <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" name="create">Register</button>
        </div>
        <!-- /.col -->
      </div>
      <?php echo form_error('accept_terms'); ?>
    </form>

    <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign up using
        Google+</a>
    </div>

    <a href="login.html" class="text-center">I already have a membership</a>
  </div>
  <!-- /.form-box -->
</div>