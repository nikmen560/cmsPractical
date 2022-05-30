<?php ob_start(); ?>
<?php include "includes/header.php";
include "includes/nav.php";
include "includes/functions.php";

?>

<?php
if (!isset($_GET['p_id'])) {
    redirect('index');
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    update_post_views();
}
$comments = get_post_comments($_GET['p_id']);
$post_data = get_post_by_get();
$post_user = get_post_user_by_id($post_data['post_user_id']);
$post_user_name = $post_user['user_name'];

if (is_user_logged_in()) { // check if user already liked 
    $post_id = $_GET['p_id'];
    $user_id = $_SESSION['user_id'];
    $is_liked = is_liked_by_user($post_id, $user_id);
}
if (isset($_POST['liked']) || isset($_POST['unliked'])) { // like or unlike the current post
    $is_liked = like_unlike_post();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) { // ADD NEW COMMENT
    add_new_comment();
}

?>
<div class="container">

    <div class="row">
        <div class="col-md-8">
            <h1 class="page-header">
                <?php echo $post_data['post_title'] ?>
                <?php
                if (isset($_SESSION['user_role'])) { // add edit button
                    if ($_SESSION['user_role'] === 'admin' || $user_id === $post_data['post_user_id']) {
                        echo "<a class='btn btn-warning' href='/cms/admin/posts.php?source=edit_post&p_id=$post_id'>edit post</a>";
                    }
                }
                ?>
            </h1>
            <p class="lead">
                by <a href="index.php"><?php echo $post_user['user_name'] ?></a>
            </p>
            <div>
                <p class="float-right"><span class="glyphicon glyphicon-time"></span> <?php echo "Posted on {$post_data['post_date']}" ?></p>
                <p class="float-left"><span class="fa fa-eye"></span> Views: <?php echo $post_data['post_views_count'] ?></p>
            </div>
            <hr>
            <img class="img-responsive" src="/cms/images/<?php echo image_placeholder($post_data['post_image']) ?>" alt="">
                <p ><?php echo $post_data['post_content'] ?> </p>
            <hr>
            <?php if (isset($is_liked) && !$is_liked) : ?>
                <div class="row">
                    <p class="pull-right"><a id="likeButton" <?php if (isset($_SESSION['user_id'])) echo "href=''" ?>><span class="glyphicon glyphicon-thumbs-up"></span> Like <?php echo $post_data['post_likes']; ?></a></p>
                </div>
            <?php elseif (isset($is_liked) && $is_liked) : ?>
                <div class="row">
                    <p class="pull-right"><a id="unlikeButton" href=""><span data-toggle="tooltip" data-placement="top" title="you liked it already" class="glyphicon glyphicon-thumbs-down"></span> Unlike <?php echo $post_data['post_likes']; ?></a></p>
                </div>
            <?php endif; ?>
            <div class="clear-fix"></div>

            <!-- Comments Form -->
            <?php if (isset($_SESSION['user_id'])) : ?>
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form method="POST" action="">
                        <div class="form-group">
                            <textarea required class="form-control" placeholder="enter your comment" name="comment_content" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    </form>
                </div>
                <hr>
            <?php else : ?>

                <div class="row">
                    <h4>To leave a comment you should <a href="/cms/login.php">log in</a></h4>
                </div>
            <?php endif; ?>
            <?php
            foreach($comments as $comment):
                $author_data = get_user_by_id($comment['comment_user_id']);
            ?>

                <div class="media">
                    <a class="pull-left" href="#">
                        <img src="/cms/images/<?= $author_data['user_image'] ?>" width="60" height="60" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"> <?php echo $author_data['user_name'] ?>
                            <small><?php echo $comment['comment_date'] ?></small>
                        </h4>
                        <small><?php echo $author_data['user_email'] ?></small>
                        <div>
                            <?php echo '> ' . $comment['comment_content'] ?>
                        </div>
                    </div>
                </div>
                <hr>

                <?php  endforeach; ?>
        </div>
        <?php include "includes/sidebar.php" ?>

    <hr>



    <?php include "includes/footer.php" ?>

    <script>
        <?php if (isset($_SESSION['user_id'])) : ?>
            $(document).ready(function() {
                $("[data-toggle = 'tooltip']").tooltip();
                let post_id = <?php echo $post_id; ?>;
                let user_id = <?php echo $_SESSION['user_id']; ?>;

                $('#likeButton').click(function() {
                    $.ajax({
                        url: "/cms/post/<?php echo $post_id; ?>",
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
                        url: "/cms/post/<?php echo $post_id; ?>",
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