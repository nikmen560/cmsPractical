
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';

function image_placeholder($image)
{
    if (!$image) {
        return 'placeholder-image.png';
    } else {
        return $image;
    }
}

function user_image_placeholder($image)
{

    if (!$image) {
        return 'avatar.webp';
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
function update_password($user_email)
{
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


function get_post_user_by_id($user_id)
{
    global $conn;

    $query = "SELECT * FROM users WHERE user_id = $user_id";
    return mysqli_fetch_assoc(mysqli_query($conn, $query));
}

function update_post_views()
{
    global $conn;
    $post_id = $_GET['p_id'];

    $view_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = ?";
    if ($stmt = mysqli_prepare($conn, $view_query)) {

        mysqli_stmt_bind_param($stmt, 'i', $post_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

function get_post_by_get()
{
    global $conn;

    $post_id = $_GET['p_id'];
    $query = "SELECT * FROM posts WHERE post_id = $post_id";
    $execute = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($execute);
}

function add_new_comment()
{
    global $conn;
    $comment_user_id = $_SESSION['user_id'];
    $post_id = $_GET['p_id'];
    $comment_content = $_POST['comment_content'];
    $comment_date = date('Y-m-d');
    $query = "INSERT INTO comments (comment_post_id, comment_user_id, comment_content, comment_status, comment_date) VALUES (?, ?, ?, 'approved', ?)";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, 'iiss', $post_id, $comment_user_id, $comment_content, $comment_date);
        mysqli_stmt_execute($stmt);

        redirect("cms/post.php?p_id=$post_id");
    } else {
        echo mysqli_error($conn);
    }
}

function is_liked_by_user($post_id, $user_id)
{

    global $conn;
    $is_user_liked = mysqli_query($conn, "SELECT * FROM likes WHERE post_id = $post_id AND user_id=$user_id");
    if (mysqli_num_rows($is_user_liked) >= 1) {
        return true;
    } else {
        return false;
    }
}

function like_unlike_post()
{
    global $conn;

    $post_id = $_POST['post_id'];
    $select_query = "SELECT * FROM posts WHERE post_id = $post_id";
    $select_post = mysqli_query($conn, $select_query);
    $post_arr = mysqli_fetch_assoc($select_post);
    $user_id = $_POST['user_id'];

    $post_likes = $post_arr['post_likes'];

    if (is_liked_by_user($post_id, $user_id)) { //make a disslike

        mysqli_query($conn, "UPDATE posts SET post_likes = $post_likes-1 WHERE post_id=$post_id");
        mysqli_query($conn, "DELETE FROM likes  WHERE user_id = $user_id AND post_id=$post_id");
        return false;
    } else {

        mysqli_query($conn, "UPDATE posts SET post_likes = $post_likes+1 WHERE post_id=$post_id");
        mysqli_query($conn, "INSERT INTO likes (user_id, post_id) VALUES($user_id, $post_id)");
        return true;
    }
}

function get_user_by_id($user_id)
{
    global $conn;
    $query = mysqli_query($conn, "SELECT * FROM users WHERE user_id = $user_id");
    $arr = mysqli_fetch_array($query);
    return $arr;
}
function page_counter()
{
    global $conn;
    $post_query_count = "SELECT * FROM posts WHERE post_status = 'published'";
    $find_count = mysqli_query($conn, $post_query_count);
    $count = mysqli_num_rows($find_count);
    return $count = ceil($count / 5);
}
function page_counter_filtered($post_status, $category_id = null)
{
    global $conn;
    if (is_null($category_id)) {
        $post_query_count = "SELECT * FROM posts WHERE post_status = '$post_status'";
    } else {

        $post_query_count = "SELECT * FROM posts WHERE post_status = '$post_status' AND post_category_id = '$category_id'";
    }
    $find_count = mysqli_query($conn, $post_query_count);
    $count = mysqli_num_rows($find_count);
    return $count = ceil($count / 5);
}
function get_all_posts_by_author($user_id, $page_1, $per_page)
{
    global $conn;
    if (is_logged_in() && is_admin()) {
        $query = "SELECT * FROM posts WHERE post_user_id = $user_id LIMIT $page_1, $per_page";
    } else {
        $query = "SELECT * FROM posts WHERE post_user_id = $user_id AND post_status = 'published' LIMIT $page_1, $per_page";
    }
    $select_all_posts_query = mysqli_query($conn, $query);
    return mysqli_fetch_all($select_all_posts_query, MYSQLI_ASSOC);
}
function select_all_posts_paged($page_1, $per_page)
{
    global $conn;
    if (is_logged_in() && is_admin()) {
        $query = "SELECT * FROM posts LIMIT $page_1, $per_page";
    } else {
        $query = "SELECT * FROM posts WHERE post_status = 'published' LIMIT $page_1, $per_page";
    }
    $select_all_posts_query = mysqli_query($conn, $query);
    return mysqli_fetch_all($select_all_posts_query, MYSQLI_ASSOC);
}
function get_all_posts_by_category($page_1, $per_page)
{
    global $conn;
    $cat_id = $_GET['category_id'];
    if (is_logged_in() && is_admin()) {
        $query = "SELECT * FROM posts WHERE post_category_id = $cat_id LIMIT $page_1, $per_page";
    } else {
        $query = "SELECT * FROM posts WHERE post_category_id = $cat_id AND post_status = 'published' LIMIT $page_1, $per_page";
    }
    $select_all_posts_query = mysqli_query($conn, $query);
    return mysqli_fetch_all($select_all_posts_query, MYSQLI_ASSOC);
}

function get_post_comments($post_id)
{
    global $conn;
    $query = "SELECT * FROM comments WHERE comment_post_id= $post_id AND comment_status = 'approved' ORDER BY comment_id DESC ";
    $select_all_comments = mysqli_query($conn, $query);
    return mysqli_fetch_all($select_all_comments, MYSQLI_ASSOC);
}
function get_all_categories()
{
    global $conn;
    $query = "SELECT * FROM categories";
    $categories = mysqli_query($conn, $query);
    return mysqli_fetch_all($categories, MYSQLI_ASSOC);
}
function send_message($subject, $email, $body)
{
    $mail = new PHPMailer(true);
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = Config::SMTP_HOST;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = Config::SMTP_USER;                     //SMTP username
    $mail->Password   =  Config::SMTP_PASSWORD;                              //SMTP password
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = Config::SMTP_PORT;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->CharSet = 'UTF-8';

    //Recipients
    $mail->setFrom($email, 'User');
    $mail->addAddress('nik.kow@outlook.com', 'Project Author');     //Add a recipient
    $mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');
    //Attachments
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $body;

    if ($mail->send()) {
        return  true;
    } else {
        return false;
    }
}
function send_contact_me()
{
    global $conn;
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $body = mysqli_real_escape_string($conn, $_POST['body']);
    $body = wordwrap($body, 70);
    if (send_message($subject, $email, $body)) {
        return true;
    } else {
        return false;
    }
}



?>