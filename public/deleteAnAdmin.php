<?php require_once("../includefiles/session.php"); ?>
<?php require_once("../includefiles/db.php"); ?>
<?php require_once("../includefiles/functions.php"); ?>
<?php check_if_logged_in();?>
<?php 
    $admin = find_admin_by_id($_GET["id"]);
    if(!$admin) {
        redirect_to("manageAdmins.php");
    }
    $id = $admin["id"];
    $query = "DELETE from admins WHERE id = {$id} LIMIT 1";
    $result = mysqli_query($connection, $query);
    if($result && mysqli_affected_rows($connection) == 1 ) {
        $_SESSION["message"] = "Admin Deleted Successfully!";
        redirect_to("manageAdmins.php");
    } else{
        $_SESSION["message"] = "Admin Deletion Failed!!!";
        redirect_to("manageAdmins.php");
    }	
?>