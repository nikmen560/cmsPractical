<?php

if (isset($_GET['u_id'])) {
    $user_id = $_GET['u_id'];
    global $conn;
    $query = "SELECT * FROM users WHERE user_id = $user_id";
    $user = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($user)) {
        $user_id = $row['user_id'];
        $user_name = $row['user_name'];
        $user_password = $row['user_password'];




        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
    }
}
if (isset($_POST['update_user'])) {

    $user_id = $_GET['u_id'];
    $user_name = $_POST['user_name'];
    $user_password = $_POST['user_password'];
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_email = $_POST['user_email'];
    $user_role = $_POST['user_role'];
    $user_image = $_FILES['image']['name'];
    $user_image_tmp = $_FILES['image']['tmp_name'];

    move_uploaded_file($user_image_tmp, "../images/$user_image");


    if (empty($user_image)) {
        $query = "SELECT * FROM users WHERE user_id = $user_id";
        $select_image = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($select_image)) {
            $user_image = $row['user_image'];
        }
    }
    if (empty($user_password)) {
        echo "<h6>password field cannot be empty</h6>";
    } else {

        $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));

        $query = "UPDATE users SET user_name = '$user_name', user_password = '$hashed_password', user_firstname = '$user_firstname', user_lastname= '$user_lastname', user_email = '$user_email', user_image = '$user_image', user_role = '$user_role' WHERE user_id = $user_id";
        $update_post_query = mysqli_query($conn, $query);
    }
}

?>



<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <input type="text" name="user_name" class="form-control" value="<?php echo $user_name ?>" placeholder="user name">
    </div>
    <div class="form-group">
        <input type="password" autocomplete="off" class="form-control" name="user_password" value="" placeholder="user password">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="user_firstname" placeholder="firstname" value="<?php echo $user_firstname ?>">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="user_lastname" placeholder="last name" value="<?php echo $user_lastname ?>">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="user_email" placeholder="email" value="<?php echo $user_email ?>">
    </div>

    <div class="form-group">
        <img width="100" src="../images/<?php echo $user_image ?>" alt="">
        <input type="file" name="image">
    </div>

    <div class="form-group">
        <select name="user_role" id="">
            <option value="<?php echo $user_role ?>"><?php echo $user_role ?></option>
            <?php
            if ($user_role == 'admin') {

                echo "<option value='user'>user</option>";
            } else {
                echo "<option value='admin'>admin</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_user" value="update">
    </div>

</form>
<?php include "includes/footer_admin.php"; ?>