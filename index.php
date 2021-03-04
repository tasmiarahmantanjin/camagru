<?php
// Start the session
session_start();

// Add all the include files
include 'config/setup.php';
include 'config/db_connection.php';

// Set time zone
date_default_timezone_set('Europe/Helsinki');

// Prepare the SQL query to display all the posted image
$results = $pdo->prepare("SELECT users.username, images.image FROM users JOIN images ON images.user_id = users.user_id ORDER BY id DESC");
$results->execute();
$images = $results->fetchAll();
?>

<!doctype html>
<html lang="en">
	<head>
	<!-- Bootstrap & CSS Link -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<link rel="stylesheet" href="../gallery/gallery.css">
	<title>Index Page</title>
	</head>

	<body>
	<?php require 'navbar.php' ?>

	<div class="row" style="margin: .5vw">

		<?php foreach($images as $image){ ?>
			<!-- <div class="col-lg-3 col-xs-6 col-md-3 text-center" > -->
			<div class="col-lg-3 col-xs-10 col-md-4">
				<div class="card h-100 bg-secondary text-white image-card">
					<div class="card-header text-center">
						<p class="card-title">Post Owner: <a href="#" class="text-white "><?php echo $image['username'];?></a></p>
					</div>

					<div class="card-img-bottom">
						<?php if ($_SESSION['user'] != NULL) { ?>
							<a href="like.php?imageid=<?php echo $image['id'];?>">
								<img src="<?php echo '../img/'. $image['image']; ?>"/>
							</a>
							</br>
						<?php }

						else { ?>
							<img src="<?php echo 'img/'. $image['image']; ?>"/>
						<?php } ?> 
					</div>
				
				</div>
			</div>
		<?php } ?>
	</div>
	</body>

	<?php require 'includes/footer.php' ?>
</html>
