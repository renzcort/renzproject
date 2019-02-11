<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  <?php echo validation_errors(); ?>
  <?php echo form_open('Test'); ?>
  <h5>Username</h5>
  <input type="text" name="username" value="<?php echo set_value('username'); ?>" size="50">
  <?php echo form_error('username'); ?>
  <h5>Password</h5>
  <input type="password" name="password" value="<?php echo set_value('password'); ?>" size="50">
  <?php echo form_error('password'); ?>
  <h5>Password Confirm</h5>
  <input type="password" name="passconf" value="<?php echo set_value('passconf'); ?>" size="50">
  <?php echo form_error('passconf'); ?>
  <h5>Email</h5>
  <input type="email" name="email" size="50" value="<?php echo set_value('email'); ?>" size="50ss">
  <?php echo form_error('email'); ?>
  <div>
    <input type="submit" name="submit" value="Submit">
  </div>
  <?php echo form_close(); ?>
</body>
</html>