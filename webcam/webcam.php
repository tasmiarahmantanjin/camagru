<?php

include '../config/db_connection.php';
include '../lib/includes.php';

session_start();

$user_id = $_SESSION['user']['user_id'];

function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct)
{
	// function patch for respecting alpha work find on http://php.net/manual/en/function.imagecopymerge.php
	$cut = imagecreatetruecolor($src_w, $src_h);
	imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
	imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
	imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
}

echo "Hello BUG?????";

// 2nd Part
	if (isset($_POST['cpt_1']) && $_POST['cpt_1'] != "" && isset($_POST['alpha'])) {
		$username = $_SESSION['user']['username'];

		echo "Hello BUG?????";
		// get the content of the captured image from the webcam put it in a tmp img
		list($type, $data) = explode(';', $_POST['cpt_1']);
		list(, $data) = explode(',', $data);
		$data = base64_decode($data);
		file_put_contents(IMAGES . '/tmp1.png', $data);

		// create image from this temporary 
		$im = imagecreatefrompng(IMAGES . '/tmp1.png');

		// get selected alpha
		$alpha = imagecreatefrompng(IMAGES . '/alpha/' . $_POST['alpha'] . '.png');

		//$image = merge(IMAGES . '/tmp1.png', IMAGES . '/alpha/' . $_POST['alpha'] . '.png', $username);
		// imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct)
		imagecopymerge_alpha($im, $alpha, 0, 0, 0, 0, imagesx($alpha), imagesy($alpha), 100);

		$num = rand(10, 10000);
		$image_name = $num . '_' . $username . '.png';
		imagepng($im,  IMAGES . '/' . $image_name);
		imagedestroy($im);

		$like_count = 0;
		$sql = "INSERT INTO images (username, user_id, image, like_count) VALUES ('$username', $user_id, '$image_name', '$like_count')";
		$stmt= $pdo->prepare($sql);
		$stmt->execute();
		header('Location: '.$_SERVER['PHP_SELF']);
		die;
	}
	


if (isset($_FILES['image']) && isset($_POST['alpha'])) {
	$image = $_FILES['image'];
	$extension = pathinfo($image['name'], PATHINFO_EXTENSION);

	if (in_array($extension, array('jpg', 'png'))) {
		$username = $_SESSION['user']['username'];
		$num = rand(10, 10000);
		$image_name = $num . '_' . $username . '.' . $extension;
		move_uploaded_file($image['tmp_name'], IMAGES . '/' . $image_name);

		if ($extension == 'jpg')
			$im = imagecreatefromjpeg(IMAGES . '/' . $image_name);
		else if ($extension == 'png')
			$im = imagecreatefrompng(IMAGES . '/' . $image_name);

		$alpha = imagecreatefrompng(IMAGES . '/alpha/' . $_POST['alpha'] . '.png');
		// imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct)
		imagecopymerge_alpha($im, $alpha, 0, 0, 0, 0, imagesx($alpha), imagesy($alpha), 100);

		imagepng($im,  IMAGES . '/' . $image_name);
		imagedestroy($im);
		$image = $image_name;
		$like_count = 0;

		// sql query 
		$sql = "INSERT INTO images (username, user_id, image, like_count) VALUES ('$username', $user_id, '$image', '$like_count')";
		$stmt= $pdo->prepare($sql);
		$stmt->execute();

		header('Location: '.$_SERVER['PHP_SELF']);
		die;
	}
}


// Delete Button will show up once the submit picture will appear on the display
// Is delete button appear then this code will help out to delete the photo user's want
if (isset($_GET['delete'])) {

	$id = $_GET['delete'];
	$results = $pdo->prepare("SELECT * FROM images WHERE id=$id");
	$results->execute();
	$images = $results->fetchAll();
	foreach ($images as $image) {
		unlink("../img/" . $image['image']);
		if ($image['username'] == $_SESSION['user']['username']) {
			$sql = "DELETE FROM images WHERE id=$id";
			$stmt= $pdo->prepare($sql);
			$stmt->execute();
			header('Location: webcam.php');
			die();
		}
	}
}

$results = $pdo->prepare("SELECT * FROM images ORDER BY id DESC");
$results->execute();
$images = $results->fetchAll();


// HTML SECTION

if ($_SESSION['user'] != NULL) { ?>

<html>
	<head>
		<title>Camagru</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

		<style type="text/css">
			#results { padding:20px; border:1px solid; background:#ccc; }
		</style>

		<link rel="stylesheet" href="main.css"/>
		<!-- <link rel="stylesheet" href="webcam.css"/> -->
		<script src="capture.js"></script>
	</head>

	<body>
	<?php include('../includes/header.php'); ?>
			<div class="container">
				<h1 class="text-center"></h1>
				<form method="POST" action="" enctype="multipart/form-data">
					<div class="row">
						<div class="col col-md-6 text-center">
							<input type="hidden" name="cpt_1" id="cpt_1" class="image-tag">
							<div class="camera">
								<video id="video">Video stream not available.</video>
								<button id="startbutton" type="button">Take photo</button>
							</div>
						</div>

						<div class="col col-md-6 text-center">
							<canvas id="canvas"></canvas>
							<div class="output">
								<img id="photo" alt="The screen capture will appear in this box.">
							</div>

<!-- <h1>Hello BUG</h1> -->

						</div>
					</div>

					<div class="row" style="margin-top: 1vw">
						<div class="col col-md-6 text-center">
							<input class="btn btn-dark" type="file" name="image" id="image" accept=".jpg, .png, .jpeg"/>
						</div>
					</div>

					<div class="row" style="margin: 1vw">
						<div class="col-md-12 text-center">
							<input class="checkbox-tools" type="hidden" name="alpha" value="blank" id="tool-0" checked>
							<!-- 1st emoji -->
							<input class="checkbox-tools" type="radio" name="alpha" value="alphatest1" id="tool-1">
							<label class="for-checkbox-tools" for="tool-1">
								<img style="width: 118px; margin-left: -15px;" src="<?php echo WEBROOT; ?>img/alpha/alphatest1.png">
							</label>
							<!-- 2nd emoji -->
							<input class="checkbox-tools" type="radio" name="alpha" value="alphatest2" id="tool-2">
							<label class="for-checkbox-tools" for="tool-2">
								<img style="width: 50px; margin-left: -2px;" src="<?php echo WEBROOT; ?>img/alpha/alphatest2.png">
							</label>
							<!-- 3rd emoji -->
							<input class="checkbox-tools" type="radio" name="alpha" value="alphatest3" id="tool-3">
							<label class="for-checkbox-tools" for="tool-3">
								<img style="width: 100px;margin-left: 0px;" src="<?php echo WEBROOT; ?>img/alpha/alphatest3.png">
							</label>

						</div>
					</div>

<!-- Submit Button -->

					<div class="row">
						<div class="col-md-12 text-center">
							<button class="btn btn-success">Submit</button>
						</div>
					</div>
					
				</form>

<h1>Field to show up the submitted photos</h1>

				<div class="row">
					<?php foreach ($images as $image) : ?>
						<div class="col col-md-3 col-xs-6">
							
							<?php
							if ($_SESSION['user']['user_id'] === $image['user_id']) : ?>
								<img src="<?php echo '../img/' . $image['image'] ?>" width="150px" alt="">
								</br>
								<a style="text-align: center; color: #18d26e;" href="?delete=<?php echo $image['id']; ?>" onclick="return('Sure?')">Delete</a>
							<?php endif ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

		<?php include '../includes/footer.php'; ?>
	</body>
 </html>
 <?php
}

else{
	header('Location: ../index.php');
}

// Final closing TAG
?>

