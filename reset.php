<?php include "includes/header.php"; ?>
<?php include "includes/nav.php"; ?>
<?php include "includes/functions.php"; ?>

<?php
$user_arr = is_equal_tokens_then_return_user();
if (is_method('post') && isset($_POST['resetPassword'])) {
    $is_updated = update_password($user_arr['user_email']);
}
?>

<?php if (!isset($is_updated)) : ?>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Reset Password</h2>
                            <p>You can reset your password here.</p>
                            <div class="panel-body">
                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                            <input id="password" required name="password" placeholder="Enter password" class="form-control" type="password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-ok color-blue"></i></span>
                                            <input id="confirmPassword" required name="confirmPassword" placeholder="Confirm password" class="form-control" type="password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input name="resetPassword" disabled id="submitPassword" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                    </div>
                                    <input type="hidden" class="hide" name="token" id="token" value="">
                                </form>
                            </div><!-- Body-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                            
                            <h4>Your password has beed changed, you can now <a href="../login.php"></a>log in</h4>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>

<hr>



<script src="js/resetPassword.js"></script>
</div> <!-- /.container -->
<?php include "includes/footer.php"; ?>