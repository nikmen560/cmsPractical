<?php include "/cms/includes/alert.php"; ?>

<?php
    if (isset($_POST['create_post'])) {
        $is_added = add_post();

    }
?>

<form action="" method="post" enctype="multipart/form-data" onsubmit="return postForm()">

<?php if(isset($is_added) && $is_added) show_alert('success', "Post created");  ?>
    <div class="form-group">
        <input type="text" name="title" class="form-control" placeholder="post title">
    </div>

    <div class="form-group">
        <select name="post_category_id" id="post_category">
            <?php show_categories(); ?>
        </select>
    </div>
    <?php if(is_admin()): ?>
    <div class="form-group">
        <select name="author" id="post_author">
            <?php show_users()?>
        </select>
    </div>
    <div class="form-group">
        <select name="post_status" id="post_status">
            <option value="draft">draft</option>
            <option value="published">published</option>
        </select>
    </div>
    <?php endif; ?>
    <div class="form-group">
        <input type="file" class="form-control" name="image" placeholder="post image">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="post_tags" placeholder="post tags">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="post_description" placeholder="post description">
    </div>
    <!-- TODO: POST DESCRIPTION -->
    <div class="form-group">
        <textarea class="form-control" name="post_content" id="summernote" cols="30" rows="10" placeholder="post content"></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_post" value="publish post">
    </div>

</form>
