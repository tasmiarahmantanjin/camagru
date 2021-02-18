<?php
// Aim of this function is to make sure new_password & confirm_password is same
// Increase the security of the password & make it strong

$count = 0;
$errors = [];

// Function to validate & secure the password
function passwordValidation($new_password, $confirm_password)
{
	// echo 'Test 3';
	if($new_password == $confirm_password)
	{
		$uppercase = preg_match('@[A-Z]@', $new_password);
		$lowercase = preg_match('@[a-z]@', $new_password);
		$number   	= preg_match('@[0-9]@', $new_password);

		if(!$uppercase || !$lowercase || !$number ||  strlen($new_password) < 6)
		{
			array_push($errors, "Password should be at least 6 characters, should include at least one upper case letter & one number.");
		}
		else
		{
			$count = 1;
			return ($count);
		}
	}
	else
	{
		array_push($errors, "Password mismatch");
	}

}
?>
