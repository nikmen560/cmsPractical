<?php include "includes/header.php"; ?>
<?php include "includes/nav.php"; ?>
<?php 
            $count = page_counter();
            $per_page = 5;
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }
            if ($page == "" || $page == 1) {
                $page_1 = 0;
            } else {
                $page_1 = ($page * $per_page) - $per_page;
            }
?>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php
            $posts = select_all_posts_paged($page_1, $per_page);
                foreach($posts as $post) :
                $user_data = get_post_user_by_id($post['post_user_id']);
            ?>
                <h1 class="page-header">
                    <a href="post/<?php echo $post['post_id']; ?>"><?php echo $post['post_title'] ?></a>
                </h1>
                <p class="lead">
                    by <a href="author_posts.php?author=<?php echo $post['post_user_id'] ?>"><?php echo $user_data['user_name'] ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo "Posted on {$post['post_date']} " ?></p>
                <hr>
                <a href="post/<?php echo $post['post_id'] ?> ">
                    <img class="img-responsive" src="images/<?php echo image_placeholder($post['post_image']); ?>" alt="">
                </a>
                <hr>
                <p><?php echo substr($post['post_content'], 0, 100)?> </p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post['post_id']; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <hr>
            <?php endforeach; ?>
        </div>
        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>
    </div>
    <!-- /.row -->
    <hr>
    <ul class="pagination">
        <?php
        for ($i = 1; $i <= $count; $i++) {
            if ($i == $page) {
                echo "<li class='page-item active'><a class='page-link' href='$i'>$i</a></li>";
                // echo "<li class='page-item active'><a class='page-link' href='index.php?page=$i'>$i</a></li>";
            } else {
                echo "<li class='page-item'><a class='page-link' href='$i'>$i</a></li>";
                // echo "<li class='page-item'><a class='page-link' href='index.php?page=$i'>$i</a></li>";
            }
        }
        ?>
    </ul>
    <?php include "includes/footer.php" ?>