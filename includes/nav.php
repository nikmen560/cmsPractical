<?php include "includes/db.php"; ?>
<?php include "/cms/admin/functions.php"; ?>
<?php session_start(); ?>
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/cms">Home</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="/cms/contact">Contact me</a></li>
                

                <?php
                // TODO: make active current page 

                $query = "SELECT * FROM categories";
                $execute = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($execute)) {
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];

                    $category_class = $registration_class = $login_class = '';

                    $page_name = basename($_SERVER['PHP_SELF']);

                    if(isset($_GET['category']) && $_GET['category'] == $cat_id) {
                        $category_class = 'active';
                    } else if($page_name == 'registration.php') {
                        $registration_class = 'active';
                    } else if($page_name == 'login.php') {
                        $login_class == 'active';
                    }
                    echo "<li class='$category_class'><a  href='/cms/category/$cat_id'>{$cat_title}</a></li>";
                }
                ?>
                <?php if(!is_logged_in()): ?>
                    <li class='$registration_class float-left'><a href='/cms/registration'>Sign Up</a></li>
                    <li class='$login_class float-left'><a href='/cms/login.php'>Log In</a></li>
                <?php else: ?>  
                    <li><a href='/cms/admin/includes/logout.php'>logout</a></li>
                    <li><a href='/cms/admin/index.php'>Admin</a></li>
                    <?php endif; ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>