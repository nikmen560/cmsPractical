 <?php include "includes/header.php"; ?>
 <?php include "includes/nav.php"; ?>
 <?php include "includes/alert.php"; ?>
 <?php
    if (isset($_GET['lang']) && !empty($_GET['lang'])) {
        $_SESSION['lang'] = $_GET['lang'];

        if (isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']) {
            echo "<script>location.reload()</script>";
        }
    }
    if (isset($_SESSION['lang'])) {
        include "admin/includes/languages/" . $_SESSION['lang'] . ".php";
    } else {
        include "admin/includes/languages/en.php";
    }
    $message = $alert_color = $alert_content = '';
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $username = mysqli_real_escape_string($conn, trim($_POST['username']));
        $email = mysqli_real_escape_string($conn, trim($_POST['email']));
        $password = mysqli_real_escape_string($conn, trim($_POST['password']));

        if (empty($username || $email || $password)) {
            $message = 'Fields cannot be empty';
            $alert_color = 'danger';
        } else if (is_exists('user_name', 'users', $username)) {
            $message = 'Username already exists';
            $alert_color = 'danger';
        } else if (is_exists('user_email', 'users', $email)) {
            $message = 'Email already exists';
            $alert_color = 'danger';
        } else {
            register_user($username, $email, $password);
            $message = 'Successfully registered';
            $alert_color = 'success';
        }
        if ($alert_color == 'success') {
            $alert_content = "
            <hr>
            <p class='text-center mg-0'>Now you can <a href='login'>log in</a></p>
            ";
        }
    }
    ?>

<div class="container">

 <div class="row">
     <div class="col-xs-6 col-xs-offset-3">
         <form action="" method="get" id="language_form" class="navbar-form navbar-right">
             <div class="form-group">
                 <select name="lang" id="select_language">
                     <option value="en" <?php echo selected_option('en'); ?>>English</option>
                     <option value="es" <?php echo selected_option('es'); ?>>Spanish</option>
                 </select>
             </div>
         </form>
     </div>
 </div>
 <div class="row">
     <div class="col-xs-6 col-xs-offset-3">
         <div class="form-wrap">
             <h1><?php echo _REGISTER; ?></h1>
             <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                 <?php empty($message) ?: show_alert($alert_color, $message, $alert_content) ?>
                 <div class="form-group">
                     <label for="username" class="sr-only"><?php echo _USERNAME ?></label>
                     <input type="text" required name="username" id="username" class="form-control" placeholder="<?php echo _USERNAME ?>">
                 </div>
                 <div class="form-group">
                     <label for="email" class="sr-only"><?php echo _EMAIL ?></label>
                     <input type="email" required name="email" id="email" class="form-control" placeholder="<?php echo _EMAIL ?>">
                 </div>
                 <div class="form-group">
                     <label for="password" class="sr-only"><?php echo _PASSWORD ?></label>
                     <input type="password" required name="password" id="key" class="form-control" placeholder="<?php echo _PASSWORD ?>">
                 </div>

                 <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="<?php echo _REGISTER ?>">
             </form>

         </div>
     </div> <!-- /.col-xs-12 -->
 </div> <!-- /.row -->


 <hr>



 <?php include "includes/footer.php"; ?>
</div>
 <script src="js/registration.js"></script>