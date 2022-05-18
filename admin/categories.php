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
                        Welcome to admin
                       <small>Author</small>
                    </h1>
                    <div class="col-xs-6">


                        <?php insert_category(); ?>



                        <form action="categories.php" method="post">
                            <div class="form-group">
                                <input type="text" name="cat_title" class="form-control" placeholder="catergory title">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" value="add Category" class="btn btn-primary">
                            </div>
                        </form>




                        <!-- update category  -->
                        <?php

                        if (isset($_GET['edit'])) {

                            $cat_id = $_GET['edit'];

                            include "includes/update_category.php";
                        }


                        ?>



                    </div>

                    <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Category title</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <!-- show all categories -->
                                    <?php find_all_categories(); ?>


                                    <!-- delete category -->
                                    <?php delete_category(); ?>



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
<!-- /#wrapper -->


<?php include "includes/footer_admin.php"; ?>