<?php include "includes/header.php";
include "includes/nav.php";
?>
<?php 
            if (isset($_POST['submit'])) {
                $posts = search_results();
            }
            function search_results() {

                global $conn;

                $search = $_POST['search'];

                $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%' ";
                $search_query = mysqli_query($conn, $query);

                if (!$search_query) {
                    die("query failed" . mysqli_error($conn));
                }

                return mysqli_fetch_all($search_query, MYSQLI_ASSOC);

            }
 ?>
<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php
                foreach($posts as $post) :
                $user_data = get_post_user_by_id($post['post_user_id']);
            ?>
                <h1 class="page-header">
                    <a href="/cms/post/<?php echo $post['post_id']; ?>"><?php echo $post['post_title'] ?></a>
                </h1>
                <p class="lead">
                    by <a href="/cms/author/<?php echo $post['post_user_id'] ?>"><?php echo $user_data['user_name'] ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo "Posted on {$post['post_date']} " ?></p>
                <hr>
                <a href="post/<?php echo $post['post_id'] ?> ">
                    <img class="img-responsive" src="/cms/images/<?php echo image_placeholder($post['post_image']); ?>" alt="">
                </a>
                <hr>
                <p><?php echo $post['post_description']?> </p>
                <a class="btn btn-primary" href="/cms/post.php?p_id=<?php echo $post['post_id']; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <hr>
            <?php endforeach; ?>
        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>
    </div>
    <!-- /.row -->

    <hr>

        <?php include "includes/footer.php" ?>