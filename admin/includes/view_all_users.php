<?php
if (!is_admin()) redirect('cms/admin/index.php');

if (isset($_POST['delete'])) delete_user();
if (isset($_GET['set_admin'])) set_admin();
if (isset($_GET['unset_admin'])) unset_admin();
?>

<table class="table table-bordered table-hover table-responsive">
    <thead>
        <tr>
            <th scope="col">User id</th>
            <th>username</th>
            <th>user_firstname</th>
            <th>user_lastname</th>
            <th>user_email</th>
            <th>user_image</th>
            <th>user_role</th>
            <th>edit</th>
            <th>delete</th>
            <th>Set admin</th>
            <th>Set user</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php show_all_users(); ?>
        </tr>
    </tbody>
</table>