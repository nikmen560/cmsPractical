<?php

function confirm_query($result)
{
    global $conn;
    if (!$result) {
        die("Query failed " . mysqli_error($conn));
    }
    return $result;
}


function insert_category()
{

    global $conn;
    if (isset($_POST['submit'])) {
        $new_category_name = $_POST['cat_title'];

        $stmt = mysqli_prepare($conn, "INSERT INTO categories (cat_title)  VALUES (?)");
        mysqli_stmt_bind_param($stmt, 's', $new_category_name);
        mysqli_stmt_execute($stmt);
    }
}

function find_all_categories()
{
    global $conn;
    $query = "SELECT * FROM categories";
    $categories = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($categories)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];

        echo
        "<tr>
        <th>$cat_id</th>
        <td>$cat_title</td>
        <td><a href='categories.php?delete=$cat_id'>Delete</a></td>
        <td><a href='categories.php?edit=$cat_id'>Edit</a></td>
        </tr>";
    }
}

function delete_category()
{

    global $conn;

    if (isset($_GET['delete'])) {
        $cat_id_delete = $_GET['delete'];
        $query = "DELETE FROM categories WHERE cat_id = $cat_id_delete";
        $delete_cat_query = mysqli_query($conn, $query);
        header("Location:categories.php");
    }
}
function show_all_posts()
{
    global $conn;
    $query = "SELECT posts.post_id, posts.post_author, posts.post_content, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, posts.post_tags, posts.post_comment_count, posts.post_date, posts.post_views_count, categories.cat_id, categories.cat_title FROM posts LEFT JOIN categories ON posts.post_category_id = categories.cat_id ORDER BY posts.post_id DESC";
    $posts = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($posts)) {
        $post_id = $row['post_id'];
        $post_category_id = $row['post_category_id'];
        $post_title = $row['post_title'];
        $post_author = $row['post_author'];
        $post_date = $row['post_date'];
        $post_image = $row['post_image'];
        $post_content = $row['post_content'];
        $post_content = mb_strimwidth($post_content, 0, 150);
        $post_tags = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_status = $row['post_status'];
        $post_views = $row['post_views_count'];
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        $count_post_comments = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM comments WHERE comment_post_id = $post_id"));

        echo
        "<tr>
            <td><input type='checkbox' class='checkBoxes' name='checkBoxArray[]' value='$post_id' id=''></td>
        <td>$post_id</td>
        <td>$post_author</td>
        <td>$post_title</td>

        <td>$cat_title</td>


        <td>$post_content</td>
        <td>$post_status</td>
        <td><img class='img-responsive' src='../images/$post_image'></td>
        <td>$post_tags</td>" .
            "<td>" .
            "<a href='post_comments.php?id=$post_id'>" .
            $count_post_comments .
            "</a>" .
            "</td>" .
            "<td>$post_date</td>
        <td>$post_views</td>
        <td><a href='../post.php?p_id=$post_id'>View post</a></td>
        <td><a onClick=\"javascript: return confirm('are you really want to delete'); \" href='posts.php?delete=$post_id'>Delete</a></td>
        <td><a href='posts.php?source=edit_post&p_id=$post_id'>Edit</a></td>
        </tr>";
    }
}



function delete_post()
{

    global $conn;

    if (isset($_GET['delete'])) {
        $post_id = $_GET['delete'];
        $query = "DELETE FROM posts WHERE post_id = $post_id";
        $delete_post = mysqli_query($conn, $query);
        header("Location:posts.php");
    }
}

function delete_comment()
{

    global $conn;
    if (isset($_GET['delete'])) {
        $delete_comment_id = $_GET['delete'];
        $query = "DELETE FROM comments WHERE comment_id = $delete_comment_id";
        $delete_query = mysqli_query($conn, $query);
        header("location:comments.php");
    }
}

function show_rows_count($tableQuery)
{

    global $conn;

    $query = "SELECT * FROM $tableQuery";
    $select_all = mysqli_query($conn, $query);

    return mysqli_num_rows($select_all);
}
function count_rows_filtered($tableQuery, $filterInTable, $filterString)
{
    global $conn;
    $query = "SELECT * FROM $tableQuery WHERE $filterInTable = '$filterString'";
    $select_all_filtered = mysqli_query($conn, $query);
    return $posts_draft_count_filtered = mysqli_num_rows($select_all_filtered);
}

function users_online()
{
    if (isset($_GET['onlineusers'])) {

        global $conn;
        if (!$conn) {
            session_start();
            include("../includes/db.php");

            $session = session_id();
            $time = time();
            $time_out_in_seconds = 05;
            $timeout = $time - $time_out_in_seconds;

            $query = "SELECT * FROM users_online WHERE session = '$session'";
            $send_query = mysqli_query($conn, $query);
            $count = mysqli_num_rows($send_query);

            if ($count == NULL) {
                mysqli_query($conn, "INSERT INTO users_online(session, time) VALUES ('$session', $time)");
            } else {

                mysqli_query($conn, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
            }

            $users_online_query  = mysqli_query($conn, "SELECT * FROM users_online WHERE time > '$timeout'");

            echo  mysqli_num_rows($users_online_query);
        }
    }
}
users_online();

function escape($string)
{
    global $conn;
    return  mysqli_real_escape_string($conn, trim($string));
}

function is_admin()
{
    global $conn;
    $user_id = $_SESSION['user_id'];

    if (is_logged_in()) {
        $query = "SELECT user_role FROM users WHERE user_id = $user_id";
        $row = mysqli_fetch_assoc(mysqli_query($conn, $query));
        if ($row['user_role'] == 'admin') {
            return true;
        } else {
            return false;
        }
    }
}
function register_user($username, $email, $password)
{
    global $conn;

    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
    $query = "INSERT INTO users (user_name, user_email, user_password, user_role) VALUES('$username', '$email', '$password', 'user')";
    $register_user_query = mysqli_query($conn, $query);

    if (!$register_user_query) {
        die("QUERY FAILED" . mysqli_error($conn));
    }
}


function is_exists($col_name, $table_name, $row_name)
{

    global $conn;
    $check_query = mysqli_query($conn, "SELECT $col_name FROM $table_name WHERE $col_name = '$row_name'");
    $result  = mysqli_fetch_assoc($check_query);

    return is_null($result) ? false : true;
}

// function login_user($username, $password)
// {
//     global $conn;


//     $query = "SELECT * FROM users WHERE user_name = '$username'";
//     $login_query = mysqli_query($conn, $query);
//     if (mysqli_num_rows($login_query) <= 0) {
//         // return false;
//                 echo "<script>alert('da')</script>";
//     } else {

//                 echo "<script>alert('net')</script>";
        // $row = mysqli_fetch_array($login_query); 
        //     $db_id = $row['user_id'];
        //     $db_user_name = $row['user_name'];
        //     $db_user_password = $row['user_password'];
        //     $db_user_firstname = $row['user_firstname'];
        //     $db_user_lastname = $row['user_lastname'];
        //     $db_user_email = $row['user_email'];
        //     $db_user_image = $row['user_image'];
        //     $db_user_role = $row['user_role'];
        //     $db_user_randSalt = $row['randSalt'];



        // if (password_verify($password, $db_user_password)) {
        //     $_SESSION['user_id'] = $db_id;
        //     $_SESSION['username'] = $db_user_name;
        //     $_SESSION['firstname'] = $db_user_firstname;
        //     $_SESSION['lastname'] = $db_user_lastname;
        //     $_SESSION['user_role'] = $db_user_role;
            
        //     print_r($_SESSION['username']);
        //     if(is_logged_in()) {
        //         echo "<script>alert('da')</script>";

        //     } else {
        //         echo "<script>alert('net')</script>";
        //     }


            // return true;
        // }
    // }
// }



function redirect($location)
{
    header("location:/$location");
    exit;
}

function is_method($method = null)
{
    if ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
        return true;
    }
    return false;
}
function is_logged_in()
{
    if (isset($_SESSION['user_role'])) {
        return true;
    }
    return false;
}

function user_loggedin_redirect($redirect_location = null)
{

    if (is_logged_in()) {
        redirect($redirect_location);
    }
}



function delete_user($user_id)
{
    echo "<td><a>dslkfj</a></td>";
    echo "<form action='' method='post'>";
    echo    "<input type='hidden' class='hidden d-none' name='user_id' value='$user_id'>";
    echo    "<td><input class='btn btn-danger' type='submit' value='Delete' name='delete'></td>";
    echo "</form>";
}


function fetch_records($result)
{
    return mysqli_fetch_assoc($result);
}

function get_current_username()
{
    return isset($_SESSION['user_role']) ? $_SESSION['username'] : null;
}

function get_current_user_id()
{
    return isset($_SESSION['user_role']) ? $_SESSION['user_id'] : null;
}

function count_rows_by_user($table_name, $column, ...$args)
{
    global $conn;
    $user_id = $_SESSION['user_id'];
    $result =  mysqli_query($conn, "SELECT * FROM $table_name WHERE $column = $user_id AND $args[0] = '$args[1]'");
    return mysqli_num_rows($result);
}

function add_columns_to_chart(...$args)
{
    $element_text = ['all posts', 'published posts', 'drafted posts', 'comments', 'unapproved comments',  'categories'];
    foreach ($args as $arg) {
        array_push($element_text, $arg);
    }

    print_r($element_text);
}
