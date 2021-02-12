<?php
	// echo 'Hello Tasmia';
	include '../lib/includes.php';


?>


if ($_SESSION['user'] != NULL) { 






}

else{
	header('Location: ../index.php');
}

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

						</div>
					</div>
<h1>Hello Test</h1>
					<div class="row" style="margin-top: 1vw">
						<div class="col col-md-6 text-center">
							<input class="btn btn-dark" type="file" name="image" id="image" accept=".jpg, .png, .jpeg"/>
						</div>
					</div>
<h1>Hello Test</h1>
					<div class="row" style="margin: 1vw">
						<div class="col-md-12 text-center">
							<input class="checkbox-tools" type="hidden" name="alpha" value="blank" id="tool-0" checked>
							<!-- 1st emoji -->
							<input class="checkbox-tools" type="radio" name="alpha" value="emoji1" id="tool-1">
							<label class="for-checkbox-tools" for="tool-1">
								<img style="width: 118px; margin-left: -15px;" src="<?php echo WEBROOT; ?>img/emoji/emoji1.png">
							</label>
							<!-- 2nd emoji -->
							<input class="checkbox-tools" type="radio" name="alpha" value="emoji2" id="tool-2">
							<label class="for-checkbox-tools" for="tool-2">
								<img style="width: 50px; margin-left: -2px;" src="<?php echo WEBROOT; ?>img/emoji/emoji2.png">
							</label>
							<!-- 3rd emoji -->
							<input class="checkbox-tools" type="radio" name="alpha" value="emoji3" id="tool-3">
							<label class="for-checkbox-tools" for="tool-3">
								<img style="width: 100px;margin-left: 0px;" src="<?php echo WEBROOT; ?>img/emoji/emoji3.png">
							</label>

						</div>
					</div>

<h1>Hello Test</h1>

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

		<?php include '../includes//footer.php'; ?>
	</body>
 </html>