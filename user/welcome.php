<?php
session_start();

if (!($_SESSION['user']))
{
	header("location: login.php");
	exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Camagru</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="" media="screen" />
</head>

<body>
	<?php include '../includes/header.php'; ?>
	<div class="page-header">
		<h1>Hi, <b>
				<?php echo htmlspecialchars($_SESSION["username"]); ?>
			</b> Welcome to our site.</h1>
	</div>

	<?php include '../includes/footer.php'; ?>
</body>

</html>
