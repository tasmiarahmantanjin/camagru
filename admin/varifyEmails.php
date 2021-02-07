<?php
// This function is to varify user registration process
session_start();
$errors = [];
//include '../config.php';
include '../config/db_connection.php';

if (isset($_GET['token']))
{
//    echo '2 Hi, Are you there STILLLLLLLL' . '<br>';
    $token = $_GET['token'];
//    echo '3 Hi, Are you there STILL HELLLO' . '<br>';

    $sql = "SELECT * FROM users WHERE token=? LIMIT 1";
//    echo '4 Hi, Are you there STILL HELLLO' . '<br>';

//    echo 'Maybe Here is the problem' . '<br>';

    $stmt = $pdo->prepare($sql);
//    echo '5 Hi, Are you there STILL HELLLO' . '<br>';

    $stmt->execute([$token]);
    $user = $stmt->fetch();

//    echo '6 Hi, Are you there STILL HELLLO' . '<br>';
//    print "Study PHP at " . $user . "<br>";

    if ($user)
    {
        //echo 'BUGGGG, Are you HERE';
        $query = "UPDATE users SET verified=1 WHERE token=?";
		$stmt = $pdo->prepare($query);
		$res = $stmt->execute([$token]);

        if ($res)
        {
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['verified'] = true;
            $_SESSION['message'] = "Your email address has been verified successfully";
            // header('location: ../login.php');
            header('location: ../user/login.php');
            exit(0);
        }
	}
	else
	{
        echo "User not found!";
    }
}
else
{
    echo "No token provided!";
}
?>
