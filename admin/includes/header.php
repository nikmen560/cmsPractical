<?php ob_start(); ?>
<?php session_start(); ?>
<?php include_once "../includes/db.php"; ?>

<?php

if (!isset($_SESSION['user_role'])) {
    header('location: ../index.php');
} 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CMS by KENTHD </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="/cms/admin/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="../includes/summernote/summernote.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
