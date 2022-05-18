<?php ob_start(); ?>
<?php include "includes/header.php";
include "includes/nav.php";
include "includes/functions.php";

?>

<?php
function is_liked_by_user($post_id, $user_id)
{

    global $conn;
    $is_user_liked = mysqli_query($conn, "SELECT * FROM likes WHERE post_id = $post_id AND user_id=$user_id");
    if (mysqli_num_rows($is_user_liked) >= 1) {
        return true;
    } else {
        return false;
    }
}

$is_liked = false;

if (is_user_logged_in()) {
    $post_id = $_GET['p_id'];
    $user_id = $_SESSION['user_id'];

    $is_liked = is_liked_by_user($post_id, $user_id);
}



if (isset($_POST['liked']) || isset($_POST['unliked'])) {
    $post_id = $_POST['post_id'];
    $select_query = "SELECT * FROM posts WHERE post_id = $post_id";
    $select_post = mysqli_query($conn, $select_query);
    $post_arr = mysqli_fetch_assoc($select_post);
    $user_id = $_POST['user_id'];

    $post_likes = $post_arr['post_likes'];

    if (is_liked_by_user($post_id, $user_id)) { //make a disslike

        mysqli_query($conn, "UPDATE posts SET post_likes = $post_likes-1 WHERE post_id=$post_id");
        mysqli_query($conn, "DELETE FROM likes  WHERE user_id = $user_id AND post_id=$post_id");
        $is_liked = false;
        exit();
    } else {

        mysqli_query($conn, "UPDATE posts SET post_likes = $post_likes+1 WHERE post_id=$post_id");
        mysqli_query($conn, "INSERT INTO likes (user_id, post_id) VALUES($user_id, $post_id)");
        $is_liked = true;
        exit();
    }
}

?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">


            <?php

            if (isset($_GET['p_id'])) :
                $post_id = $_GET['p_id'];

                if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

                    $view_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = $post_id";
                    $send_query = mysqli_query($conn, $view_query);
                }


                $query = "SELECT * FROM posts WHERE post_id = $post_id";

                $select_post = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($select_post);
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];
                $post_views = $row['post_views_count'];
                $post_likes = $row['post_likes'];
            ?>



                <h1 class="page-header">
                    <?php echo $post_title ?>

                    <?php
                    if (isset($_SESSION['user_role'])) {
                        if ($_SESSION['user_role'] === 'admin') {
                            if (isset($_GET['p_id'])) {
                                $post_id = $_GET['p_id'];
                                echo "<a class='btn btn-warning' href='admin/posts.php?source=edit_post&p_id=$post_id'>edit post</a>";
                            }
                        }
                    }




                    ?>


                </h1>


                <p class="lead">
                    by <a href="index.php"><?php echo $post_author ?></a>
                </p>
                <div>
                    <p class="float-right"><span class="glyphicon glyphicon-time"></span> <?php echo "Posted on $post_date" ?></p>
                    <p class="float-left"><span class="fa fa-eye"></span> Views: <?php echo $post_views ?></p>
                </div>
                <hr>
                <img class="img-responsive" src="../images/<?php echo image_placeholder($post_image) ?>" alt="">
                <hr>
                <p><?php echo $post_content ?> </p>

                <hr>
                <?php if (!$is_liked) : ?>

                    <div class="row">
                        <p class="pull-right"><a id="likeButton" <?php if (isset($_SESSION['user_id'])) echo "href=''" ?>><span class="glyphicon glyphicon-thumbs-up"></span> Like <?php echo $post_likes; ?></a></p>
                    </div>
                <?php else : ?>
                    <div class="row">
                        <p class="pull-right"><a id="unlikeButton" href=""><span data-toggle="tooltip" data-placement="top" title="you liked it already" class="glyphicon glyphicon-thumbs-down"></span> Unlike <?php echo $post_likes; ?></a></p>
                    </div>
                <?php endif; ?>
                <div class="clear-fix"></div>



            <?php endif; ?>


            <!-- Blog Comments -->

            <?php // ADD NEW COMMENT
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                if (isset($_POST['submit'])) {

                    $comment_author = $_POST['comment_author'];
                    $comment_email = $_POST['comment_email'];
                    $comment_content = $_POST['comment_content'];
                    $post_id = $_GET['p_id'];


                    $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) VALUES ($post_id, '$comment_author', '$comment_email', '$comment_content', 'approved', now())";
                    $add_comment = mysqli_query($conn, $query);
                    // redirect("post.php?p_id=$post_id");
                }
                redirect("cms/post.php?p_id=$post_id");
            }

            ?>
            <!-- Comments Form -->
            <div class="well">
                <h4>Leave a Comment:</h4>
                <form method="POST" action="">
                    <div class="form-group">
                        <input required type="text" class="form-control" name="comment_author" placeholder="enter your name">
                    </div>
                    <div class="form-group">
                        <input required type="email" class="form-control" name="comment_email" placeholder="enter your email">
                    </div>
                    <div class="form-group">
                        <textarea required class="form-control" placeholder="enter your comment" name="comment_content" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </form>
            </div>
            <hr>





            <?php
            $p_id = $_GET['p_id'];

            $query = "SELECT * FROM comments WHERE comment_post_id= $p_id AND comment_status = 'approved' ORDER BY comment_id DESC ";

            $select_all_comments = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($select_all_comments)) :
                $comment_author_show = $row['comment_author'];
                $comment_email_show = $row['comment_email'];
                $comment_content_show = $row['comment_content'];
                $comment_date_show = $row['comment_date'];
                $approved_comment = $row['comment_status'];


            ?>

                <div class="media">
                    <a class="pull-left" href="#">
                        <img src="images/0x0.jpg" width="60" height="60" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"> <?php echo $comment_author_show ?>
                            <small><?php echo $comment_date_show ?></small>
                        </h4>
                        <small><?php echo $comment_email_show ?></small>

                        <div>
                            <?php echo '> ' . $comment_content_show ?>
                        </div>
                    </div>
                </div>


                <hr>


                <?php endwhile; ?>






        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>
    </div>
    <!-- /.row -->

    <hr>

    <?php include "includes/footer.php" ?>

    <script>
        <?php if (isset($_SESSION['user_id'])) : ?>
            $(document).ready(function() {
                $("[data-toggle = 'tooltip']").tooltip();
                var post_id = <?php echo $p_id; ?>;
                let user_id = <?php echo $_SESSION['user_id']; ?>;

                $('#likeButton').click(function() {
                    $.ajax({
                        url: "/cms/post.php?p_id=<?php echo $p_id; ?>",
                        type: 'post',
                        data: {
                            'liked': 1,
                            'post_id': post_id,
                            'user_id': user_id,

                        }
                    })
                });

                $('#unlikeButton').click(function() {

                    $.ajax({
                        url: "/cms/post.php?p_id=<?php echo $p_id; ?>",
                        type: 'post',
                        data: {
                            'unliked': 1,
                            'post_id': post_id,
                            'user_id': user_id,

                        }
                    })
                });
            })
        <?php else : ?>
            $(document).ready(function() {
                $('#like')
            })
        <?php endif; ?>
    </script>