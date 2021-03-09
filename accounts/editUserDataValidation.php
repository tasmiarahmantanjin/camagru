<?php
$errors = "";

// Function to check if Username is valid
function username_validation($username)
{
	$count = 0;
	if (preg_match("/^([a-zA-Z0-9]+)$/", trim ($username)))
	{
		if (strlen($username) < 5)
		{
			array_push($errors, "Username should contain at least 5 characters");
		}
		else
			$count = 1;
	}
	else
		array_push($errors, "Usernames can only use letters, numbers.!");
	return ($count);
}

// Function to check if Email is valid
function email_validation($email)
{
	$count = 0;
	$pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";
	if (preg_match($pattern, trim ($email)) && isset($email) && $email != "")
	{
		$count = 1;
	}
	else
		array_push($errors, "Please, Enter a valid email address.");
	return ($count);
}

function password_validation($password, $confirm_password)
{
	$count = 0;
	if(!empty($password) && !empty($confirm_password) && ($password == $confirm_password)) {
		$uppercase = preg_match('@[A-Z]@', $password);
		$lowercase = preg_match('@[a-z]@', $password);
		$number    = preg_match('@[0-9]@', $password);

		if(!$uppercase || !$lowercase || !$number ||  strlen($password) < 8)
		{
			echo "Password should contain at least 6 characters, at least one upper case letter & one number.";
		}
		else
		{
			if ($password == $confirm_password)
			{
				$count = 1;
			}
			else{
				array_push($errors, "Password mismatch");
			}
		}
	}
	return ($count);
}
?>
