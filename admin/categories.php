<?php include "includes/header.php"; ?>
<?php include "functions.php"; ?>
<?php include "includes/nav.php"; ?>

<?php if (isset($_POST['submit'])) insert_category(); ?>
<?php
if (isset($_GET['edit'])) {
    $cat_id = $_GET['edit'];
    include "includes/update_category.php";
}
?>

<?php if (isset($_GET['delete'])) {
    delete_category();
}
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center mt-5 mb-5">
            Categories
        </h1>
        <div class="col-xs-6">
            <form action="categories.php" method="post">
                <div class="form-group">
                    <input type="text" name="cat_title" class="form-control" placeholder="catergory title">
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="add Category" class="btn btn-primary">
                </div>
            </form>
        </div>
        <div class="col-xs-6">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Category title</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <!-- show all categories -->
                        <?php find_all_categories(); ?>


                        <!-- delete category -->



                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "includes/footer_admin.php"; ?>