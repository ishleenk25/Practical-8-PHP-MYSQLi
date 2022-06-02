
<?php

function error_handler($errors = array())
{
    $output = "";
    if (!empty($errors)) {
        $output .= "<div class=\"error\">";
        $output .= "Please fix the following errors:";
        $output .= "<ul>";
        foreach ($errors as $key => $error) {
            $output .= "<li>";
            $output .= htmlentities($error);
            $output .= "</li>";
        }
        $output .= "</ul>";
        $output .= "</div>";
    }
    return $output;
}

function find_all_subjects($public = true)
{
    global $connection;
    $query = "SELECT * ";
    $query .= "FROM subjects ";
    if ($public) {
        $query .= "WHERE visible = 1 ";
    }
    $query .= "ORDER BY position ASC";
    $subjects = mysqli_query($connection, $query);
    check_query_result($subjects);
    return $subjects;
}

function find_pages_for_subjects($subject_id, $public = true)
{
    global $connection;
    $final_subject_id = mysqli_real_escape_string($connection, $subject_id);
    $query = "SELECT * ";
    $query .= "FROM pages ";
    $query .= "WHERE subject_id = {$final_subject_id} ";
    if ($public) {
        $query .= "AND visible = 1 ";
    }
    $query .= "ORDER BY position ASC";
    $pages = mysqli_query($connection, $query);
    check_query_result($pages);
    return $pages;
}

function find_pages_for_subjects_admin_view($subject_id)
{
    global $connection;
    $final_subject_id = mysqli_real_escape_string($connection, $subject_id);
    $query = "SELECT * ";
    $query .= "FROM pages ";
    $query .= "WHERE subject_id = {$final_subject_id} ";
    $query .= "ORDER BY position ASC";
    $pages = mysqli_query($connection, $query);
    check_query_result($pages);
    return $pages;
}

function find_all_admins($public = true)
{
    global $connection;
    $query = "SELECT * ";
    $query .= "FROM admins ";
    $query .= "ORDER BY username ASC";
    $admins = mysqli_query($connection, $query);
    check_query_result($admins);
    return $admins;
}

function find_subject_by_id($subject_id, $public = true)
{
    global $connection;
    $final_subject_id = mysqli_real_escape_string($connection, $subject_id);
    $query = "SELECT * ";
    $query .= "FROM subjects ";
    $query .= "WHERE id = {$final_subject_id} ";
    if ($public) {
        $query .= "AND visible = 1 ";
    }
    $query .= "LIMIT 1";
    $subjects = mysqli_query($connection, $query);
    check_query_result($subjects);
    if ($subject = mysqli_fetch_assoc($subjects)) {
        return $subject;
    } else {
        return null;
    }
}

function find_page_by_id($page_id, $public = true)
{
    global $connection;
    $final_page_id = mysqli_real_escape_string($connection, $page_id);
    $query = "SELECT * ";
    $query .= "FROM pages ";
    $query .= "WHERE id = {$final_page_id} ";
    if ($public) {
        $query .= "AND visible = 1 ";
    }
    $query .= "LIMIT 1";
    $pages = mysqli_query($connection, $query);
    check_query_result($pages);
    if ($page = mysqli_fetch_assoc($pages)) {
        return $page;
    } else {
        return null;
    }
}

function find_admin_by_id($admin_id, $public = true)
{
    global $connection;
    $final_admin_id = mysqli_real_escape_string($connection, $admin_id);
    $query = "SELECT * ";
    $query .= "FROM admins ";
    $query .= "WHERE id = {$final_admin_id} ";
    $query .= "LIMIT 1";
    $admins = mysqli_query($connection, $query);
    check_query_result($admins);
    if ($admin = mysqli_fetch_assoc($admins)) {
        return $admin;
    } else {
        return null;
    }
}

function find_admin_by_username($username)
{
    global $connection;
    $final_username = mysqli_real_escape_string($connection, $username);
    $query = "SELECT * ";
    $query .= "FROM admins ";
    $query .= "WHERE username = '{$final_username}' ";
    $query .= "LIMIT 1";
    $admins = mysqli_query($connection, $query);
    check_query_result($admins);
    if ($admin = mysqli_fetch_assoc($admins)) {
        return $admin;
    } else {
        return null;
    }
}

function find_default_page_for_subject($subject_id)
{
    $pages = find_pages_for_subjects($subject_id);
    if ($first_page = mysqli_fetch_assoc($pages)) {
        return $first_page;
    } else {
        return null;
    }
}

function find_selected_page_from_subject($public = false)
{
    global $current_subject;
    global $current_page;
    if (isset($_GET["subject"])) {
        $current_subject = find_subject_by_id($_GET["subject"], $public);
        if ($current_subject && $public) {
            $current_page = find_default_page_for_subject($current_subject["id"]);
        } else {
            $current_page = null;
        }
    } elseif (isset($_GET["page"])) {
        $current_subject = null;
        $current_page = find_page_by_id($_GET["page"], $public);
    } else {
        $current_subject = null;
        $current_page = null;
    }
}

function navigation($subject_array, $page_array)
{
    $output = "<ul class=\"subjects\">";
    $get_all_subjects = find_all_subjects(false);
    while ($subject = mysqli_fetch_assoc($get_all_subjects)) {
        $output .= "<li";
        if ($subject_array && $subject['id'] == $subject_array['id']) {
            $output .= " class=\"selected\"";
        }
        $output .= ">";
        $output .= "<a href=\"manageWebsiteContent.php?subject=";
        $output .= urlencode($subject['id']);
        $output .= "\">";
        $output .= htmlentities($subject["menu_name"]);
        $output .= "</a>";
        $get_all_pages = find_pages_for_subjects_admin_view($subject['id']);
        $output .= "<ul class=\"pages\">";
        while ($page = mysqli_fetch_assoc($get_all_pages)) {
            $output .= " <li";
            if ($page_array && $page['id'] == $page_array['id']) {
                $output .= " class=\"selected\"";
            }
            $output .= ">";
            $output .= "<a href=\"manageWebsiteContent.php?page=";
            $output .= urlencode($page['id']);
            $output .= "\">";
            $output .= htmlentities($page["menu_name"]);
            $output .= "</a></li>";
        }
        $output .= "</ul></li>";
    }
    mysqli_free_result($get_all_subjects);
    $output .= "</ul>";
    return $output;
}

function public_navigation($subject_array, $page_array)
{
    $output = "<ul class=\"subjects\">";
    $get_all_subjects = find_all_subjects();
    while ($subject = mysqli_fetch_assoc($get_all_subjects)) {
        $output .= "<li";
        if ($subject_array && $subject['id'] == $subject_array['id']) {
            $output .= " class=\"selected\"";
        }
        $output .= ">";
        $output .= "<a href=\"index.php?subject=";
        $output .= urlencode($subject['id']);
        $output .= "\">";
        $output .= htmlentities($subject["menu_name"]);
        $output .= "</a>";
        if ($subject_array['id'] == $subject['id'] ||  $page_array['subject_id'] == $subject['id']) {
            $get_all_pages = find_pages_for_subjects($subject['id']);
            $output .= "<ul class=\"pages\">";
            while ($page = mysqli_fetch_assoc($get_all_pages)) {
                $output .= " <li";
                if ($page_array && $page['id'] == $page_array['id']) {
                    $output .= " class=\"selected\"";
                }
                $output .= ">";
                $output .= "<a href=\"index.php?page=";
                $output .= urlencode($page['id']);
                $output .= "\">";
                $output .= htmlentities($page["menu_name"]);
                $output .= "</a></li>";
            }
            $output .= "</ul>";
            mysqli_free_result($get_all_pages);
        }
        $output .= "</li>"; //end of subject li
    }
    mysqli_free_result($get_all_subjects);
    $output .= "</ul>";
    return $output;
}

function encrypt_password($password)
{
    $hash_format = "$2y$10$";
    $salt_length = 22;
    $salt = generate_salt($salt_length);
    $format_and_salt = $hash_format . $salt;
    $hash = crypt($password, $format_and_salt);
    return $hash;
}

function generate_salt($length)
{
    $unique_random_string = md5(uniqid(mt_rand(), true));
    $base64_string = base64_encode($unique_random_string);
    $modified_base64_string = str_replace('+', '.', $base64_string);
    $salt = substr($modified_base64_string, 0, $length);
    return $salt;
}

function check_password($password, $existing_hash)
{
    $hash = crypt($password, $existing_hash);
    $hash_from_db = md5($password);
    $hash_sub = substr($hash, 0, 32);
    if (($hash_sub == $existing_hash) || ($hash_from_db == $existing_hash)) {
        return true;
    } else {
        return false;
    }
}

function login_attempt($username, $password)
{
    $admin = find_admin_by_username($username);
    if ($admin) {
        if (check_password($password, $admin["hashed_password"])) {
            echo ($password);
            return $admin;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function is_logged_in()
{
    return isset($_SESSION['admin_id']);
}

function check_if_logged_in()
{
    if (!is_logged_in()) {
        redirect_to("login.php");
    }
}


function redirect_to($loc)
{
    header("Location: " . $loc);
    exit;
}

function mysql_prep($string)
{
    global $connection;
    $escaped_string = mysqli_real_escape_string($connection, $string);
    return $escaped_string;
}

function check_query_result($output)
{
    if (!$output) {
        die("Database Query Failed");
    }
}
?>