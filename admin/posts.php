<?php include "includes/header.php"; ?>
<?php include "functions.php"; ?>


<div id="wrapper">

    <!-- Navigation -->


    <?php include "includes/nav.php"; ?>


    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12 mt-2">

                    <h1 class="page-header text-center">
                        My posts
                    </h1>

                    <?php

// TODO: delete queries through POST 


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
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<?php include "includes/footer_admin.php"; ?>