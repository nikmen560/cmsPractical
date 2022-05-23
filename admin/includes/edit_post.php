<?php
if (is_logged_in()) {


    if (isset($_GET['p_id'])) {
        $post_data = get_post_by_p_id();
    }

    if (isset($_POST['update_post'])) {
        $post_id = $_GET['p_id'];
        $post_title = $_POST['title'];
        $post_user_id = $_POST['post_user_id'];
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

        $query = "UPDATE posts SET post_title = '$post_title', post_category_id = $post_category_id, post_date = now(), post_user_id= $post_user_id, post_status = '$post_status', post_tags = '$post_tags', post_content = '$post_content', post_image = '$post_image' WHERE post_id = $post_id";
        $update_post_query = mysqli_query($conn, $query);

        echo "<p class='bg-success'>Post Updated<a href='../post.php?p_id=$post_id'> View Post</a></p>";
    }




}

?>


<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <input value="<?php echo $post_data['post_title']?>" type="text" name="title" class="form-control" placeholder="post title">
    </div>
    <div class="form-group">
        <select name="post_category_id" id="post_category">
            <?php show_categories(); ?>
        </select>

    </div>

    <div class="form-group">
        <select name="post_user_id" id="">
            <?php
            $post_author_id = $post_data['post_user_id'];
            $author_post_name_query = "SELECT user_name FROM users WHERE user_id = $post_author_id";
if($execute = mysqli_query($conn, $author_post_name_query)) {

            $author_post_name = mysqli_fetch_assoc($execute)['user_name'];
} else {
    die(mysqli_error($conn));
}


            if (isset($author_post_name) && !empty($author_post_name)) {
                echo "<option value='$post_author_id'>$author_post_name</option>";
            }

            $query_authors = "SELECT user_id, user_name FROM users";
            $authors = mysqli_query($conn, $query_authors);
            while ($row = mysqli_fetch_assoc($authors)) {

                $author_id = $row['user_id'];
                $author_name = $row['user_name'];

                echo "<option value='$user_id'>$author_name</option>";
            }

            ?>

        </select>
    </div>

    <div class="form-group">
        <select name="post_status" id="post_status">

            <option value="<?php echo $post_data['post_status'] ?>"><?php echo  $post_data['post_status'] ?></option>

            <?php
            if ($post_status === 'published') {
                echo "<option value='draft'>draft</option>";
            } else {
                echo "<option value='published'>published</option>";
            }
            ?>

        </select>
    </div>
    <div class="form-group">
        <img width="100" src="../images/<?php echo $post_data['post_image']?>" alt="">
        <input type="file" name="image">
    </div>
    <div class="form-group" id="ck">
        <input value="<?php echo $post_data['post_tags'] ?>" type="text" class="form-control" name="post_tags" placeholder="post tags">
    </div>
    <div class="form-group">
        <textarea name="post_content" id="summernote" cols="30" rows="10" placeholder="post content">
    <?php echo $post_data['post_content'] ?>
    </textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="update post">
    </div>

</form>
