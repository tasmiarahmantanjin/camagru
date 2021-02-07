<!-- Sudo Code
1. Need to validate the new Password with confrim passwod
2. After Validation, new password need to send in database
3. User shold be able to login with new password
-->

<?php
require_once 'emails.php';
$errors = [];
$messages = [];

// if (isset($_POST['resetPass']))
if (isset($_POST['recover-submit']))
{
	// if ($_POST['femail'] !== "")
	if ($_POST['email'] !== "")	// id & name for input field of forgotPassword.php
	{
		// require_once '../config.php';
		require_once '../config/db_connection.php';
		
		if ($pdo)
		{
			// $email = $_POST['femail'];
			$email = $_POST['email'];

			// $sql = "SELECT *  FROM `users` WHERE email='$email';";
			// $results = mysqli_query($pdo, $sql);

			//$sql = "SELECT *  FROM `users` WHERE email='$email';";
		// Prepare a select statement
			$query = "SELECT *  FROM `users` WHERE email=?;";
			$stmt = $pdo->prepare($query);
			$stmt->execute([$email]);
			$result = $stmt->fetch();

			if (!$result)
			{
				//array_push($errors, "No user found with this email on our database");
				echo '<script type="text/JavaScript">
        		alert("No user found with this email on our database");
        		</script>';
				// header("Refresh: .1; url=../forgotPassword.php");
				header("Refresh: .1; url=../user/forgotPassword.php");
				exit();
			}
			$token = bin2hex(random_bytes(50));
			if (count($errors) == 0)
			{
				// $sql = "INSERT INTO reset_password (email, token) VALUES ('$email',  '$token');";
				// $results = mysqli_query($pdo, $sql);
				$sql = "INSERT INTO reset_password (email, token) VALUES (?,  ?);";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$email, $token]);
				sendResetMail($email, $token);
				array_push($messages, "An email has been sent to your email. Please Click the link to reset your password");
				// header('location: ../user/resetPasswordAlart.php?email=' .$email);
				// header('location: resetPasswordAlart.php?email=' .$email); -working version
				header('location: ../admin/resetPasswordAlart.php?email=' .$email);

				//header("Refresh: 5; url=../user/forgotPassword.php");
			}
		}
	}else{
		array_push($errors, "Please  write your email") ;
	}
}
?>
