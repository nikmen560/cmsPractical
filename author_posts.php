<?php
include "includes/header.php";
include "includes/nav.php";
include "includes/functions.php";
?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php

            $posts = get_all_posts_by_author($_GET['author']);

            foreach($posts as $row):
                $user_data = get_post_user_by_id($row['post_user_id']);
            ?>


                <h1 class="page-header">
                    <a href="post.php?p_id=<?php echo $row['post_id']; ?>"><?php echo $row['post_title']?></a>
                </h1>

                <p class="lead">
                    by <a href="author_posts.php?author=<?php echo $user_data['user_name'] ?>&p_id=<?php echo $row['post_id'] ?>"><?php echo $user_data['user_name'] ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo "Posted on {$row['post_date']}" ?></p>
                <hr>
                <a href="post.php?p_id=<?php echo $row['post_id'] ?> ">
                    <img class="img-responsive" src="images/<?php echo $row['post_image'] ?>" alt="">
                </a>
                <hr>
                <p><?php echo substr($row['post_content'], 0, 200) . ' ...'?> </p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $row['post_id']; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
            <?php endforeach; ?>
        </div>
        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>
    </div>
    <!-- /.row -->
    <hr>

    <?php include "includes/footer.php" ?>