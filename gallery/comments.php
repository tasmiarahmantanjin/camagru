<?php
include '../config/db_connection.php';
include '../admin/emails.php';
session_start();

function ft_image_owner_email($pdo, $imageid)
{
	$query = "SELECT users.email AS email FROM `users` JOIN images ON images.user_id = users.user_id JOIN tbl_comment ON images.id = tbl_comment.image_id WHERE images.id = ? LIMIT 1";
	$stmt = $pdo->prepare($query);
	$stmt->execute([$imageid]);
	$results = $stmt->fetchAll();

	foreach($results as $res)
	{
		$email = $res['email'];
	}
	return ($email);
}

if ($_POST['submit'] == "Comment")
{
	$user = $_SESSION['user']['user_id'];
	$text = $_POST['comm'];
	$imageid = $_GET['imageid'];
	$sql = "INSERT INTO `tbl_comment` (`user_id`, `comment`, `image_id`) VALUES (?, ?, ?)";
	$stmt= $pdo->prepare($sql);
	$stmt->execute([$user, $text, $imageid]);
	$email = ft_image_owner_email($pdo, $imageid);

	$sql1 = "SELECT notificationEmail FROM `users` WHERE email=?";
	$res = $pdo->prepare($sql1);
	$res->execute([$email]);
	$result = $res->fetch();
	if ($result['notificationEmail'] == '1')
		commentEmail($email, $imageid);
	header("Location: like.php?imageid=$imageid");
	exit();
}

