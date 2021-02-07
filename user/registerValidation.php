<?php
// This Function validate all the user input related to login system
// require_once 'signup.php';
// https://magemastery.net/courses/user-registration-with-php-mysql/form-validation

$validInput = 0;
$errors = [];
$data = $_POST;


// check if all the field has value and not empty
if ($data['fullname'] != "" && $data['username'] != "" && $data['email'] != "" && $data["password"] != "" && $data['confirm_password'] != "")
{
	// Validate fullname
	if (isset($data['fullname']) && $data['fullname'] != "")
	{
		if(preg_match("/^([a-zA-Z' ]+)$/",trim($data['fullname'])))
		{
			$var_name = trim($data['fullname']);
			++$validInput;
			// $validInput = 1;
		}
		else
		{
			array_push($errors, "You can only use letters for Names.");
		}
	}

	// Validate username has at least 5 characters
	if (isset($data['username']) && $data['username'] != "")
	{
		if (preg_match("/^([a-zA-Z0-9]+)$/", trim ($data['username'])))
		{
			if (strlen(trim($data['username'])) < 5)
			{
				array_push($errors, "Username should be at least 5 characters");
			}
			else
			{
				$var_user = $data['username'];
				++$validInput;
				// $validInput = 1;
			}
		}
		else
		{
			array_push($errors,"Usernames can only use letters, numbers.!");
		}
	}

	// Validate email address
	if (isset($data['email']) && $data['email'] != "")
	{
		if (filter_var($data['email'], FILTER_VALIDATE_EMAIL))
		{
			$var_email = $data['email'];
			++$validInput;
			// $validInput = 1;
		}
		else
		{
			array_push($errors, "Please, Enter a valid email address.");
		}
	}

	// Password Validation
	if(!empty($data["password"]) && !empty($data["confirm_password"]) && ($data["password"] == $data["confirm_password"]))
	{
		$uppercase = preg_match('@[A-Z]@', $data['password']);
		$lowercase = preg_match('@[a-z]@', $data['password']);
		$number    = preg_match('@[0-9]@', $data['password']);

		if(!$uppercase || !$lowercase || !$number ||  strlen($data['password']) < 6)
		{
			array_push($errors, "Password should be at least 6 characters in length and should include at least one upper case letter, one number.");
		}
		else
		{
			if ($data["password"] == $data["confirm_password"])
			{
				$var_password = $data['password'];
				++$validInput;
				// $validInput = 1;
			}
			else
			{
				array_push($errors, "Password mismatch");
			}
		}
	}
	


	// password & confirm_password validation
	if ($data["password"] != $data["confirm_password"])
	{
		array_push($errors, "Please make sure both passwords match.");
	}

}
