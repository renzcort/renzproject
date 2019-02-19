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
			<p>Welocme to the renzproject, please click link, 
				<a href="<?php echo base_url("admin/activated/?username={$username}&token={$token}"); ?>">
					<i>http://renzproject.localhost/admin/validation-token/?username=<?php echo $username; ?>&token=<?php echo $token; ?></i>
				</a>
			</p>
		</div>
		<div>
			<p>Enter your activation code <?php echo $activation_code; ?></p>
		</div>
</body>
</html>