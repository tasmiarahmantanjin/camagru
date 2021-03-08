<?php
include('../admin/resetPasswordEmail.php');

?>
<!-- HTML & CSS & BOOTSTRAP HERE -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Camagru</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="" media="screen" />
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
  <style>
    .form-gap {
      padding-top: 70px;
    }
  </style>
</head>

<!-- BODY STARTS HERE  -->

<body>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <div class="form-gap"></div>
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="text-center">
              <h3><i class="fa fa-lock fa-4x"></i></h3>
              <h2 class="text-center">Forgot Password?</h2>
              <p>Enter your email and we'll send you a link to get back into your account.</p>
              <div class="panel-body">
                <form id="register-form" role="form" autocomplete="off" class="form" method="post">
<!-- FIELD FOF INPUT EMAIL -->
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                      <input id="email" name="email" placeholder="email address" class="form-control" type="email">
                    </div>
                  </div>
<!-- FIELD FOF SUBMIT BUTTON -->
                  <div class="form-group">
                    <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Send Login Link" type="submit">
                  </div>
                <!-- PHP CODE -->
                <?php if (count($messages) > 0)
							{
								?>
 										<?php foreach($messages as $message)
										{ ?>
											<ul>
												<li><?php echo $message; ?></li>
											</ul>
											<?php
										} ?>
									</div>
								<?php
							}
              ?>
              	<?php if (count($errors) > 0)
							{
								?>
									<div class="form-group" style="color: red">
										<?php foreach($errors as $error)
										{ ?>
											<ul>
												<li><?php echo $error; ?></li>
											</ul>
											<?php 
										} ?>
									</div>
								<?php
							}
							?>
                  <p><strong>OR</strong></p>
                  <div class="col-md-14 text-left">
									<a href="register.php" class="btn btn-light btn-block">Create New Account</a>
								</div>
                  <input type="hidden" class="hide" name="token" id="token" value="">
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include 'includes/footer.php'; ?>
</body </html>