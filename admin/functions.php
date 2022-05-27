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
    $query = "SELECT posts.post_id, posts.post_user_id, posts.post_content, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, posts.post_tags, posts.post_comment_count, posts.post_date, posts.post_views_count, categories.cat_id, categories.cat_title FROM posts LEFT JOIN categories ON posts.post_category_id = categories.cat_id ORDER BY posts.post_id DESC";
    $result = mysqli_query($conn, $query);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $post_id = $row['post_id'];
            $post_category_id = $row['post_category_id'];
            $post_title = $row['post_title'];
            $post_author = $row['post_user_id'];
            $post_date = $row['post_date'];
            $post_image = $row['post_image'];
            $post_content = $row['post_content'];
            $post_content = mb_strimwidth($post_content, 0, 60);
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
        <td><img style='width: 100px' class='img-responsive' src='../images/$post_image'></td>
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
    } else {
        echo mysqli_error($conn);
    }
}



function delete_post()
{

    global $conn;

        $post_id = $_GET['delete'];
        $user_id = $_GET['u_id'];
    if(is_admin() || ($_SESSION['user_id'] == $user_id)) {
        $query = "DELETE FROM posts WHERE post_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $post_id);
        mysqli_stmt_execute($stmt);
        redirect("cms/admin/posts.php?u_id={$_SESSION['user_id']}");
    }
}

function delete_comment()
{

    global $conn;
        $delete_comment_id = $_GET['delete'];
        $query = "DELETE FROM comments WHERE comment_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $delete_comment_id);
        mysqli_stmt_execute($stmt);
    redirect("cms/admin/comments.php?u_id={$_GET['u_id']}");
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
    $user_image = 'avatar.webp';
    $query = "INSERT INTO users (user_name, user_email, user_password, user_role, user_image) VALUES('$username', '$email', '$password', 'user', '$user_image')";
    $register_user_query = mysqli_query($conn, $query);

    if (!$register_user_query) {
        die("QUERY FAILED" . mysqli_error($conn));
    }
}
function update_password_profile($user_id, $password)
{

    global $conn;

    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
    $query = "UPDATE users SET user_password = '$password' WHERE user_id = $user_id";
    $update_query = mysqli_query($conn, $query);
}


function is_exists($col_name, $table_name, $row_name)
{

    global $conn;
    $check_query = mysqli_query($conn, "SELECT $col_name FROM $table_name WHERE $col_name = '$row_name'");
    $result  = mysqli_fetch_assoc($check_query);

    return is_null($result) ? false : true;
}



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

function add_post()
{

    global $conn;

    if (isset($_POST['create_post'])) {

        $post_title = escape($_POST['title']);

        $post_user_id = escape($_POST['author']);
        $post_category_id = escape($_POST['post_category_id']);
        $post_status = $_POST['post_status'];

        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];


        $post_tags = escape($_POST['post_tags']);
        $post_content = escape($_POST['post_content']);

        $post_date = date('d-m-y');

        move_uploaded_file($post_image_temp, "../images/$post_image");


        $query = "INSERT INTO posts (post_category_id, post_user_id, post_title, post_date, post_image,post_content,post_tags,post_status) 
    VALUES($post_category_id, $post_user_id, '$post_title',  now(), '$post_image', '$post_content', '$post_tags',  '$post_status')";

        // TODO: ESCAPE EVERY SQL QUERY
        // TODO: USE ONLY USER_ID OF IN DB not 3 fields.

        $add_post = mysqli_query($conn, $query);

        $post_id = mysqli_insert_id($conn);

        if (!$add_post) {
            die("poized " . mysqli_error($conn));
        } else {
            echo "<p class='bg-success'>Post created <a href='../post.php?p_id=$post_id'> View Post</a></p>";
        }
    }
}

function show_categories()
{
    global $conn;

    $query = "SELECT * FROM categories";
    $categories = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($categories)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<option value='$cat_id'>$cat_title</option>";
    }
}
function show_users()
{
    global $conn;

    $query = "SELECT * FROM users";
    $users = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($users)) {
        $user_id = $row['user_id'];
        $user_name = $row['user_name'];
        echo "<option value='$user_id'>$user_name</option>";
    }
}

function get_user()
{
    global $conn;
    $user_id = $_SESSION['user_id'];

    return mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE user_id = $user_id"));
}

function change_post_bulk_query($query, $post_id, $type_of_data, $bulk_options = null, ...$params)
{
    global $conn;
    if ($stmt = mysqli_prepare($conn, $query)) {
        if (!is_null($bulk_options)) {
            mysqli_stmt_bind_param($stmt, $type_of_data, $bulk_options, $post_id);
        } else if (!empty($params)) {
            mysqli_stmt_bind_param($stmt, $type_of_data, ...$params);
        } else {
            mysqli_stmt_bind_param($stmt, $type_of_data, $post_id);
        }
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        redirect('cms/admin/posts.php');
    } else {
        echo mysqli_error($conn);
    }
}

// TODO:DELETE AND VIEWS COUNT DOESNOT WORK

function change_post_bulk()
{

    global $conn;

    $bulk_options = $_POST['post_status'];

    $checkBoxArr = $_POST['checkBoxArray'];

    foreach ($checkBoxArr as $el) {


        switch ($bulk_options) {
            case 'published';
                $query = "UPDATE posts SET post_status = ? WHERE post_id = ?";
                change_post_bulk_query($query, $el, 'si', $bulk_options);
                break;
            case 'draft';
                $query = "UPDATE posts SET post_status = ? WHERE post_id = ?";
                change_post_bulk_query($query,  $el, 'si', $bulk_options);
                break;
            case 'delete';
                $query = "DELETE FROM posts WHERE post_id = ?";
                change_post_bulk_query($query, $el, 'i');
                break;
            case 'reset_views';
                $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = ?";
                change_post_bulk_query($query, $el, 'i');
                break;
            case 'clone';
                $query = "SELECT * FROM posts WHERE post_id = $el";
                $posts = mysqli_query($conn, $query);
                if (!$posts) {
                    echo mysqli_error($conn);
                }
                $row = mysqli_fetch_assoc($posts);
                $post_category_id = $row['post_category_id'];
                $post_title = $row['post_title'];
                $post_user_id = $row['post_user_id'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];
                $post_tags = $row['post_tags'];
                $post_status = $row['post_status'];
                $date = date("Y-m-d");

                $query = "INSERT INTO posts (post_category_id, post_title, post_user_id, post_date, post_image, post_content,post_tags,post_status) 
    VALUES(?, ?, ?, ?, ?, ?, ?, ?)";

                change_post_bulk_query($query, '', 'isisssss', null, $post_category_id, $post_title, $post_user_id, $date, $post_image, $post_content, $post_tags, $post_status);

                // if ($stmt = mysqli_prepare($conn, $query)) {

                //     mysqli_stmt_bind_param($stmt, 'isisssss', $post_category_id, $post_title, $post_user_id, $date, $post_image, $post_content, $post_tags, $post_status);
                //     mysqli_stmt_execute($stmt);
                //     mysqli_stmt_close($stmt);
                //     redirect('cms/admin/posts.php');
                // } else {
                //     echo mysqli_error($conn);
                // }
                break;
        }
    }
}

function get_post_by_p_id()
{
    global $conn;
    $post_id = $_GET['p_id'];
    $query = "SELECT * FROM posts WHERE post_id = $post_id";
    if ($posts = mysqli_query($conn, $query)) {
        return mysqli_fetch_assoc($posts);
    } else {
        die(mysqli_error($conn));
    }
}

function update_post()
{

    global $conn;

    $post_id = $_GET['p_id'];
    $post_title = $_POST['title'];
    $post_category_id = $_POST['post_category_id'];
    $post_date = date('d:m:y');
    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];
    $post_tags = $_POST['post_tags'];
    $post_content = $_POST['post_content'];
    move_uploaded_file($post_image_temp, "../images/$post_image");

    if (empty($post_image)) {
        $query = "SELECT * FROM posts WHERE post_id =$post_id ";
        $select_image = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($select_image);
        $post_image = $row['post_image'];
    }
    if(is_admin()) {
    $post_status = $_POST['post_status'];
    $post_user_id = $_POST['post_user_id'];
    $query = "UPDATE posts SET post_title = ?, post_category_id = ?, post_date = ?, post_user_id= ?, post_status = ?, post_tags = ?, post_content = ?, post_image = ? WHERE post_id = ?";
    $types = 'sisissssi';
    $args = [$post_title, $post_category_id, $post_date, $post_user_id, $post_status, $post_tags, $post_content, $post_image, $post_id];
    } else {
    $query = "UPDATE posts SET post_title = ?, post_category_id = ?, post_date = ?,  post_tags = ?, post_content = ?, post_image = ? WHERE post_id = ?";
    $types = 'sissssi';
    $args = [$post_title, $post_category_id, $post_date, $post_tags, $post_content, $post_image, $post_id];
    }
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, $types, ...$args);
        mysqli_stmt_execute($stmt);

        return true;
    } else {
        return false;
    }
}


function get_post_user_by_user_id($post_author_id)
{
    global $conn;
    $author_post_name_query = "SELECT user_name FROM users WHERE user_id = $post_author_id";
    if ($execute = mysqli_query($conn, $author_post_name_query)) {

        return mysqli_fetch_assoc($execute)['user_name'];
    } else {
        die(mysqli_error($conn));
    }
}

function get_users_options()
{
    global $conn;

    $query_users= "SELECT user_name, user_id FROM users";
    $users= mysqli_query($conn, $query_users);
    while($row = mysqli_fetch_assoc($users)) {
        $user_id = $row['user_id'];
        $user_name = $row['user_name'];
                echo "<option value='$user_id'>$user_name</option>";
    }
}

            function update_user_image()
            {
                global $conn;
                $user_image = $_FILES['image']['name'];
                $user_image_tmp = $_FILES['image']['tmp_name'];
                move_uploaded_file($user_image_tmp, "../images/$user_image");
                if (empty($user_image)) {
                    $query = "SELECT user_image FROM users WHERE user_id = {$_SESSION['user_id']}";
                    $select_image = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($select_image);
                    $user_image = $row['user_image'];
                }
                if($stmt = mysqli_prepare($conn, "UPDATE users SET user_image = ? WHERE user_id = {$_SESSION['user_id']}")) {

                mysqli_stmt_bind_param($stmt, 's', $user_image);
                mysqli_stmt_execute($stmt);
                return true;
                } else {
                    
                    mysqli_error($conn);
                    return false;
                }
            }
                                function update_user()
                                {
                                    global $conn;

                                    $user_firstname = $_POST['user_firstname'];
                                    $user_lastname = $_POST['user_lastname'];
                                    $user_email = $_POST['user_email'];

                                    if (!empty($_POST['user_password'])) {
                                        $password_to_hash = $_POST['user_password'];
                                        $user_password = password_hash($password_to_hash, PASSWORD_BCRYPT, array('cost' => 12));

                                        $query = "UPDATE users SET  user_firstname = ?, user_lastname= ?, user_password = ? user_email = ? WHERE user_id = {$_SESSION['user_id']}";
                                        $stmt = mysqli_prepare($conn, $query);
                                        mysqli_stmt_bind_param($stmt, 'ssss',  $user_firstname, $user_lastname, $user_password, $user_email);
                                    } else {
                                        $query = "UPDATE users SET  user_firstname = ?, user_lastname= ?, user_email = ? WHERE user_id = {$_SESSION['user_id']}";
                                        $stmt = mysqli_prepare($conn, $query);
                                        mysqli_stmt_bind_param($stmt, 'sss',  $user_firstname, $user_lastname,  $user_email);
                                    }
                                    if (mysqli_stmt_execute($stmt)) {
                                        return true;
                                    } else {
                                        return false;
                                    }
                                }
function get_comments()
{
    global $conn;
    $user_id = $_GET['u_id'];
    if (is_admin()) {
        $query = "SELECT * FROM comments ORDER BY comment_id DESC";
    } else {

        $query = "SELECT * FROM comments WHERE comment_user_id = $user_id  ORDER BY comment_id DESC";
    }
    $query = mysqli_query($conn, $query);
    return mysqli_fetch_all($query, MYSQLI_ASSOC);
}

function get_post_by_post_id($comment_post_id)
{

    global $conn;

    $query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
    $execute = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($execute);
}


function change_comment_status($comment_id, $action) {
    global $conn;
    $query = "UPDATE comments SET comment_status = ? WHERE comment_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'si', $action, $comment_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    redirect("cms/admin/comments.php?u_id={$_GET['u_id']}");

}