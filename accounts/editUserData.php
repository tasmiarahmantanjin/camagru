<?php
// Start the session
session_start();

// Include dependencies
include 'editUserDataValidation.php';
require_once '../config/db_connection.php';

// if user log in successfully 
if ($_SESSION['user'] != NULL) {
	$errors = [];
	$messages = [];
	// prepare & execute the data
	$user = $_SESSION['user']['username'];

	$sql = "SELECT * FROM `users` WHERE username=?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$user]);
	$rows = $stmt->fetchAll();
}


// Keep everything is a key as value with foreach loop
foreach ($rows as $row)
{
	$dbusername = $row['username'];
	$dbemail = $row['email'];
	$notificationEmail = $row['notificationEmail'];
	$dbpassword = $row['password'];
}

// All the needed check once the user press the submit data after edit
if ($pdo) {
	if (isset($_POST['submit'])) {
		if ($_POST['submit'] == 'Submit') {
			$newUserName  = $_POST['username'];
			$newEmail = $_POST['email'];
			$password = hash('sha256', $_POST['password']);
			$notificationEmail = $_POST['notificationEmail'];
		}


		// Validate the input data's from the update form
		if (username_validation($_POST['username']) && email_validation($_POST['email'])) {
			if ($dbpassword == $password) {
				include '../config/db_connection.php';

				// $query = "UPDATE `users` SET username= ?, email = ? WHERE username= ?"; // working version without notificationEmail
				$query = "UPDATE `users` SET username= ?, email = ?, notificationEmail= ? WHERE username= ?"; // test version with notificationEmail

				// $query = "UPDATE `users` SET username=?, email=?, WHERE username=?";
				$stmt = $pdo->prepare($query);

				// $stmt->execute([$username]);
				// $stmt->execute([$newUserName, $newEmail, $dbusername]);	// working version without notificationEmail
				$stmt->execute([$newUserName, $newEmail, $notificationEmail, $dbusername]);		// test version with notificationEmail
				// print_r($stmt);
				array_push($messages, "Your information has been updated successfully!");
			} else
				array_push($errors, "Password you entered is not valid");
		} else {
			array_push($errors, "Username you entered is not valid");
		}
	}
}
?>


<!-- HTML CODE STARTS HERE -->
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
	<!-- include navbar -->
	<?php require '../includes/header.php' ?>
	<div id="login-row" class="row justify-content-center align-items-center">
		<div id="login-column" class="col-md-6 col-sm-6 col-lg-4 col-xs-8" style="margin: 1vw">
			<div id="login-box">
				<form id="login-form" class="form" action="" method="POST">
					<h3 class="text-center text-dark">Update your information</h3>
					<!-- Name to update the data -->
					<div class="form-group">
						<label for="fullname">Full Name:</label><br>
						<input type="text" name="fullname" id="fullname" class="form-control" value="<?php echo $_SESSION['user']['name'] ?>" readonly>
					</div>
					<!-- Username to update the data -->
					<div class="form-group">
						<label for="username">Username:</label><br>
						<input type="text" name="username" id="username" class="form-control" value="<?php echo $_SESSION['user']['username']; ?>">
					</div>
					<!-- Email to update the data -->
					<div class="form-group">
						<label for="email">Email:</label><br>
						<input type="text" name="email" id="email" class="form-control" value="<?php echo $_SESSION['user']['email']; ?>">
					</div>
					<!-- Password to update the data -->
					<div class="form-group">
						<label for="password">Password:</label><br>
						<input type="password" name="password" id="password" class="form-control" placeholder="Old Password">
					</div>

					<!-- Comment notification email settings start -->
					<div class="form-group">
						<label> <span>Comment's email notification settings: </span>
							<?php if ($notificationEmail == 0)
							{ ?>

								<select name="notificationEmail" class="btn btn-dark" style="margin-left: 50px;">
									<option value="0">No</option>
									<option value="1">Yes</option>
								</select>
							<?php }
							else
							{ ?>
								<select name="notificationEmail" class="btn btn-dark" style="margin-left: 57px;">
									<option value="1">Yes</option>
									<option value="0">No</option>
								</select>
						</label>
					<?php } ?>
					</div>
					<!-- Comment notification email settings end -->

					<!-- Submit Button -->
					<div class="form-group">
						<input type="submit" name="submit" class="btn btn-dark btn-md" value="Submit">
					</div>

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
					<!-- Change Password Field -->
					<div class="col-md-14 text-right">
						<!-- <a href="user/forgotPassword.php" class="text-dark">Forgot Password</a> -->
						<a href="updatePassword.php" class="btn btn-light btn-block">Change Password</a>
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