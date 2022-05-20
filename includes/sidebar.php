            <div class="col-md-4">





                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <form action="search.php" method="post">
                        <div class="input-group">
                            <input name="search" type="text" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn btn-default" name="submit" type="submit">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </form>

                    <!-- /.input-group -->
                </div>

                    <?php

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $hide_registration_form = 'hidden';
    echo "<div class='well'>
                    <h4 class='text-center'>Welcome $username</h4>
                <a href='admin/includes/logout.php' class='btn btn-warning form-control'>Log out</a>
                </div>";

} else {
    $hide_registration_form = '';
}

// include "/cms/admin/functions.php";

// if(isset($_POST['submit_login'])) {
//     login_user($_POST['user_name'], $_POST['user_password']);
// }

?>


                <div class="well <?= $hide_registration_form ?>">

                    <h4 class="text-center">Sign in</h4>
                    <form action="login.php" method="post">
                        <div class="form">

                            <div class="form-group">
                                <input name="user_name" type="text" placeholder="enter login" class="form-control">
                            </div>
                            <div class="form-group">
                                <input name="user_password" type="password" placeholder="enter password" class="form-control">
                            </div>
                            <div class="form-group text-center">

                                <input type="submit" class="btn btn-primary form-control" name="submit_login" value="SIGN IN">
                            </div>
                        </div>
                    </form>
                    <div class="form-group">
                        <a href="/cms/forgot.php?forgot=<?php echo uniqid(true)?>">Forgot your password?</a>

                    </div>

                    <!-- /.input-group -->
                </div>

                <?php

                $query = "SELECT * FROM categories";
                $categories = mysqli_query($conn, $query);




                ?>


                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled">

                                <?php
                                while ($row = mysqli_fetch_assoc($categories)) {
                                    $cat_title = $row['cat_title'];
                                    $cat_id = $row['cat_id'];

                                    echo "<li><a href='category.php?category_id=$cat_id'>{$cat_title}</a></li>";
                                }

                                ?>

                            </ul>
                        </div>
                        <!-- /.col-lg-6 -->

                        <!-- /.col-lg-6 -->
                    </div>
                    <!-- /.row -->
                </div>





            </div>