<?php

// Function for 'user registration verification' with email
function sendSignUpVerificationEmail($email, $token)
{
    $body = '
        Thanks for registration in my app
        Please click the following link to complete your registration process:
	  http://localhost:8080/my_camagru/admin/varifyEmails.php?token=' . $token . '';

    $headers = "From: Admin\r\n";
    // Send the eamil
	if (mail($email, "Verify your email", $body, $headers))
	{
        echo '<script type="text/JavaScript">
        alert("A confirmation email has been sent to your email");
        </script>';
	}
	else
	{
        echo "Message Error";
    }
}

// Function for 'reset Password/forgot Password' with email
function sendResetMail($userEmail, $token)
{
    $body = '
        Please click on the link below to reset your password:.
      <a href="http://localhost:8080/my_camagru/admin/resetPassword.php?token=' . $token . '"> Click me </a>';

    $headers = "From: Admin\r\n";
    if (mail($userEmail, "Reset your password", $body, $headers)) {
        echo "Message Sent";
    } else {
        echo "Message Error";
    }
}

// Function for 'notify comment' with email
// function commentEmail($userEmail, $imageId)
// {
//     $body = '
//         Someone commented on your photo:.
//       <a href="http://localhost:8080/my_camagru/controller/likes.php?imageid=' . $imageId . '"> Click me </a>';
//     $headers = "From: Admin\r\n";
//     if (mail($userEmail, "Comment on your photo", $body, $headers)) {
//         echo "Email on comment";
//     } else {
//         echo "Message Error";
//     }
// }

?>
