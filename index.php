<?php include "includes/header.php"; ?>
<?php include "includes/nav.php"; ?>
<?php include "includes/functions.php"; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">



            <?php


            $count = page_counter();

            $per_page = 5;

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

            if (is_logged_in() && is_admin()) {

                $query = "SELECT * FROM posts LIMIT $page_1, $per_page";
            } else {

                $query = "SELECT * FROM posts WHERE post_status = 'published' LIMIT $page_1, $per_page";
            }

            $select_all_posts_query = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($select_all_posts_query)): 
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $user_data = get_post_user_by_id($row['post_user_id']);
                $post_author = $user_data['user_name'];
                $post_author_query = "SELECT * FROM posts WHERE post_user_id = {$row['post_user_id']}";
                $authors_posts = mysqli_query($conn, $post_author_query);
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = substr($row['post_content'], 0, 200);

            ?>
                <h1 class="page-header">
                    <a href="post/<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                </h1>
                <p class="lead">
                    by <a href="author_posts.php?author=<?php echo $post_author ?>&p_id=<?php echo $post_id ?>"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo "Posted on $post_date" ?></p>
                <hr>
                <a href="post/<?php echo $post_id ?> ">
                    <img class="img-responsive" src="images/<?php echo image_placeholder($post_image); ?>" alt="">
                </a>
                <hr>
                <p><?php echo $post_content ?> </p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>


            <?php endwhile; ?>







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
                echo "<li ><a class='active_link' href='index.php?page=$i'>$i</a></li>";
            } else {
                echo "<li><a href='index.php?page=$i'>$i</a></li>";
            }
        }
        ?>


    </ul>
    <!-- <style>
.pager li .active_link {
    background: #000 !important;
}
    </style> -->

    <?php include "includes/footer.php" ?>