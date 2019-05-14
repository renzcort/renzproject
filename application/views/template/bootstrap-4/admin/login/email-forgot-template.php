<!DOCTYPE html>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
  <title>Activation code</title>
</head>
<body>
    <div>
      hi, <strong><?php echo $username ?></strong>
      <p>Welcome to the renzproject, please click link, 
        <a href="<?php echo prep_url(base_url("admin/reset-password/?email={$email}&forgotten_password_code={$forgotten_password_code}")); ?>">
          <i><?php echo base_url("admin/reset-password/?email={$email}&forgotten_password_code={$forgotten_password_code}"); ?></i>
        </a>
      </p>
    </div>
    <div>
      <p>Enter your activation code <?php echo $activation_code; ?></p>
    </div>
</body>
</html>