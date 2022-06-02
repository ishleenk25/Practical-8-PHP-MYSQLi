<?php require_once("../includefiles/session.php"); ?>
<?php require_once("../includefiles/db.php"); ?>
<?php require_once("../includefiles/functions.php"); ?>
<?php check_if_logged_in(); ?>
<?php 
    $current_subject = find_subject_by_id($_GET["subject"], false);
    if(!$current_subject) {
        redirect_to("manageWebsiteContent.php");
    }
    $pages_set = find_pages_for_subjects($current_subject["id"]);
    if(mysqli_num_rows($pages_set) > 0) {
        $_SESSION["message"] = "Can't delete a subject having pages.";
        redirect_to("manageWebsiteContent.php?subject={$current_subject["id"]}");        
    }
    $id = $current_subject["id"];
    $query = "DELETE FROM subjects WHERE id = {$id} LIMIT 1";
    $result = mysqli_query($connection, $query);
    if ($result && mysqli_affected_rows($connection) == 1) {
        $_SESSION["message"] = "Subject Deleted Successfully!";
        redirect_to("manageWebsiteContent.php");
    } else {
        $_SESSION["message"] = "Subject Deletion Failed!!!";
        redirect_to("manageWebsiteContent.php?subject={$id}");
    }
?>