 <?php include "includes/header.php"; ?>
 <?php include "includes/nav.php"; ?>
 <?php include "includes/alert.php"; ?>

 <?php if (isset($_POST['submit'])) $is_sent = send_contact_me(); ?>
 <div class="container">
     <section id="login">
     <?php if (isset($is_sent) && $is_sent) show_alert('success', 'message sent'); ?>
         <div class="container">
             <div class="row">
                 <div class="col-xs-6 col-xs-offset-3">
                     <div class="form-wrap">
                         <h1>Contact me </h1>
                         <form role="form" action="" method="post" id="login-form" autocomplete="off">
                             <div class="form-group">
                                 <label for="email" class="sr-only">Email</label>
                                 <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                             </div>
                             <div class="form-group">
                                 <input type="text" name="subject" id="subject" class="form-control" placeholder="subject">
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