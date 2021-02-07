<?php
include('PasswordValidation.php');

session_start();
$errors = [];
$messages = [];

$username = $_SESSION['user']['username'];
if ($_POST['submit'] == "Submit")
{
	if (isset($_GET['token']))
	{
		$token = $_GET['token'];
		require_once '../config/db_connection.php';
		echo 'TEST 2' . '<br>';

		if ($pdo){
			// to make sure set_pass is not the old password
			// $old_password = $_GET['old_password'];
			// if ($old_password = $npass){array_push($error, password you entered is already exists)}
			$nPass = $_POST['new_password'];
			$cPass = $_POST['confirm_password'];

			if ($nPass != "" && $cPass != ""){
				if ($nPass != $cPass){
					array_push($errors, "Password did not match");
				}
				else{
					if (passwordValidation($nPass, $cPass)){
						$query = "SELECT email FROM reset_password WHERE token=? LIMIT 1;";
						$stmt = $pdo->prepare($query);
						$stmt->execute([$token]);
						$row = $stmt->fetch();
						$email = $row['email'];
						if ($email)
						{
							$new_passwd = hash('sha256', $nPass);
							$sql = "UPDATE `users` SET password=? WHERE email=?;";
							$stmt = $pdo->prepare($sql);
							$results = $stmt->execute([$new_passwd, $email]);
							if ($results){
								array_push($messages, "Your password has been reset successfully");
								$_SESSION['message'] = "Your password has been changed";
								header("Refresh: 1; url=../index.php");
							}
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
		<link rel="stylesheet" type="text/css" href="" media="screen"/>
	</head>
	<body>
	<?php include '../includes/navbar.php'; ?>
		<div class="container">
			<div id="login-row" class="row justify-content-center align-items-center">
				<div id="login-column" class="col-md-6">
					<div id="login-box" class="col-md-12">
						<form id="login-form" class="form" action="" method="POST">
							<h3 class="text-center text-dark">Reset your password</h3>
							<p class="text-center">Please fill out this form to reset your password.</p>
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
									<a class="btn btn-light" href="../index.php">Cancel</a>
								</div>
							</div>
<!-- php code for array $error count more than 0 -->
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
<!-- php code for array $message count more than 0 -->
							<?php if (count($messages) > 0)
							{
								?>
									<div class="form-group" style="color: green">
										<?php foreach($messages as $message)
										{ ?>
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
