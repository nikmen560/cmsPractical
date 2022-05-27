<?php
$user_id = $_GET['u_id'];
$comments = get_comments();

if (isset($_GET['delete']) && (is_admin() || $_GET['u_id'] === $_SESSION['user_id'])) { // delete comment
    delete_comment();
}
if (isset($_GET['approve'])) {
    $comment_id = $_GET['approve'];
    change_comment_status($comment_id,'approved');
}
if (isset($_GET['unapprove'])) {
    $comment_id = $_GET['unapprove'];
    change_comment_status($comment_id,'unapproved');
}
?>
<div class="row d-flex justify-content-center mt-100 mb-100">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title">My comments</h4>
            </div>
            <div class="comment-widgets">
                <?php
                foreach ($comments as $comment) :
                    $post = get_post_by_post_id($comment['comment_post_id']);
                ?>
                    <div class="card d-flex flex-row comment-row p-3">
                        <a href="/cms/post/<?= $post['post_id'] ?>">
                            <div class="p-2"><img src="/cms/images/<?= $post['post_image'] ?>" alt="user" width="50" class="rounded-circle"></div>
                        </a>
                        <div class="comment-text w-100">
                            <a href="/cms/post/<?= $post['post_id'] ?>">
                                <h6 class="font-medium"><?= $post['post_title'] ?></h6>
                            </a>
                            <span class="text-muted float-right"><?= $comment['comment_status'] ?></span>
                            <span class="m-b-15 d-block"><?= $comment['comment_content'] ?></span>
                            <div class="comment-footer"> 
                                <span class="text-muted float-right"><?= $comment['comment_date'] ?></span>
                                <a href="/cms/admin/comments.php?u_id=<?= $user_id ?>&delete=<?= $comment['comment_id'] ?>"></a>
                                <?php if(is_admin() && $comment['comment_status'] == 'unapproved'): ?>
                                    <a class="btn btn-success btn-sm" href="/cms/admin/comments.php?u_id=<?= $user_id ?>&approve=<?= $comment['comment_id'] ?>">Publish</a>
                                <?php elseif(is_admin() && $comment['comment_status'] == 'approved'): ?>
                                    <a class="btn btn-info btn-sm" href="/cms/admin/comments.php?u_id=<?= $user_id ?>&unapprove=<?= $comment['comment_id'] ?>">Unapprove</a>
                                <?php endif; ?>
                                <?php if(is_admin() || $_GET['u_id'] == $_SESSION['user_id']): ?>
                                    <a class="btn btn-danger btn-sm" href="/cms/admin/comments.php?u_id=<?= $user_id ?>&delete=<?= $comment['comment_id'] ?>">Delete</a>
                                    <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>