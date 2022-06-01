<?php include "includes/db.php"; ?>
<?php include "/cms/admin/functions.php"; ?>
<?php include "functions.php"; ?>
<?php session_start(); ?>

<?php $categories = get_all_categories(); ?>
<?php 
   $page_name = basename($_SERVER['PHP_SELF'], ".php");
?>
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/cms">Home</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="<?= ($page_name == 'contact') ? 'active':''; ?>"><a href="/cms/contact">Contact me</a></li>
                <?php

                    foreach($categories as $category) {
                        $cat_title = $category['cat_title'];
                        $cat_id = $category['cat_id'];
                        echo "<li class=''><a  href='/cms/category/$cat_id'>{$cat_title}</a></li>";
                    }
                ?>
                <?php if(!is_logged_in()): ?>
                    <li class="<?= ($page_name == 'reristration') ? 'active':''; ?> pull-left"><a href='/cms/registration'>Sign Up</a></li>
                    <li class="<?= ($page_name == 'login') ? 'active':''; ?> pull-left"><a href='/cms/login'>Log In</a></li>
                <?php else: ?>  
                    <li><a href='/cms/admin/includes/logout.php'>Logout</a></li>
                    <li><a href='/cms/admin/<?php if(is_admin()) {echo "dashboard";} else {echo "index";} ?>'>Dashboard</a></li>
                    <?php endif; ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>