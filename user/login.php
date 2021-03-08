<?php
//require 'config.php';
require '../config/db_connection.php';


$errors = [];

if (isset($_POST['submit']))
{
	if ($_POST['submit'] == "Log in")
	{
		if (!isset($_POST['username'], $_POST['password']))
		{
			exit('Please fill both the username and password fields!');
		}
		$username = $_POST['username'];
		$password = hash('sha256', $_POST['password']);

		$result = $pdo->prepare("SELECT * FROM users WHERE (`username`=? OR `email`=?) AND `password`= ?");
		$result->execute([$username, $username, $password]);
		$user = $result->fetch();

		session_start();
		if ($user)
		{
			if ($user['verified'] == 1)
			{
				$user = array(
					'username' => $user['username'],
					'name' => $user['name'],
					'email' => $user['email'],
					'user_id' => $user['user_id']
				);
				$_SESSION['user'] = $user;
				// header('location: welcome.php');
				header('location: ../gallery/gallery.php');
				// print_r($_SESSION['user']) ;
				die();
			}
			else
				array_push($errors, "You have to verify your account");
		}
		else
		{
			array_push($errors, "The username/password you entered doesn't belong to an account. Please check your username/password and try again.");
		}
	}
}
?>

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
	<?php include '../includes/navbar.php'; ?>
		<div class="container">
			<div id="login-row" class="row justify-content-center align-items-center">
				<div id="login-column" class="col-md-6">

					<div id="login-box" class="col-md-18">

						<form id="login-form" class="form" action="" method="POST">
							<h3 class="text-center text-dark">Login</h3>
<!-- USERNAME FIELD -->
							<div class="form-group">
								<label for="username">Username:</label><br>
								<input type="text" name="username" id="username" class="form-control">
							</div>
<!-- PASSWORD FIELD -->
							<div class="form-group">
								<label for="password">Password:</label><br>
								<input type="password" name="password" id="password" class="form-control">
							</div>
<!-- SUBMIT BUTTON FIELD -->
							<div class="form-group">
								<input type="submit" name="submit" class="btn btn-dark btn-md" value="Log in">
							</div>
<!-- REGISTER HERE FIELD -->
							<div id="register-link" class="row">
								<div class="col-md-8 text-left">
									<!-- <a href="register.php" class="text-dark">Register here</a> -->
									<a href="register.php" class="btn btn-light btn-block">Don't have an account? Sign up</a>
								</div>
<!-- "FORGOT PASSWORD" FIELD -->
								<div class="col-md-4 text-right">
									<!-- <a href="user/forgotPassword.php" class="text-dark">Forgot Password</a> -->
									<!-- <a href="forgotPassword.php" class="btn btn-light btn-block">Forgot password?</a> -->
									<a href="forgotPassword.php" class="btn btn-light btn-block">Forgot password?</a>

								</div>

							</div>
						</form>
						<?php if (count($errors) > 0)
						{
							foreach ($errors as $error)
							{
								echo "<b style='color:red'> $error</b>";
							}
						}
						?>
					</div>
				</div>
			</div>
			<?php include '../includes/footer.php'; ?>
		</div>
	</body>
</html>
