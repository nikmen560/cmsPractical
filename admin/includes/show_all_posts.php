<? include "../functions.php"; ?>


<form action="" method="post">

<div class="table-responsive{-md}">
    <table class="table table-responsive-md table-bordered table-hover">
        <div id="bulkOptionsContainer" class="col-xs-4">
            <select class="form-control" name="post_status" id="bulkOptionsSelect">
                <option value="published">Published</option>
                <option value="draft">draft</option>
                <option value="delete">delete</option>
                <option value="clone">clone</option>
                <option value="reset_views">reset views</option>

            </select>

        </div>
        <div class="col-xs-4 form-group">
            <input type="submit" name="submit" class="btn btn-success" value="apply">
            <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>

        </div>

        <thead>
            <tr>
                <th><input type="checkbox" name="" id="selectAllBoxes"></th>
                <th>Id</th>
                <th>Author</th>
                <th>Title</th>
                <th>Category</th>
                <th>Content</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments count</th>
                <th>Date</th>
                <th>views</th>
                <th>view Post</th>
                <th>Delete</th>
                <th>Edit</th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <!-- show all posts-->
                <?php show_all_posts(); ?>


                <!-- delete post -->
                <?php delete_post(); ?>



            </tr>
        </tbody>
    </table>

</div>
</form>

<?php



if (isset($_POST['checkBoxArray'])) {

    $bulk_options = $_POST['post_status'];

    $checkBoxArr = $_POST['checkBoxArray'];

    foreach ($checkBoxArr as $el) {


        switch ($bulk_options) {
            case 'published';
                $query = "UPDATE posts SET post_status = '$bulk_options' WHERE post_id = $el";
                $update = mysqli_query($conn, $query);
                header('location: posts.php');
                break;
            case 'draft';
                $query = "UPDATE posts SET post_status = '$bulk_options' WHERE post_id = $el";
                $update = mysqli_query($conn, $query);
                header('location: posts.php');
                break;
            case 'delete';
                $query = "DELETE FROM posts WHERE post_id = $el";
                $update = mysqli_query($conn, $query);
                header('location: posts.php');
                break;
            case 'reset_views';
                $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = $el";
                $update = mysqli_query($conn, $query);
                header('location: posts.php');
                break;
            case 'clone';

                $query = "SELECT * FROM posts WHERE post_id = $el";
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
                $query = "INSERT INTO posts (post_category_id, post_title, post_author, post_date, post_image,post_content,post_tags,post_comment_count,post_status) 
    VALUES($post_category_id, '$post_title', '$post_author', now(), '$post_image', '$post_content', '$post_tags', 0 , '$post_status')";

                $clone_post = mysqli_query($conn, $query);
                header('location: posts.php');
                break;
                
        }
    }
}

?>


<script src="../js/script.js"></script>