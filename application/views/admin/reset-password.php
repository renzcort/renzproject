<div class="message">
  <?php if ($this->session->flashdata('message')) { ?>
  <p class="login-box-msg">
    <?php echo $this->session->flashdata('message'); ?>
  </p>
  <?php } ?>
</div>
<form action="<?php echo base_url('admin/reset-password/?'.$params); ?>" method="post">
  <div class="form-group has-feedback">
    <input type="password" class="form-control" placeholder="Password" name="password" value="<?php echo set_value('password') ?>">
    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
  </div>
  <p class="form-error">
    <?php echo form_error('password'); ?>
  </p>
  <div class="form-group has-feedback">
    <input type="password" class="form-control" placeholder="Retype password" name="passconf" value="<?php echo set_value('passconf') ?>">
    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
  </div>
  <p class="form-error">
    <?php echo form_error('passconf'); ?>
  </p>
  <div class="row">
    <!-- /.col -->
    <div class="col-xs-4">
      <button type="submit" class="btn btn-primary btn-block btn-flat" name="submit">Submit</button>
    </div>
    <!-- /.col -->
  </div>
</form>