<?php
if ($_SESSION['user_role'] === 'admin') {

    if (isset($_GET['p_id'])) {
        $post_id = $_GET['p_id'];
        global $conn;
        $query = "SELECT * FROM posts WHERE post_id = $post_id";
        $posts = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($posts)) {
            $post_category_id = $row['post_category_id'];
            $post_title = $row['post_title'];
            $post_author = $row['post_author'];
            $post_date = $row['post_date'];
            $post_image = $row['post_image'];
            $post_content = $row['post_content'];
            $post_tags = $row['post_tags'];
            $post_comment_count = $row['post_comment_count'];
            $post_status = $row['post_status'];
        }
    }
    if (isset($_POST['update_post'])) {
        $post_id = $_GET['p_id'];
        $post_title = $_POST['title'];
        $post_author = $_POST['author'];
        $post_category_id = $_POST['post_category_id'];
        $post_status = $_POST['post_status'];

        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];


        $post_tags = $_POST['post_tags'];
        $post_content = $_POST['post_content'];

        move_uploaded_file($post_image_temp, "../images/$post_image");

        if (empty($post_image)) {
            $query = "SELECT * FROM posts WHERE post_id =$post_id ";

            $select_image = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($select_image)) {
                $post_image = $row['post_image'];
            }
        }

        $query = "UPDATE posts SET post_title = '$post_title', post_category_id = '$post_category_id', post_date = now(), post_author = '$post_author', post_status = '$post_status', post_tags = '$post_tags', post_content = '$post_content', post_image = '$post_image' WHERE post_id = $post_id";
        $update_post_query = mysqli_query($conn, $query);

        echo "<p class='bg-success'>Post Updated<a href='../post.php?p_id=$post_id'> View Post</a></p>";
    }
}

?>


<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <input value="<?php echo $post_title ?>" type="text" name="title" class="form-control" placeholder="post title">
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
        <select name="author" id="">
            <?php

            if (isset($post_author) && !empty($post_author)) {
                echo "<option value='$post_author'>$post_author</option>";
            }

            $query_authors = "SELECT * FROM users";
            $authors = mysqli_query($conn, $query_authors);
            while ($row = mysqli_fetch_assoc($authors)) {

                $author_name = $row['user_name'];

                echo "<option value='$author_name'>$author_name</option>";
            }

            ?>

        </select>
    </div>

    <div class="form-group">
        <select name="post_status" id="post_status">

            <?php
            if ($post_status === 'published') {
                echo "<option value='draft'>draft</option>";
            } else {
                echo "<option value='published'>published</option>";
            }
            ?>
            <option value="<?php echo $post_status ?>"><?php echo $post_status ?></option>

        </select>
    </div>
    <div class="form-group">
        <img width="100" src="../images/<?php echo $post_image ?>" alt="">
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <input value="<?php echo $post_tags ?>" type="text" class="form-control" name="post_tags" placeholder="post tags">
    </div>
    <div class="form-group">
        <textarea name="post_content" id="summernote" cols="30" rows="10" placeholder="post content">
    <?php echo $post_content ?>

    </textarea>
    </div>



    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="update post">
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