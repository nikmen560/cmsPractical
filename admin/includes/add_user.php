<?php

if (isset($_POST['create_user'])) {

    $user_name = $_POST['user_name'];
    $user_password = password_hash($_POST['user_password'], PASSWORD_BCRYPT, array('cost' => 12));
    $user_firstname= $_POST['user_firstname'];
    $user_lastname= $_POST['user_lastname'];
    $user_email= $_POST['user_email'];

    $user_image = $_FILES['image']['name'];
    $user_image_temp = $_FILES['image']['tmp_name'];


    $user_role= $_POST['user_role'];


    move_uploaded_file($user_image_temp, "../images/$user_image");


    $query = "INSERT INTO users (user_name, user_password, user_firstname, user_lastname, user_email, user_image, user_role, randSalt) 
    VALUES('$user_name', '$user_password', '$user_firstname', '$user_lastname', '$user_email', '$user_image', '$user_role', '$randSalt')";

    $add_user  = mysqli_query($conn, $query);

    if(!$add_user) {
        die("poized " . mysqli_error($conn));
    }
}



?>


<form action="" method="post" enctype="multipart/form-data">

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
<?php include "includes/footer_admin.php"; ?>