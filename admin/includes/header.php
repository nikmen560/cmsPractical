
<?php ob_start(); ?>
<?php session_start(); ?>
<?php  include_once "../includes/db.php"; ?> 
<!-- db location changed -->
<?php

if(!isset($_SESSION['user_role'])) {
        header('location: ../index.php');
} else {
        $user_role = $_SESSION['user_role'];
    if(!strcmp($user_role, 'user')) {
        header('location: ../index.php');
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS by KENTHD admin</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link href="/cms/admin/css/sb-admin.css" rel="stylesheet">


    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/styles.css">


     <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


     <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
     <link href="../includes/summernote/summernote.min.css" rel="stylesheet">
     <!-- <link rel="stylesheet" href="../css/summernote.min.css"> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js" defer></script>  -->
    <script src="../includes/summernote/summernote.min.js" defer></script> 

</head>

<body>