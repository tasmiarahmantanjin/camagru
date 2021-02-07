<?php
// require_once '../admin/resetPassword.php';
require_once 'resetPasswordEmail.php';
?>

<!-- HTML CODE -->

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Camagru</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="" media="screen"/>
	</head>
	<body>
		<div class="container">
			<div id="login-row" class="row justify-content-center align-items-center">
				<div id="login-column" class="col-md-6">
					<div id="login-box" class="col-md-12">
						<p>A messages has been sent to your email, please click the link to reset your password <b><?php echo $_GET['email']; ?></b></p>
						<p>Check your email. If you want you can close this window</p>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
