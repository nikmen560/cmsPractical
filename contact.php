 <?php include "includes/header.php"; ?>


 <!-- Navigation -->

 <?php include "includes/nav.php"; ?>


 <?php

    if (isset($_POST['submit'])) {
        $to = "nikmen560@gmail.com";
        $subject = mysqli_real_escape_string($conn, $_POST['subject']);
        $email = mysqli_real_escape_string($conn, "FROM: " . $_POST['email']);
        $body = mysqli_real_escape_string($conn, $_POST['body']);

        $msg = "First line of text\nSecond line of text";

        $body = wordwrap($body, 70);

        mail($to, $subject, $body, $email);
    }

    ?>


 <!-- Page Content -->
 <div class="container">

     <section id="login">
         <div class="container">
             <div class="row">
                 <div class="col-xs-6 col-xs-offset-3">
                     <div class="form-wrap">
                         <h1>Register</h1>
                         <form role="form" action="" method="post" id="login-form" autocomplete="off">
                             <div class="form-group">
                                 <label for="email" class="sr-only">Email</label>
                                 <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                             </div>
                             <div class="form-group">
                                 <label for="subject" class="sr-only">Subject</label>
                                 <input type="text" name="email" id="subject" class="form-control" placeholder="subject">
                             </div>
                             <div class="form-group">
                                 <textarea name="body" class="form-control" id="" cols="30" rows="10"></textarea>
                             </div>

                             <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Send">
                         </form>

                     </div>
                 </div> <!-- /.col-xs-12 -->
             </div> <!-- /.row -->
         </div> <!-- /.container -->
     </section>


     <hr>



     <?php include "includes/footer.php"; ?>