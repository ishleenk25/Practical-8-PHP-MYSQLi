<?php require_once("../includefiles/session.php"); ?>
<?php require_once("../includefiles/db.php"); ?>
<?php require_once("../includefiles/functions.php"); ?>
<?php check_if_logged_in(); ?>
<?php 
    $current_page = find_page_by_id($_GET["page"], false);
    if(!$current_page) {
        redirect_to("manageWebsiteContent.php");
    }
    $pages_set = find_pages_for_subjects($current_page["id"]);
    if(mysqli_num_rows($pages_set) > 0) {
        $_SESSION["message"] = "Can't delete a page with pages.";
        redirect_to("manageWebsiteContent.php?page={$current_page["id"]}");        
    }
    $id = $current_page["id"];
    $query = "DELETE FROM pages WHERE id = {$id} LIMIT 1";
    $result = mysqli_query($connection, $query);  
    if ($result && mysqli_affected_rows($connection) == 1) {
        $_SESSION["message"] = "Page Deleted Successfully!";
        redirect_to("manageWebsiteContent.php");
    } else {
        $_SESSION["message"] = "Page Deletion Failed!!";
        redirect_to("manageWebsiteContent.php?page={$id}");
    }
?>