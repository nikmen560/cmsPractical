<?php include "includes/header.php"; ?>
<?php include "functions.php"; ?>


<div id="wrapper">

    <!-- Navigation -->


    <?php include "includes/nav.php"; ?>


    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Posts manaaging
                        <small>Author</small>
                    </h1>



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
                                <th>Edit</th>
                                <th>Unapprove</th>
                                <th>Approve</th>



                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <!-- show all posts-->

                                <?php

                                if (isset($_GET['id'])) {
                                    $post_id = $_GET['id'];
                                    $query = "SELECT * FROM comments WHERE comment_post_id = $post_id ORDER BY comment_id DESC";
                                    $comments = mysqli_query($conn, $query);
                                    while ($row = mysqli_fetch_assoc($comments)) {
                                        $comment_id = $row['comment_id'];
                                        $comment_post_id = $row['comment_post_id'];
                                        $comment_author = $row['comment_author'];
                                        $comment_email = $row['comment_email'];
                                        $comment_content = $row['comment_content'];
                                        $comment_status = $row['comment_status'];
                                        $comment_date = $row['comment_date'];


                                        $query = "SELECT * FROM posts WHERE post_id =$comment_post_id";
                                        $selected_query = mysqli_query($conn, $query);
                                        while ($row = mysqli_fetch_assoc($selected_query)) {
                                            $post_id = $row['post_id'];

                                            $post_title = $row['post_title'];

                                            echo
                                            "<tr>

        <td>$comment_id</td>
        <td><a href='../post.php?p_id=$post_id'>$post_title</a></td>
        <td>$comment_author</td>
        <td>$comment_email</td>
        <td>$comment_content</td>
        <td>$comment_status</td>
        <td>$comment_date</td>
        <td><a href='post_comments.php?id=$post_id&delete=$comment_id'>Delete</a></td>
        <td><a href='comments.php?source=edit_comment&id=$comment_id'>Edit</a></td>
        <td><a href='post_comments.php?unapprove=$comment_id'>Unapprove</a></td>
        <td><a href='post_comments.php?approve=$comment_id'>approve</a></td>
        
        </tr>";
        // TODO: undone update comment
                                        }
                                    }
                                ?>

                                    <!-- delete post -->
                                    <?php

                                    if (isset($_GET['delete'])) {
                                        $delete_comment_id = $_GET['delete'];
                                        $query = "DELETE FROM comments WHERE comment_id = $delete_comment_id";
                                        $delete_query = mysqli_query($conn, $query);
                                        header("location:post_comments.php?id=$post_id");
                                    }


                                    ?>


                                <?php

                                    if (isset($_GET['approve'])) {
                                        $comment_id = $_GET['approve'];
                                        $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $comment_id";
                                        $unapprove_query = mysqli_query($conn, $query);
                                        header("location:post_comments.php?id=$post_id");
                                    }

                                    if (isset($_GET['unapprove'])) {
                                        $comment_id = $_GET['unapprove'];
                                        $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $comment_id";
                                        $unapprove_query = mysqli_query($conn, $query);
                                        header("location:post_comments.php?id=$post_id");
                                    }
                                }

                                ?>



                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

</div>
<?php include "<includes/footer_admin.php"; ?>