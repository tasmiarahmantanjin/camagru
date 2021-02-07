<?php
session_start();
include 'editUserDataValidation.php';
require_once '../config/db_connection.php';

// include('updateInfoValidation.php');
// require_once 'dbConnectionNew.php';
if ($_SESSION['user'] != NULL)
{
$errors = [];
$messages = [];

$user = $_SESSION['user']['username'];
$sql = "SELECT * FROM `users` WHERE username=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user]);
$rows = $stmt->fetchAll();

foreach($rows as $row)
{
	// $dbname = $row['name'];
	$gusername = $row['username'];
	$gemail = $row['email'];
	$notificationEmail = $row['notificationEmail'];
	$gpass = $row['password'];
}

if ($pdo)
{
	if (isset($_POST['submit']))
	{
		if ($_POST['submit'] == 'Save')
		{
			$rename  = $_POST['username'];
			$email = $_POST['email'];
			$opasswd = hash('sha256', $_POST['opasswd']);
			$notificationEmail = $_POST['notificationEmail'];
		
		// Check the validation
			if (username_validation($_POST['username']) && email_validation($_POST['email']))
			{
				if ($gpass == $opasswd)
				{
					// include 'dbConnectionNew.php';
					require_once '../config/db_connection.php';

					$query = "UPDATE `users` SET username=?, email=?, notificationEmail=? WHERE username=?";
					$stmt = $pdo->prepare($query);
					$stmt->execute([$rename, $email, $notificationEmail, $user]);
					array_push($messages, "Congrats! Your setting has been changed");
				}
				else
				{
					array_push($errors, "You have typed wrong password");
				}
			}
			else
			{
				array_push($errors, "Wrong username");
			}
		}
	}
}
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
		<?php require '../includes/header.php' ?>
		<div class="container">
			<div id="login-row" class="row justify-content-center align-items-center">
				<div id="login-column" class="col-md-6">
					<div id="login-box" class="col-md-12">
						<form id="login-form" class="form" action="" method="POST">
							<h3 class="text-center text-info">Update your information</h3>
							<div class="form-group">
								<label for="fullname" class="text-info">Full Name:</label><br>
								<input type="text" name="fullname" id="fullname"  value="<?php echo $_SESSION['user']['name']; ?>" class="form-control" readonly>
							</div>
							<div class="form-group">
								<label for="username" class="text-info">Username:</label><br>
								<input type="text" name="username" id="username" value="<?php echo $_SESSION['user']['username']; ?>" class="form-control">
							</div>
							<div class="form-group">
								<label for="email" class="text-info">Email:</label><br>
								<input type="text" name="email" id="email" value="<?php echo $_SESSION['user']['email']; ?>" class="form-control">
							</div>
							<div class="form-group">
								<label for="password" class="text-info">Old Password:</label><br>
								<input type="password" name="opasswd" id="opasswd" class="form-control" placeholder="Type your current password">
							</div>
							<div class="form-group">
							<label> <span>Recieve comment notifications? </span>
                            <?php if ($recieveCommEmail == 0) { ?>

                                <select name="recieveCommEmail" class="btn btn-success" style="margin-left: 50px; background-color: #03A9F4; border-color: #03A9F4">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            <?php } else { ?>
                                <select name="recieveCommEmail" style="margin-left: 57px;" class="btn btn-success" style="margin-left: 50px; background-color: #03A9F4; border-color: #03A9F4">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                        	</label>
                    		<?php } ?>
							</div>
							<div class="form-group">
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="Save">
                            </div>
							<div id="" class="text-right">
                                <a href="../admin/changePassword.php" class="text-info">Change password?</a>
							</div>
<!-- error & message check -->
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
<!-- error & message check -->
						</form>
					</div>
				</div>
			</div>
			<?php include '../includes/footer.php'; ?>
		</div>
	</body>
</html>

<?php }
else 
	header('Location: ../index.php');
?>