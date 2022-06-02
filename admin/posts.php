<?php include "includes/header.php"; ?>
<?php include "functions.php"; ?>
    <?php include "includes/nav.php"; ?>
            <div class="row">
                <div class="col-lg-12 mt-2">

                    <h1 class="page-header text-center">
                    <?php if(!is_admin()): ?>
                        My posts 
                        <a href="/cms/admin/posts.php?source=add_post" class="btn btn-info">Add new post</a>
                    <?php else: ?>
                        Posts
                    <?php endif; ?>
                    </h1>

                    <?php
                    if (isset($_GET['source'])) {
                        $source = $_GET['source'];
                    } else {
                        $source = '';
                    }
                    switch ($source) {
                        case 'add_post';
                            include "includes/add_post.php";
                            break;

                        case 'edit_post';
                            include "includes/edit_post.php";
                            break;

                        default:
                            include "includes/show_all_posts.php";
                            break;
                    }
                    ?>
                </div>
            </div>
<?php include "includes/footer_admin.php"; ?>

<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 200
        });
    });
function postForm() {

	$('textarea[name="post_content"]').html($('#summernote').code());
}
</script>