<? include "../functions.php"; ?>

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Post id</th>
            <th>Author</th>
            <th>email</th>
            <th>Content</th>
            <th>Status</th>
            <th>Date</th>
            <th>Delete</th>
            <th>Unapprove</th>
            <th>Approve</th>



        </tr>
    </thead>
    <tbody>
        <tr>
            <!-- show all posts-->

            <?php

            $query = "SELECT * FROM comments ORDER BY comment_id DESC";
            $comments = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($comments)) :
                $comment_id = $row['comment_id'];
                $comment_post_id = $row['comment_post_id'];
                $comment_user_id = $row['comment_user_id'];
                $comment_author_query = mysqli_query($conn, "SELECT user_name FROM users WHERE user_id = $comment_user_id");
                $comment_author_arr = mysqli_fetch_assoc($comment_author_query);
                $comment_author = $comment_author_arr['user_name'];
                $comment_email = $row['comment_email'];
                $comment_content = $row['comment_content'];
                $comment_status = $row['comment_status'];
                $comment_date = $row['comment_date'];
                $selected_post_query = mysqli_query($conn, "SELECT post_id, post_title FROM posts WHERE post_id=$comment_post_id");
                $post_row = mysqli_fetch_assoc($selected_post_query); 
                    $post_id = $post_row['post_id'];
                    $post_title = $post_row['post_title'];
            ?>

                    <tr>

        <td><?= $comment_id ?></td>
        <td><a href="../post.php?p_id=<?= $post_id ?>"><?= $post_title ?></a></td>
        <td><?= $comment_author ?></td>
        <td><?= $comment_email ?></td>
        <td><?= $comment_content ?></td>
        <td><?= $comment_status ?></td>
        <td><?= $comment_date ?></td>
        <td><a href="comments.php?delete=<?= $comment_id ?>">Delete</a></td>
        <td><a href="comments.php?unapprove=<?= $comment_id ?>">Unapprove</a></td>
        <td><a href="comments.php?approve=<?= $comment_id ?>">approve</a></td>
        
        </tr>
        <?php endwhile; ?>
            <!-- delete post -->
            <?php delete_comment(); ?>

            <?php 

    if (isset($_GET['approve'])) {
        $comment_id = $_GET['approve'];
        $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $comment_id";
        $unapprove_query= mysqli_query($conn, $query);
        header("location:comments.php");
    }

    if (isset($_GET['unapprove'])) {
        $comment_id = $_GET['unapprove'];
        $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $comment_id";
        $unapprove_query= mysqli_query($conn, $query);
        header("location:comments.php");
    }


?>



        </tr>
    </tbody>
</table>