   <?php include "includes/header.php"; ?>
   <?php include "functions.php"; ?>
   <?php include "../includes/alert.php"; ?>

   <div id="wrapper">
       <?php include "includes/nav.php"; ?>
       <?php $user_data = get_user(); ?>

       <?php
        $posts_count = count_rows_filtered('posts', 'post_user_id', get_current_user_id());
        $likes_count = count_rows_filtered('likes', 'user_id', get_current_user_id());
        $comment_count = count_rows_filtered('comments', 'comment_user_id', get_current_user_id());
        if (isset($_POST['update_user_image'])) {
            update_user_image();
        }
        if (isset($_POST['update_user'])) {
            $is_updated = update_user();
        }
        ?>

       <div id="page-wrapper">
           <div class="container-fluid">
               <div class="container bootstrap snippet">
                   <div class="row">
                       <div class="col-sm-10">
                           <h1><?php echo $user_data['user_name'] ?></h1>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col-sm-3">
                           <!--left col-->
                           <div class="text-center">
                               <form action="" method="post" enctype="multipart/form-data">
                                   <img width="200" src="../images/<?php if (isset($user_data['user_image'])) echo $user_data['user_image'];
                                                                    else echo "avatar.webp"; ?>" class="avatar img-circle img-thumbnail" alt="avatar">
                                   <div class="form-group">
                                       <input type="file" name="image" class="text-center center-block file-upload">
                                   </div>
                                   <div class="form-group">
                                       <button class="btn btn-secondary" type="submit" name="update_user_image">Update photo</button>
                                   </div>
                               </form>
                           </div>
                           </hr><br>
                           <ul class="list-group">
                               <li class="list-group-item text-muted"><a href="index.php">Activity</a> <i class="fa fa-dashboard fa-1x"></i></li>
                               <li class="list-group-item text-right"><span class="pull-left"><strong>My comments</strong></span> <?php echo $comment_count; ?></li>
                               <li class="list-group-item text-right"><span class="pull-left"><strong>My likes</strong></span> <?php echo $likes_count; ?></li>
                               <li class="list-group-item text-right"><span class="pull-left"><strong>My posts</strong></span> <?php echo $posts_count; ?></li>
                           </ul>
                       </div>
                       <div class="col-sm-9">
                           <ul class="nav nav-tabs">
                               <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
                           </ul>
                           <div class="tab-content">
                               <div class="tab-pane active">
                                   <hr>
                                   <form class="form" action="" method="post">
                                       <div class="form-group">
                                           <div class="col-xs-6">
                                               <label for="first_name">
                                                   <h4>First name</h4>
                                               </label>
                                               <input type="text" class="form-control" name="user_firstname" placeholder="first name" title="enter your first name if any." value="<?= $user_data['user_firstname'] ?>">
                                           </div>
                                       </div>
                                       <div class="form-group">

                                           <div class="col-xs-6">
                                               <label for="last_name">
                                                   <h4>Last name</h4>
                                               </label>
                                               <input type="text" class="form-control" name="user_lastname" placeholder="last name" title="enter your last name if any." value="<?= $user_data['user_lastname'] ?>">
                                           </div>
                                       </div>

                                       <div class="form-group">

                                           <div class="col-xs-6">
                                               <label for="email">
                                                   <h4>Email</h4>
                                               </label>
                                               <input type="email" class="form-control" name="user_email" placeholder="you@email.com" title="enter your email." value="<?= $user_data['user_email'] ?>">
                                           </div>
                                       </div>
                                       <div class="form-group">

                                           <div class="col-xs-6">
                                               <label for="password">
                                                   <h4>Password</h4>
                                               </label>
                                               <input type="password" class="form-control" name="user_password" placeholder="password" title="enter your password.">
                                           </div>
                                       </div>
                                       <?php if (isset($is_updated) && $is_updated == false) : ?>
                                           <div class="form-group">
                                               <?php show_alert('danger', 'something went wrong'); ?>

                                           </div>
                                       <?php elseif (isset($is_updated) && $is_updated == true) : ?>
                                           <div class="form-group">
                                               <?php show_alert('success', 'you updated your profile'); ?>
                                           </div>
                                       <?php endif; ?>
                                       <div class="form-group">
                                           <div class="col-xs-12">
                                               <br>
                                               <button class="btn btn-lg btn-success" name="update_user" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                                               <button class="btn btn-lg" type="reset"><i class="glyphicon glyphicon-repeat"></i> Reset</button>
                                           </div>
                                       </div>
                                   </form>
                                   <hr>
                               </div>
                           </div>
                       </div>
                   </div>
                   <?php include "includes/footer_admin.php"; ?>