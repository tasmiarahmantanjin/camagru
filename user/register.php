<?php
require_once '../config/db_connection.php';
require_once 'registerValidation.php';
require_once '../admin/emails.php';

session_start();
if (isset($_POST["submit"]))
{
	if($_POST["submit"] === "Submit")
	{
			$fullname = $var_name;
			$username = $var_user;
			$email = $var_email;
			$token = bin2hex(random_bytes(50));
			$password = $var_password;
			if ($validInput == 4)
			{
				$password = hash('sha256', $_POST['password']);
				$confirm_password = hash('sha256', $_POST['confirm_password']);
				$count = 0;

				$result = $pdo->prepare("SELECT * FROM users");
				$result->execute();
				$rows = $result->fetchAll();
				
				foreach ($rows as $row)
				{
					if ($row['email'] == $email || $row['username'] == $username)
					{
						$count = 1;
						array_push($errors,"This username/email is already exists");
					}
				}
				
				if ($count == 0)
				{
					$sql = "INSERT INTO `users` (`name`, `username`, `email`, `token`, `password`) VALUES (?, ?, ?, ?, ?)";
					$stmt= $pdo->prepare($sql);
					$result = $stmt->execute([$fullname, $username, $email, $token, $password]);
					if ($result)
					{
						$user_id = $pdo->lastInsertId();
						sendSignUpVerificationEmail($email, $token);
						
						$_SESSION['id'] = $user_id;
						$_SESSION['username'] = $username;
						$_SESSION['email'] = $email;
						$_SESSION['verified'] = false;
						$_SESSION['message'] = 'You are logged in!';
						$_SESSION['type'] = 'alert-success';
					}
				}
			}
	}
}


// HTML CODE STARTS HERE
?>
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
	<!-- include navbar -->
	<?php require '../includes/navbar.php' ?>
			<div id="login-row" class="row justify-content-center align-items-center">
				<div id="login-column" class="col-md-6 col-sm-6 col-lg-4 col-xs-8" style="margin: 1vw">
					<div id="login-box">
						<form id="login-form" class="form" action="" method="POST">

							<h3 class="text-center text-dark">Sign Up</h3>
							<p class="text-center text-dark">Please fill this form to create an account.</p>

							<div class="form-group">
								<label for="fullname">Full Name:</label><br>
								<input type="text" name="fullname" id="fullname" class="form-control">
							</div>

							<div class="form-group">
								<label for="username">Username:</label><br>
								<input type="text" name="username" id="username" class="form-control">
							</div>

							<div class="form-group">
								<label for="email">Email:</label><br>
								<input type="text" name="email" id="email" class="form-control">
							</div>

							<div class="form-group">
								<label for="password">Password:</label><br>
								<input type="password" name="password" id="password" class="form-control">
							</div>

							<div class="form-group">
								<label for="confirm_password">Confirm Password:</label><br>
								<input type="password" name="confirm_password" id="confirm_password" class="form-control">
							</div>

							<div class="form-group">
								<input type="submit" name="submit" class="btn btn-dark btn-md" value="Submit">
							</div>

							<?php if (count($errors) > 0)
							{
								?>
									<div class="form-group" style="color: red">
										<?php foreach($errors as $error)
										{ ?>
											<ul>
												<li><?php echo $error; ?></li>
											</ul>
											<?php
										} ?>
									</div>
								<?php
							}
							?>

							<div class="col-md-14 text-right">
								<a href="login.php" class="btn btn-light btn-block">Already Have an account? Log in</a>
							</div>

						</form>
					</div>
				</div>
			</div>
	<!-- include footer -->
			<?php include '../includes/footer.php'; ?>
		</div>
	</body>
</html>
