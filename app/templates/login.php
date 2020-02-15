<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reserva de aulas</title>

    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/login.css">
	<script src="js/login.js"></script>
</head>
<body>
<h1 class='text-center'>I.E.S. Abastos Classroom Reservation Aplication</h1>
<div class="container" id="#mainForm">
        <div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-6">
								<a href="#" class="active" id="login-form-link">Login</a>
							</div>
							<div class="col-xs-6">
								<a href="#" id="register-form-link">Register</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form id="login-form" action="index.php?ctl=login" method="post" role="form" style="display: block;" enctype="multipart/form-data">
									<div class="form-group">
										<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
									</div>
									<div class="form-group text-center">
										<input type="checkbox" tabindex="3" class="" name="remember" id="remember">
										<label for="remember"> Remember Me</label>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-main-form" value="Log In">
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-12">
												<div class="text-center">
													<a href="" tabindex="5" class="forgot-password">Forgot Password?</a>
												</div>
												<div class="text-center">
													<p style="color: red">
														<?php
														//Checking register form errors to print them on screen, with a proper error message
															if(isset($notValid)){
																echo "User or password incorrect.";
															}else if(isset($userExists)){
																echo "Register error: the user name has already been taken!";
															}else if(isset($_GET["timeout"])){
																echo "Your session was closed due to a long time of inactivity";
															}
														?>
														
													</p>
													<?php
													//Checking messages from Validation class
														if(isset($message)){
															foreach($message as $key => $value){
																echo "<p style='color: red'>".$value."</p>";
															}
														}
													?>
												</div>
											</div>
										</div>
									</div>
								</form>
								<form id="register-form" action="index.php?ctl=login" method="post" role="form" style="display: none;" enctype='multipart/form-data'>
									<div class="form-group">
										<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="" pattern="^[A-Za-z0-9]{7,15}$">
									</div>
									<div class="form-group">
										<input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="" pattern="^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$">
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" pattern="^[A-Za-z0-9]{8,*}$">
									</div>
									<div class="form-group">
										<input type="password" name="confirm-password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password" pattern="^[A-Za-z0-9]{8,*}$">
									</div>
									<div class="form-group">
										<h4>Upload profile image</h4>
										<input type="file" name="image" id="image" tabindex="2">
									</div>
									
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-main-form" value="Register Now">
											</div>
										</div>
									</div>
									<label>You won't be able to sign in until an administrator enables you.</label>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</body>
</html>
