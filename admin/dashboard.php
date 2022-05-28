<?php include "includes/header.php"; ?>
<?php include "functions.php" ?>
<?php

$users_count = show_rows_count('users');
$posts_count = show_rows_count('posts');
$comments_count = show_rows_count('comments');
$categories_count = show_rows_count('categories');
$posts_drafted_count = count_rows_filtered('posts', 'post_status', 'draft');
$posts_published_count = count_rows_filtered('posts', 'post_status', 'published');

$comment_unnaproved_count = count_rows_filtered('comments', 'comment_status', 'unapproved');
$comment_approved_count = count_rows_filtered('comments', 'comment_status', 'approved');
$notAdmins_count = count_rows_filtered('users', 'user_role', 'user');


?>
<?php include "includes/nav.php"; ?>

    <div class="row mt-3">
        <div class="col-lg-12">
            <h1 class="page-header text-center mb-3">
                Dashboard
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Posts</h5>
                    <p class="card-text">Total Posts: <?php echo $posts_count ?></p>
                    <a href="posts.php" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Comments</h5>
                    <p class="card-text">Total comments: <?php echo $comments_count ?></p>
                    <a href="comments.php" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Categories</h5>
                    <p class="card-text">Total Categories <?php echo $categories_count ?></p>
                    <a href="categories.php" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6 mb-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Users</h5>
                    <p class="card-text">Total Users:<?php echo $users_count ?></p>
                    <a href="users.php" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
    </div>
    <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
<?php include "includes/footer_admin.php"; ?>

    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['bar']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['', ''],
                <?php
                $element_text = ['all posts', 'published posts', 'drafted posts', 'comments', 'unapproved comments', 'users', 'categories'];
                $element_count = [$posts_count, $posts_published_count, $posts_drafted_count, $comments_count, $comment_unnaproved_count, $notAdmins_count, $categories_count];
                for ($i = 0; $i < count($element_count); $i++) {
                    echo "['$element_text[$i]'" . ", " . "$element_count[$i]],";
                }

                ?>
            ]);

            var options = {
                chart: {
                    title: '',
                    subtitle: '',
                }
            };

            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>