   <?php include "includes/header.php"; ?>
   <?php include "functions.php"; ?>


   <div id="wrapper">

       <!-- Navigation -->


       <?php include "includes/nav.php"; ?>


       <div id="page-wrapper">

           <?php $user_data = get_user(); ?>



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
                               <img src="../images/<?php if(isset($user_data['user_image'])) echo $user_data['user_image']; else echo "avatar.webp"; ?>" class="avatar img-circle img-thumbnail" alt="avatar">
                               <input type="file" class="text-center center-block file-upload">
                           </div>
                           </hr><br>


                           <div class="panel panel-default">
                               <div class="panel-heading">Website <i class="fa fa-link fa-1x"></i></div>
                               <div class="panel-body"><a href="http://bootnipets.com">bootnipets.com</a></div>
                           </div>


                           <ul class="list-group">
                               <li class="list-group-item text-muted">Activity <i class="fa fa-dashboard fa-1x"></i></li>
                               <li class="list-group-item text-right"><span class="pull-left"><strong>Shares</strong></span> 125</li>
                               <li class="list-group-item text-right"><span class="pull-left"><strong>Likes</strong></span> 13</li>
                               <li class="list-group-item text-right"><span class="pull-left"><strong>Posts</strong></span> 37</li>
                               <li class="list-group-item text-right"><span class="pull-left"><strong>Followers</strong></span> 78</li>
                           </ul>

                           <div class="panel panel-default">
                               <div class="panel-heading">Social Media</div>
                               <div class="panel-body">
                                   <i class="fa fa-facebook fa-2x"></i> <i class="fa fa-github fa-2x"></i> <i class="fa fa-twitter fa-2x"></i> <i class="fa fa-pinterest fa-2x"></i> <i class="fa fa-google-plus fa-2x"></i>
                               </div>
                           </div>

                       </div>
                       <!--/col-3-->
                       <div class="col-sm-9">
                           <ul class="nav nav-tabs">
                               <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
                           </ul>


                           <div class="tab-content">
                               <div class="tab-pane active">
                                   <hr>
                                   <form class="form" action="##" method="post">
                                       <div class="form-group">

                                           <div class="col-xs-6">
                                               <label for="first_name">
                                                   <h4>First name</h4>
                                               </label>
                                               <input type="text" class="form-control" name="first_name" placeholder="first name" title="enter your first name if any.">
                                           </div>
                                       </div>
                                       <div class="form-group">

                                           <div class="col-xs-6">
                                               <label for="last_name">
                                                   <h4>Last name</h4>
                                               </label>
                                               <input type="text" class="form-control" name="last_name" placeholder="last name" title="enter your last name if any.">
                                           </div>
                                       </div>

                                       <div class="form-group">
                                       </div>

                                       <div class="form-group">

                                           <div class="col-xs-6">
                                               <label for="email">
                                                   <h4>Email</h4>
                                               </label>
                                               <input type="email" class="form-control" name="email" placeholder="you@email.com" title="enter your email.">
                                           </div>
                                       </div>
                                       <div class="form-group">

                                           <div class="col-xs-6">
                                               <label for="password">
                                                   <h4>Password</h4>
                                               </label>
                                               <input type="password" class="form-control" name="password" placeholder="password" title="enter your password.">
                                           </div>
                                       </div>
                                       <div class="form-group">

                                           <div class="col-xs-6">
                                               <label for="password2">
                                                   <h4>Verify</h4>
                                               </label>
                                               <input type="password" class="form-control" name="password2" placeholder="password2" title="enter your password2.">
                                           </div>
                                       </div>
                                       <div class="form-group">
                                           <div class="col-xs-12">
                                               <br>
                                               <button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                                               <button class="btn btn-lg" type="reset"><i class="glyphicon glyphicon-repeat"></i> Reset</button>
                                           </div>
                                       </div>
                                   </form>

                                   <hr>

                               </div>
                               <!--/tab-pane-->
                               <div class="tab-pane" id="messages">

                                   <h2></h2>

                                   <hr>
                               </div>
                               <!--/tab-content-->








                               <?php

                                if (isset($_POST['update_user'])) {
                                    $user_name = $_POST['user_name'];
                                    $password_to_hash = $_POST['user_password'];
                                    // $user_password = password_hash($password_to_hash, PASSWORD_BCRYPT, array('cost' => 12));
                                    $user_firstname = $_POST['user_firstname'];
                                    $user_lastname = $_POST['user_lastname'];
                                    $user_email = $_POST['user_email'];
                                    $user_role = $_POST['user_role'];

                                    $user_image = $_FILES['image']['name'];
                                    $user_image_tmp = $_FILES['image']['tmp_name'];


                                    // $randSalt = $_POST['randSalt'];

                                    move_uploaded_file($user_image_tmp, "../images/$user_image");

                                    if (empty($user_image)) {
                                        $query = "SELECT * FROM users WHERE user_id = $user_id";

                                        $select_image = mysqli_query($conn, $query);

                                        while ($row = mysqli_fetch_assoc($select_image)) {
                                            $user_image = $row['user_image'];
                                        }
                                    }

                                    $query = "UPDATE users SET user_name = '$user_name',  user_firstname = '$user_firstname', user_lastname= '$user_lastname', user_email = '$user_email', user_image = '$user_image', user_role = '$user_role' WHERE user_id = $user_id";
                                    $update_post_query = mysqli_query($conn, $query);
                                }

                                ?>




                           </div>
                           <!-- /.container-fluid -->

                       </div>
                       <!-- /#page-wrapper -->

                   </div>
                   <?php include "includes/footer_admin.php"; ?>