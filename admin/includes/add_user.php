<?php include "/cms/includes/alert.php"; ?>
<?php
if (isset($_POST['create_user'])) {
    $is_added = add_user();
}
?>
<div class="d-flex justify-content-center">

    <form action="" method="post" enctype="multipart/form-data">
    <?php if(isset($is_added) && $is_added == true) show_alert('success', 'user successfuly created' ); ?>
        <div class="form-group">
            <input type="text" name="user_name" class="form-control" placeholder="user name">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="user_password" placeholder="user password">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="user_firstname" placeholder="firstname">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="user_lastname" placeholder="last name">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="user_email" placeholder="email">
        </div>

        <div class="form-group">
            <input type="file" class="form-control" name="image" placeholder="user image">
        </div>

        <div class="form-group">
            <select name="user_role" id="user_role">
                <option value="admin">admin</option>
                <option value="user">user</option>
            </select>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="create_user" value="create">
        </div>
    </form>
</div>