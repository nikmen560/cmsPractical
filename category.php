<?php include "includes/header.php";
include "includes/nav.php";
include "admin/functions.php";
?>
<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">


            <?php
            if (isset($_GET['category_id'])): 
                $published = 'published';
                $cat_id = $_GET['category_id'];
                $per_page = 2;


                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                } else {
                    $page = "";
                }

                if ($page == "" || $page == 1) {
                    $page_1 = 0;
                } else {
                    $page_1 = ($page * $per_page) - $per_page;
                }

                if (isset($_SESSION['username']) && is_admin()) {

                    $cat_stmt= mysqli_prepare($conn, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_category_id = ?"); 
                    mysqli_stmt_bind_param($cat_stmt, "i", $cat_id);



                } else {

                    $cat_stmt= mysqli_prepare($conn, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_category_id = ? AND post_status = ?"); 
                    mysqli_stmt_bind_param($cat_stmt, "is", $cat_id, $published);
                }

                mysqli_stmt_execute($cat_stmt);

                mysqli_stmt_bind_result($cat_stmt, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);



                // $count = mysqli_stmt_fetch($cat_stmt);
                // var_dump($count);

                // if (empty($count)) {
                //     echo "<h1 class='text-center'>No post available</h1>";
                // }


                while (mysqli_stmt_fetch($cat_stmt)):
                ?>




                    <!-- First Blog Post -->
                    <h2>
                        <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="index.php"><?php echo $post_author ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> <?php echo "Posted on $post_date" ?></p>
                    <hr>
                    <a href="post.php?p_id=<?php echo $post_id ?> ">
                        <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                    </a>
                    <hr>
                    <p><?php echo $post_content ?> </p>
                    <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                    <hr>


                <?php endwhile ?>
            <?php endif ?>







        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>
    </div>
    <!-- /.row -->

    <hr>

    <ul class="pager">
        <?php

        for ($i = 1; $i <= $count; $i++) {
            if ($i == $page) {
                echo "<li ><a class='active_link' href='category.php?page=$i'>$i</a></li>";
            } else {
                echo "<li><a href='category.php?page=$i'>$i</a></li>";
            }
        }


        ?>


    </ul>

    <?php include "includes/footer.php" ?>