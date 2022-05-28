<?php include "includes/header.php"; ?>
<?php include "functions.php"; ?>
<?php
if (!is_admin()) redirect("/cms/admin/index.php"); ?>
<?php
if (isset($_GET['source'])) {
    $source = $_GET['source'];
} else {
    $source = '';
}
?>
<?php include "includes/nav.php"; ?>


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center mt-5 mb-5">
            Users
        </h1>
    </div>
<?php
if (isset($_GET['source'])) {
    $source = $_GET['source'];
} else {
    $source = '';
}
switch ($source) {
    case 'add_user';
        include "includes/add_user.php";
        break;

    case 'edit_user';
        include "includes/edit_user.php";
        break;

    default:
        include "includes/view_all_users.php";
        break;
}
?>
</div>
<?php include "includes/footer_admin.php"; ?>