<form action="" method="post">
    <div class="table-responsive{-md}">
        <table class="table table-responsive-md table-bordered table-hover">
            <div id="bulkOptionsContainer" class="col-xs-4 form-group">
                <select class="form-control" name="post_status" id="bulkOptionsSelect">
                    <option value="published">Published</option>
                    <option value="draft">draft</option>
                    <option value="delete">delete</option>
                    <option value="clone">clone</option>
                    <option value="reset_views">reset views</option>
                </select>
            </div>
            <div class="col-xs-4 form-group">
                <input type="submit" name="submit" class="btn btn-success form-group" value="apply">
                <a href="posts.php?source=add_post" class="btn btn-primary form-group">Add New</a>
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

<?php isset($_POST['checkBoxArray']) ? change_post_bulk() : null; ?>


<script src="../js/script.js"></script>