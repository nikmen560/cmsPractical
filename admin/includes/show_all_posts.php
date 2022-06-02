                    <?php
    if (isset($_GET['delete'])) {
        delete_post();
    }
                    function get_all_posts($user_id = null)
                    {
                        global $conn;
                        if (is_null($user_id)) {
                            $query = "SELECT * FROM posts";
                        } else {
                            $query = "SELECT * FROM posts WHERE post_user_id = $user_id";
                        }
                        $result = mysqli_query($conn, $query);
                        return mysqli_fetch_all($result, MYSQLI_ASSOC);
                    }
                    if (isset($_GET['u_id'])) {
                        $user_id = $_GET['u_id'];
                        $posts = get_all_posts($user_id);
                    } else {
                        if (!is_admin()) {
                            redirect('cms/admin/index.php');
                        }
                        $posts = get_all_posts();
                    }
                    ?>
                    <div class="card-columns">
                        <?php foreach ($posts as $post) : ?>
                            <div class="card">
                                <img class="card-img-top" src="/cms/images/<?= $post['post_image'] ?>" alt="image <?= $post['post_title'] ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $post['post_title'] ?></h5>
                                    <p class="card-text"><?= $post['post_description'] ?></p>
                                </div>
                                <div class="card-footer">
                                    <div class="row justify-content-around">
                                    <p class="card-text"><small class="text-muted">Comments: <?= $post['post_comment_count'] ?></small></p>
                                    <p class="card-text"><small class="text-muted">Views: <?= $post['post_views_count'] ?></small></p>
                                    <p class="card-text"><small class="text-muted">Likes: <?= $post['post_likes'] ?></small></p>
                                    </div>
                                    <div class="btn-group btn-group-sm">
                                        <a href="/cms/post/<?=$post['post_id'] ?>" class="btn btn-info">View</a>
                                        <a href="/cms/admin/posts.php?source=edit_post&p_id=<?= $post['post_id'] ?>" class="btn btn-secondary">Edit</a>
                                        <?php if(is_admin()): ?>
                                        <a href="/cms/admin/posts.php?delete=<?=$post['post_id']?>" class="btn btn-danger">Delete</a>
                                        <?php else: ?>
                                        <a href="/cms/admin/posts.php?u_id=<?=$user_id?>&delete=<?=$post['post_id']?>" class="btn btn-danger">Delete</a>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php isset($_POST['checkBoxArray']) ? change_post_bulk() : null; ?>
                    <script src="../js/script.js"></script>