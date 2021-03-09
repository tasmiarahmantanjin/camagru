<?php
require_once 'emails.php';
$errors = [];
$messages = [];

if (isset($_POST['recover-submit']))
{
	if ($_POST['email'] !== "")	// id & name for input field of forgotPassword.php
	{
		require_once '../config/db_connection.php';
		
		if ($pdo)
		{
			$email = $_POST['email'];

		// Prepare a select statement
			$query = "SELECT *  FROM `users` WHERE email=?;";
			$stmt = $pdo->prepare($query);
			$stmt->execute([$email]);
			$result = $stmt->fetch();

			if (!$result)
			{
				echo '<script type="text/JavaScript">
        		alert("No user found with this email on our database");
        		</script>';
				header("Refresh: .1; url=../user/forgotPassword.php");
				exit();
			}
			$token = bin2hex(random_bytes(50));
			if (count($errors) == 0)
			{
				$sql = "INSERT INTO reset_password (email, token) VALUES (?,  ?);";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$email, $token]);
				sendResetMail($email, $token);
				array_push($messages, "An email has been sent to your email. Please Click the link to reset your password");
				header('location: ../admin/resetPasswordAlart.php?email=' .$email);
			}
		}
	}else{
		array_push($errors, "Please  write your email") ;
	}
}
?>
