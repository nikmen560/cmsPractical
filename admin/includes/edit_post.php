<?php
include "/cms/includes/alert.php";
if (is_logged_in()) {
    if (isset($_GET['p_id'])) {
        $post_data = get_post_by_p_id();
    }
    if (isset($_POST['update_post'])) {
        if (update_post()) {
            $is_updated = true;
            $post_id = $post_data['post_id'];
        } else {
            $is_updated = true;

        }
    }
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <?php if(isset($is_updated) && $is_updated = true) : show_alert('success', "The post is updated <a href='../post.php?p_id=$post_id'>view post</a>"); ?>
    <?php elseif (isset($is_updated) && $is_updated = false) : show_alert('danger', "The post is not updated, something went wrong"); ?>
    <?php endif; ?>

    <div class="form-group">
        <input value="<?php echo $post_data['post_title'] ?>" type="text" name="title" class="form-control" placeholder="post title">
    </div>
    <div class="form-group">
        <select name="post_category_id" id="post_category">
            <?php show_categories(); ?>
        </select>
    </div>
    <?php if(is_admin()): ?>
    <div class="form-group">
        <select name="post_user_id" id="">
        <?php
            $post_author_id = $post_data['post_user_id'];
            $author_post_name = get_post_user_by_user_id($post_author_id);
            if (isset($author_post_name) && !empty($author_post_name)) {
                echo "<option value='$post_author_id'>$author_post_name</option>";
            }
            get_users_options();
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
    <?php endif; ?>
    <div class="form-group">
        <img width="100" src="../images/<?php echo $post_data['post_image'] ?>" alt="">
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