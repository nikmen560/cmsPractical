<?php
if ($_SESSION['user_role'] === 'admin') {


    if (isset($_POST['create_post'])) {

        $post_title = escape($_POST['title']);

        $post_author = escape($_POST['author']);
        $post_category_id = escape($_POST['post_category_id']);
        $post_status = $_POST['post_status'];

        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];


        $post_tags = escape($_POST['post_tags']);
        $post_content = escape($_POST['post_content']);

        $post_date = date('d-m-y');

        move_uploaded_file($post_image_temp, "../images/$post_image");


        $query = "INSERT INTO posts (post_category_id, post_title, post_author, post_date, post_image,post_content,post_tags,post_comment_count,post_status) 
    VALUES($post_category_id, '$post_title', '$post_author', now(), '$post_image', '$post_content', '$post_tags', 0 , '$post_status')";

        // TODO: ESCAPE EVERY SQL QUERY

        $add_post = mysqli_query($conn, $query);

        $post_id = mysqli_insert_id($conn);

        if (!$add_post) {
            die("poized " . mysqli_error($conn));
        } else {
            echo "<p class='bg-success'>Post created <a href='../post.php?p_id=$post_id'> View Post</a></p>";
        }
    }
}


?>


<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <input type="text" name="title" class="form-control" placeholder="post title">
    </div>


    <div class="form-group">
        <select name="post_category_id" id="post_category">
            <?php

            $query = "SELECT * FROM categories";
            $categories = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($categories)) {

                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                echo "<option value='$cat_id'>$cat_title</option>";
            }
            ?>
        </select>

    </div>



    <div class="form-group">
        <select name="author" id="post_author">

            <?php
            $query = "SELECT * FROM users";
            $authors = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($authors)) {

                $author_id = $row['user_id'];
                $user_name = $row['user_name'];

                echo "<option value='$user_name'>$user_name</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <select name="post_status" id="post_status">
            <option value="draft">draft</option>
            <option value="published">published</option>
        </select>
    </div>
    <div class="form-group">
        <input type="file" class="form-control" name="image" placeholder="post image">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="post_tags" placeholder="post tags">
    </div>
    <div class="form-group">
        <textarea class="form-control" name="post_content" id="summernote" cols="30" rows="10" placeholder="post content"></textarea>
    </div>



    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_post" value="publish post">
    </div>

</form>

<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 200
        });
    });
</script>
<?php include "includes/footer_admin.php"; ?>