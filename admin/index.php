<?php include "includes/header.php"; ?>
<?php include "functions.php" ?>

<?php
$posts_count = count_rows_filtered('posts', 'post_user_id', get_current_user_id());
$comment_count = count_rows_filtered('comments', 'comment_user_id', get_current_user_id());
$categories_count = count_rows_filtered('categories', 'category_user_id', get_current_user_id());
$posts_drafted_count = count_rows_by_user('posts', 'post_user_id', 'post_status', 'draft');
$posts_published_count = count_rows_by_user('posts', 'post_user_id', 'post_status', 'published');
$likes_count = count_rows_filtered('likes', 'user_id', get_current_user_id());
$comment_unnaproved_count = count_rows_by_user('comments', 'comment_user_id', 'comment_status', 'unapproved');

?>
<div id="wrapper">
    <?php include "includes/nav.php"; ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row mt-10 mb-10">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        welcome to user dashboard <?php echo get_current_username() ?>
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Posts</h5>
                            <p class="card-text">Published posts by me: <?php echo $posts_count ?></p>
                            <a href="posts.php?u_id=<?php echo get_current_user_id()?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Comments</h5>
                            <p class="card-text">Total comments that I wrote: <?php echo $comment_count ?></p>
                            <a href="comments.php?u_id=<?php echo get_current_user_id()?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Likes</h5>
                            <p class="card-text">Posts that I liked: <?php echo $likes_count ?></p>
                            <a href="likes.php?u_id=<?php echo get_current_user_id()?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
                <?php if (is_admin()) : ?>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Categories</h5>
                                <p class="card-text">All Categories <?php echo $categories_count ?></p>
                                <a href="likes.php" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
                <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
        </div>
    </div>
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
                    $element_text = ['all posts', 'published posts', 'drafted posts', 'comments', 'unapproved comments',  'categories'];
                    $element_count = [$posts_count, $posts_published_count, $posts_drafted_count, $comment_count, $comment_unnaproved_count,  $categories_count];
                    for ($i = 0; $i < 6; $i++) {
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