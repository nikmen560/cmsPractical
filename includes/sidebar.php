<?php $categories = get_all_categories(); ?>
<?php if (isset($_POST['submit_log_in'])) log_in($_POST['user_name'], $_POST['user_password']); ?>
<div class="col-md-4">
    <!-- SEARCH BOX -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="/cms/search" method="post">
            <div class="input-group">
                <input name="search" type="text" class="form-control">
                <span class="input-group-btn">
                    <button class="btn btn-default" name="submit" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
    </div>
    <!-- SIGN IN BOX -->
    <div class="well ">
        <?php if (!is_logged_in()) : ?>
            <h4 class="text-center">Sign in</h4>
            <form action="" method="post">
                <div class="form">
                    <div class="form-group">
                        <input name="user_name" type="text" placeholder="enter login" class="form-control">
                    </div>
                    <div class="form-group">
                        <input name="user_password" type="password" placeholder="enter password" class="form-control">
                    </div>
                    <div class="form-group text-center">
                        <input type="submit" class="btn btn-primary btn-block" name="submit_log_in" value="SIGN IN">
                    </div>
                </div>
            </form>
            <div class="form-group">
                <a href="/cms/forgot/<?php echo uniqid(true) ?>">Forgot your password?</a>
            </div>
        <?php else : ?>
            <h4 class='text-center'>Welcome <?= $_SESSION['username'] ?></h4>
            <a href='/cms/admin/includes/logout.php' class='btn btn-block btn-warning'>Log out</a>
            <a href='/cms/admin/index' class='btn btn-block btn-info'>User panel</a>
        <?php endif; ?>
    </div>
    <!-- Categories BOX -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
                    foreach ($categories as $category) {
                        $cat_id = $category['cat_id'];
                        $cat_title = $category['cat_title'];
                        echo "<li><a href='/cms/category/$cat_id'>{$cat_title}</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>