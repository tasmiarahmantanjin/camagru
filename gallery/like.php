<?php
session_start();
include '../config/db_connection.php';
include 'unlike.php';
include 'comments.php';

$userId = $_SESSION['user']['user_id'];
$id = $_GET['imageid'];

$results = $pdo->prepare("SELECT * FROM images WHERE `id`=$id");
$results->execute();
$images = $results->fetchAll();

$likes = $pdo->prepare("SELECT * FROM likes WHERE `image_id`=$id AND `user_id`=$userId");
$likes->execute();
$row = $likes->fetch();

$comments_query = $pdo->prepare("SELECT users.name AS name, tbl_comment.comment FROM `users` JOIN tbl_comment on tbl_comment.user_id = users.user_id WHERE tbl_comment.image_id =?");
$comments_query->execute([$id]);
$totalComments = $comments_query->fetchAll();

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Like Page</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	</head>

	<body>
		<?php include('../includes/header.php'); ?>

			<div class="row text-center">
				<div class="col">
				
					<form method="POST" action="">
						<?php foreach($images as $image) { ?>
								<img style="margin: 1vw" src="<?php echo '../img/'.$image['image']?>">
						<?php $tot_like = $image['like_count']; } ?>
						
						<br>

						<?php if (!$row){ ?>
							<div style="margin:1vw">
								<input type="submit" name="submit" class="btn btn-dark btn-md" value="Like">
								<?php echo $tot_like. '<b> likes</b>'; ?>
							</div>
						<?php } else { ?>
							<div style="margin:1vw">
								<input type="submit" name="submit" class="btn btn-danger btn-md" value="Unlike">
								<?php echo $tot_like. '<b> likes</b>'; ?>
							</div>
						<?php } ?>

						<!-- Comment and button section -->
						<div>
							<div>
								<textarea rows="3" cols="50" placeholder='Comment...' name='comm'></textarea>
							</div>
							<div>
								<input type='submit' class='submit' name='submit' value='Comment'/>
							</div>
						</div>

					</form>

					<!-- Display all the user comments -->
					<div class="row text-center justify-content-center" style="margin:1vw">
						<div class="col-md-4 col-xs-12 text-center">
								<?php
									if ($totalComments)
									{
										echo '<table class="table table-hover table-dark">';
										foreach($totalComments as $comment)
										{
											echo '<tbody>';
												echo '<tr>';
													echo '<td style="text-align: left;">'.'<a>'.$image['username'].'</a>'.'</td>';
													echo '<td style="text-align: left">'.htmlentities($comment['comment']).'</td>';
												echo '</tr>';
											echo '</tbody>';
										}
										echo '</table>';
									}
								?>
						</div>
					</div>
				</div>
			</div>

			<?php include '../includes/footer.php'; ?>
	</body>
</html>
