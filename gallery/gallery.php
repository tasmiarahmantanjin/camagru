<?php
session_start();
include '../config/db_connection.php';
date_default_timezone_set('Europe/Helsinki');

if ($_SESSION != NULL)
{
	$next = 0;
	$previous = 0;
	$imagesPerPage = 5;
	
	$results = $pdo->prepare("SELECT * FROM images");
	$results->execute();
	$totalImages = $results->rowCount();
	$page = 1;
	
	$number_of_pages = ceil($totalImages / $imagesPerPage);
	
	if (isset($_GET['page']))
	{
		$page = intval($_GET['page']);
		$next = $page + 1;
		$previous = $page - 1;
	
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
	$start_limit = ($page - 1) * $imagesPerPage;

	$results = $pdo->prepare("SELECT users.username, images.image, images.id FROM users JOIN images ON images.user_id = users.user_id ORDER BY id DESC LIMIT " . $start_limit . ',' . $imagesPerPage);
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
				<div class="row" style="margin: 1vw;">
					<?php foreach($images as $image)
					{ ?>
						<div class="col-lg-3 col-xs-10 col-md-4">
						<!-- <div class="col px-md-1 px-lg-3 mb-4"> -->
						
							<div class="card h-100 bg-secondary text-white image-card">
								<!-- Display username of the post owner -->
								<div class="card-header text-center">
									<p class="card-title"><a href="#" class="text-white "><?php echo $image['username'];?></a></p>
								</div>

								<!-- Display Image -->
								<div style="margin: .2vw" class="card-img-bottom" >
									<?php if ($_SESSION['user'] != NULL){ ?>
										<a href="like.php?imageid=<?php echo $image['id'];?>">
											<img class="img-responsive" src="<?php echo '../img/'. $image['image']; ?>" margin="auto" />
										</a>
									</br>
									<?php }

									else{ ?>
											<img src="<?php echo '../img/'. $image['image']; ?>" margin="auto" />
										<?php } ?>
								</div>
							
								<!-- Like & Comment Button -->
								<div class="card-footer text-center">
									<a href="like.php?imageid=<?php echo $image['id'];?>">
										<button class="btn btn-secondary">Like & Comment</button>
									</a>
									<button class="btn btn-secondary">Share</button>
								</div>
								
							</div>
						</div>
					<?php }
					?>
				</div>

				<!-- Pagination Section -->
				<div class="row">
					<div class="col" style="margin-left: 48%;">
							<?php
								if ($page < $number_of_pages && $page > 1) {
									echo '<div class="pagination">
											<a href="gallery.php?page=' . $previous . '">' . '❮' . '</a>
										</div>';

									echo '<div class="pagination">
											<a href="gallery.php?page=' . $next . '">' . '❯' . '</a>
										</div>';
								} elseif ($page == $number_of_pages && $page > 1) {
									echo '<div class="pagination">
											<a href="gallery.php?page=' . $previous . '">' . '❮' . '</a>
										</div>';
								}
								if ($page == 1 && $number_of_pages != 1) {
									$next = $page + 1;
									echo '<div class="pagination">
											<a href="gallery.php?page=' . $next . '">' . '❯' . '</a> 
										</div>';
								}
							?>
					</div>
				</div>

				</div>
			</div>
				
			<!-- Footer added -->
				<?php include '../includes/footer.php'; ?>
			</div>
	</body>
	</html>
	<?php
}

else
	header('Location: ../index.php')
?>