<? include "../functions.php"; ?>

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
        </tr>
    </thead>
    <tbody>
        <tr>
            <!-- show all users-->

            <?php
            if ($_SESSION['user_role'] === 'admin') {

                $query = "SELECT * FROM users ORDER BY user_id DESC";
                $users = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($users)) {
                    $user_id = $row['user_id'];
                    $user_name = $row['user_name'];
                    $user_firstname = $row['user_firstname'];
                    $user_lastname = $row['user_lastname'];
                    $user_email = $row['user_email'];
                    $user_image = $row['user_image'];
                    $user_role = $row['user_role'];



                    echo
                    "<tr>
        <td>$user_id</td>
        <td>$user_name</td>
        <td>$user_firstname</td>
        <td>$user_lastname</td>
        <td>$user_email</td>
        <td>$user_image</td>
        <td>$user_role</td>
        <td><a class='btn btn-primary' href='users.php?source=edit_user&u_id=$user_id'>Edit</a></td>
        <form action='' method='post'>
            <input type='hidden' class='hidden' name='user_id' value='$user_id'>
            <td><input class='btn btn-danger' type='submit' value='Delete' name='delete'></td>
        </form>
        <td><a class='btn btn-info' href='users.php?set_admin=$user_id'>set admin</a></td>
        <td><a class='btn btn-success' href='users.php?unset_admin=$user_id'>set user</a></td>
        </tr>";
                }
            ?>

                <!-- delete post -->
            <?php


                if (isset($_POST['delete'])) {
                    $user_id_to_delete = $_POST['user_id'];
                    $query = "DELETE FROM users WHERE user_id= $user_id_to_delete";
                    $delete_query = mysqli_query($conn, $query);
                    redirect("cms/admin/users.php");
                }

                if (isset($_GET['set_admin'])) {
                    $user_id = $_GET['set_admin'];
                    $query = "UPDATE users SET user_role = 'admin' WHERE user_id = $user_id";
                    $set_admin_query = mysqli_query($conn, $query);
                    redirect("cms/admin/users.php");
                }

                if (isset($_GET['unset_admin'])) {
                    $user_id = $_GET['unset_admin'];
                    $query = "UPDATE users SET user_role = 'user' WHERE user_id = $user_id";
                    $unset_admin_query = mysqli_query($conn, $query);
                    redirect("cms/admin/users.php");
                }
            }

            ?>




        </tr>
    </tbody>
</table>