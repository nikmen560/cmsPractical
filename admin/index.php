<?php include "includes/header.php"; ?>
<?php include "functions.php" ?>

<?php
            $posts_count = count_rows_filtered('posts', 'post_user_id', get_current_user_id());
            $comment_count = count_rows_filtered('comments', 'comment_user_id', get_current_user_id()); 
$categories_count = count_rows_filtered('categories', 'category_user_id', get_current_user_id()); 
            $posts_drafted_count = count_rows_by_user('posts', 'post_user_id', 'post_status', 'draft');
            $posts_published_count = count_rows_by_user('posts', 'post_user_id','post_status', 'published');

            $comment_unnaproved_count = count_rows_by_user('comments', 'comment_user_id','comment_status', 'unapproved');

?>

<div id="wrapper">

    <!-- Navigation -->


    <?php include "includes/nav.php"; ?>


    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        welcome to user dashboard <?php echo get_current_username() ?>
                    </h1>
                </div>
            </div>
            <!-- /.row -->


            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">

                                        <div class='huge'><?php echo $posts_count ?></div>

                                    <div>Posts</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                        <div class='huge'><?php echo $comment_count = count_rows_filtered('comments', 'comment_user_id', get_current_user_id()); ?></div>
                                    <div>Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="comments.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                        <div class='huge'><?php echo $categories_count ?></div>
                                    <div>Categories</div>
                                </div>
                            </div>
                        </div>
                        <a href="categories.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>




        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php include "includes/footer_admin.php"; ?>


            <script type="text/javascript">

            $(document).ready(function() {
                google.charts.load('current', {
                    'packages': ['bar']
                });
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['', ''],
                        <?php
                        $element_text = ['all posts','published posts', 'drafted posts', 'comments', 'unapproved comments',  'categories'];
                        $element_count = [$posts_count,$posts_published_count, $posts_drafted_count, $comment_count, $comment_unnaproved_count,  $categories_count];
                        for($i = 0; $i < 6; $i++) {
                            echo "['$element_text[$i]'" . ", " . "$element_count[$i]],";
                        }

                        ?>
                    ]);
                    // TODO: FIX THIS

                    var options = {
                        chart: {
                            title: '',
                            subtitle: '',
                        }
                    };

                    var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                    chart.draw(data, google.charts.Bar.convertOptions(options));
                }
            })
            </script>