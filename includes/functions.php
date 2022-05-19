
<?php

function image_placeholder($image)
{
    if (!$image) {
        return 'placeholder-image.png';
    } else {
        return $image;
    }
}

function is_user_logged_in()
{
    global $conn;
    if (isset($_SESSION['user_id'])) {

        $user_id = $_SESSION['user_id'];

        $query = "SELECT * FROM users WHERE user_id = $user_id";
        $execute = mysqli_query($conn, $query);
        if (mysqli_num_rows($execute) >= 1) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}


function selected_option($lang)
{
    if (isset($_SESSION['lang']) && $_SESSION['lang'] == $lang) {
        return "selected";
    }
}

function is_email_and_token_set()
{
    if (!isset($_GET['email']) && !isset($_GET['token'])) {
        redirect('/cms/index');
    }
}

function is_equal_tokens_then_return_user()
{
    $token = $_GET['token'];
    global $conn;
    if ($stmt = mysqli_prepare($conn, "SELECT user_name, user_email, token FROM users WHERE token = ?")) {

        mysqli_stmt_bind_param($stmt, "s", $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $username, $user_email, $token_db);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if (strcmp($token, $token_db)) {
            redirect('cms/index');
        }
    }
    return ['username' => $username, 'user_email' => $user_email];
}
function update_password($user_email){
    global $conn;

    $new_password = $_POST['password'];
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT, array('cost' => 12));
    if ($stmt = mysqli_prepare($conn, "UPDATE users SET token= '', user_password= ? WHERE user_email = ?")) {

        mysqli_stmt_bind_param($stmt, "ss", $hashed_password,  $user_email);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);

        return true;
    } else {
        return false;
    }
}

function log_in($username, $password)
{
    global $conn;


    $query = "SELECT * FROM users WHERE user_name = '$username'";
    $login_query = mysqli_query($conn, $query);
    if (mysqli_num_rows($login_query) <= 0) {
        return false;
    } else {

        $row = mysqli_fetch_array($login_query); 
            $db_id = $row['user_id'];
            $db_user_name = $row['user_name'];
            $db_user_password = $row['user_password'];
            $db_user_firstname = $row['user_firstname'];
            $db_user_lastname = $row['user_lastname'];
            $db_user_email = $row['user_email'];
            $db_user_image = $row['user_image'];
            $db_user_role = $row['user_role'];
            $db_user_randSalt = $row['randSalt'];



        if (password_verify($password, $db_user_password)) {
            $_SESSION['user_id'] = $db_id;
            $_SESSION['username'] = $db_user_name;
            $_SESSION['firstname'] = $db_user_firstname;
            $_SESSION['lastname'] = $db_user_lastname;
            $_SESSION['user_role'] = $db_user_role;
            $_SESSION['user_email'] = $db_user_email;
            return true;
        } else {
            return false;
        }
    }
}



?>