<?php
include('../admin/passwordValidation.php');
require_once '../config/db_connection.php';

session_start();
$errors = [];
$messages = [];

// Check if the user is log in or not
if ($_SESSION['user'] != NULL)
{
	if ($pdo)
	{
		// store the username in user variable
		$user = $_SESSION['user']['username'];
		$sql = "SELECT * FROM `users` WHERE username=?";

		// prepare, execute & fetch the data from users table
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$user]);
		$rows = $stmt->fetchAll();

		// print_r($rows);
		// store the array value as key inside $row 
		foreach ($rows as $row)
		{
			// $username = $row['username'];
			// $email = $row['email'];
			$dbUsername = $row['username'];
			$dbEmail = $row['email'];
			$password = $row['password'];
		}

		$newPassword = $_POST['new_password'];
		$confirmPassword = $_POST['confirm_password'];

		if ($_POST['submit'] === "Submit")
		{
			if ($newPassword != "" && $confirmPassword != "")
			{
				if ($newPassword != $confirmPassword)
				{
					array_push($errors, "Please make sure both passwords match.");
				}
				else
				{
					if (passwordValidation($newPassword, $confirmPassword))
					{
						$new_password = hash('sha256', $newPassword);
						// $query = "UPDATE `users` SET password='$new_Password' WHERE username=?"; // Working version
						$query = "UPDATE `users` SET password='$new_password' WHERE username=?"; // Final working version
						$stmt = $pdo->prepare($query);
						$stmt->execute([$dbUsername]);
						// echo 'Test the db connection';
						// print_r($stmt);
						// $results = $stmt->execute([$new_password, $email]);
						if ($stmt)
						{
							array_push($messages, "Your password has been updated successfully");
							$_SESSION['message'] = "Your password has been updated successfully";
							// header("Refresh: 5; url=../index.php");
							header("Refresh: 5; url=../user/welcome.php");
						}
					}
				}
			}
		}
	}
}
?>

<!-- HTML STARTS HERE  -->

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Camagru</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="" media="screen" />
</head>

<body>
	<?php include '../includes/header.php'; ?>
	<div class="container">
		<div id="login-row" class="row justify-content-center align-items-center">
			<div id="login-column" class="col-md-6">
				<div id="login-box" class="col-md-12">
					<form id="login-form" class="form" action="" method="POST">
						<h3 class="text-center text-dark">Update your password</h3>
						<p class="text-center">Please fill out this form to change or update your password</p>
						<!-- new_password FIELD -->
						<div class="form-group">
							<input type="password" name="new_password" id="new_password" class="form-control" placeholder="New password">
						</div>
						<!-- confirm_password FIELD -->
						<div class="form-group">
							<input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm password">
						</div>
						<!-- SUBMIT FIELD -->
						<div class="row">
							<div class="col-md-6 text-left">
								<input type="submit" name="submit" class="btn btn-dark btn-md" value="Submit">
							</div>
							<!-- CANCEL FIELD -->
							<div class="col-md-6 text-right">
								<!-- <a href="../index.php" class="text-info"><h5>Login</h5></a> -->
								<a class="btn btn-light" href="../user/welcome.php">Cancel</a>
							</div>
						</div>
						<!-- php code for array $error count more than 0 -->
						<?php if (count($errors) > 0) {
						?>
							<div class="form-group" style="color: red">
								<?php foreach ($errors as $error) { ?>
									<ul>
										<li><?php echo $error; ?></li>
									</ul>
								<?php
								} ?>
							</div>
						<?php
						}
						?>
						<!-- php code for array $message count more than 0 -->
						<?php if (count($messages) > 0) {
						?>
							<div class="form-group" style="color: green">
								<?php foreach ($messages as $message) { ?>
									<ul>
										<li><?php echo $message; ?></li>
									</ul>
								<?php
								} ?>
							</div>
						<?php
						}
						?>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php include '../includes/footer.php'; ?>
</body>
</html>
