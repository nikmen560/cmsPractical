<?php  include "includes/header.php"; ?>
<?php include_once "includes/alert.php"; ?>



<!-- Navigation -->

<?php  include "includes/nav.php"; ?>


<?php

//TODO: login popup create
$login_validation = [
	'error_message' => '',
	'error' => false  
];
if(is_method('post') && isset($_POST['login'])) {

    $user_name = escape($_POST['username']);
    $user_password = escape($_POST['password']);

    	// $log_in = login_user($user_name, $user_password);

 include "includes/functions.php"; 
		$log_in = log_in($user_name, $user_password);
		if(!$log_in) {
			$login_validation['error_message'] = 'username or password is not correct';
			$login_validation['error'] = true;
		} else if(is_logged_in() && is_admin()) {
			redirect("cms/admin/index.php");
		} else if(is_logged_in()){
			
			redirect("cms/index");
		}

} 


?>

<!-- Page Content -->
<div class="container">


	<div class="form-gap"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="text-center">


							<h3><i class="fa fa-user fa-4x"></i></h3>
							<h2 class="text-center">Login</h2>
							<div class="panel-body">
								<?php $login_validation['error'] == true ? show_alert('danger', $login_validation['error_message']) : ''; ?>


								<form id="login-form" role="form" action="login.php" autocomplete="off" class="form" method="post">

									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>

											<input name="username" required type="text" class="form-control" placeholder="Enter Username">
										</div>
									</div>

									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
											<input name="password" required type="password" class="form-control" placeholder="Enter Password">
										</div>
									</div>

									<div class="form-group">

										<input name="login" class="btn btn-lg btn-primary btn-block" value="Login" type="submit">
									</div>


								</form>

							</div><!-- Body-->

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<hr>

	<?php include "includes/footer.php";?>

</div> <!-- /.container -->
