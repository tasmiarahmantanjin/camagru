<!-- HTML & CSS & BOOTSTRAP HERE -->

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Camagru</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="" media="screen"/>
    </head>

<!-- BODY STARTS HERE  -->
	<body>
	<?php include 'includes/navbar.php'; ?>
		<div class="container">
			<div id="login-row" class="row justify-content-center align-items-center">
				<div id="login-column" class="col-md-6">

					<div id="login-box" class="col-md-18">

						<form id="login-form" class="form" action="" method="POST">
							<h3 class="text-center text-dark">Reset Your Password</h3>
<!-- USERNAME FIELD -->
							<div class="form-group">
								<label for="newpassword">New Password</label><br>
								<input type="text" name="newpassword" id="newpassword" class="form-control">
							</div>
<!-- PASSWORD FIELD -->
							<div class="form-group">
								<label for="confirmpassword">Confirm Password</label><br>
								<input type="confirmpassword" name="confirmpassword" id="confirmpassword" class="form-control">
							</div>

						</form>
					</div>
				</div>
			</div>
			<?php include 'includes/footer.php'; ?>
		</div>
	</body>
</html>
