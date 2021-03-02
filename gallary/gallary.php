<?php
session_start();
include '../config/db_connection.php';
date_default_timezone_set('Europe/Helsinki');

if ($_SESSION != NULL)
{
	$next = 0;
	$prev = 0;
	$images_per_page = 5;
	
	$results = $pdo->prepare("SELECT * FROM images");
	$results->execute();
	$number_of_images = $results->rowCount(); 
	$page = 1;
	
	$number_of_pages = ceil($number_of_images / $images_per_page);
	
	if (isset($_GET['page']))
	{
		$page = intval($_GET['page']);
		$next = $page + 1;
		$prev = $page - 1;
	
		if ($page > $number_of_pages && $next > $number_of_pages)
		{
			$page = $number_of_pages;
			$next = $page;
		}
		elseif($page < 1)
		{
			$page = 1;
		}
	}
	else
	{
		$page = 1;
	}
	$start_limit = ($page - 1) * $images_per_page;

	$results = $pdo->prepare("SELECT users.username, images.image, images.id FROM users JOIN images ON images.user_id = users.user_id ORDER BY id DESC LIMIT " . $start_limit . ',' . $images_per_page);
	$results->execute();
	$images = $results->fetchAll();
?>

<!-- HTML CODE STARTS HERE -->

	<!DOCTYPE html>
	<html>
	<head>
		<title>Gallery</title>
		<!-- Bootstrap & CSS file link -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
		<link rel="stylesheet" href="gallery.css">
	</head>

	<body>
		<?php include('../includes/header.php'); ?>
				<div class="row" style="margin: .5vw; padding: .5vw">
					<?php foreach($images as $image)
					{ ?>
						<!-- <div class="col-lg-3 col-xs-10 col-md-4"> -->
						<div class="col px-md-1 px-lg-3 mb-4">
						
							<!-- Display username of the post owner -->
							<div class="card h-100 bg-secondary text-white image-card">
								<div class="feed-header">
									<p>Photo by: <a href="#" class="text-white "><?php echo $image['username'];?></a></p>
								</div>

								<!-- Display Image -->
								<div>
									<?php if ($_SESSION['user'] != NULL){ ?>
										<a href="../controller/likes.php?imageid=<?php echo $image['id'];?>"><img src="<?php echo '../img/'. $image['image']; ?>" margin="auto" /></a></br>
									<?php }
									else{ ?>
											<img src="<?php echo '../img/'. $image['image']; ?>" margin="auto" />
										<?php } ?>
								</div>
								<!-- Add Comment & Like -->
								
								
							</div>
						</div>
					<?php }
					?>
				</div>
				<?php include '../includes/footer.php'; ?>
			</div>
	</body>
	</html>
	<?php
}

else
	header('Location: ../index.php')
?>