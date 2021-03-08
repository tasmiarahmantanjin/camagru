<?php
session_start();

include 'config/setup.php';
include 'config/db_connection.php';

date_default_timezone_set('Europe/Helsinki');

$sqlQuery = $pdo->prepare("SELECT users.username, images.image FROM users JOIN images ON images.user_id = users.user_id ORDER BY id DESC");
$sqlQuery->execute();
$images = $sqlQuery->fetchAll();
?>

<!doctype html>
<html lang="en">
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<title>Index Page</title>
	<style>
		img {
			max-width: 100%;
			max-height: 100%;
		}
	</style>
</head>

<body>
	<?php include 'navbar.php'; ?>
			<div class="row" style="margin: 0.3vw; margin-top: 6vw;">
				<?php foreach($images as $image)
				{ ?>
					<div class="col-lg-3 col-xs-6 col-md-3 text-center" style="padding: 10px">
						<div class="card h-100 bg-dark text-white image-card">
							<!-- card header -->
							<div class="card-header text-center">
								<p>Post Owner: <a href=""><?php echo $image['username'];?></a></p>
							</div>
							<!-- card body -->
							<div style="margin: .2vw;">
								<?php if ($_SESSION['user'] != NULL) { ?>
									<a href="../controller/likes.php?imageid=<?php echo $image['id'];?>"><img class="img-responsive" src="<?php echo '../img/'. $image['image']; ?>" margin="auto" /></a>
									</br>
								<?php }
								else { ?> 
									<img src="<?php echo 'img/'. $image['image']; ?>" margin="auto" />
								<?php } ?> 
							</div>
							<!-- card footer -->
							<div class="card-footer text-center">
								<button onclick="return confirm('Please LOGIN to Like & Comment')" class="btn btn-secondary">Like & Comment</button>
							</div>
						</div>

					</div>
				<?php } ?>
			</div>
			<?php include 'includes/footer.php'; ?>
		</div>
</body>
</html>
