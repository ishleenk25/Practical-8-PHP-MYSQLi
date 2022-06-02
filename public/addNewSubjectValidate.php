<?php require_once("../includefiles/session.php"); ?>
<?php require_once("../includefiles/db.php"); ?>
<?php require_once("../includefiles/functions.php"); ?>
<?php require_once("../includefiles/validations.php"); ?>
<?php check_if_logged_in(); ?>

<?php 
if (isset($_POST['submit'])) {
    $menu_name = mysql_prep($_POST['menu_name']);
    $position = (int) $_POST['position'];
    $visible = (int) $_POST['visible'];
    $required_fields = array("menu_name", "position", "visible");
    validate_presences($required_fields);
    $fields_with_max_lengths = array("menu_name" => 30);
    validate_max_lengths($fields_with_max_lengths);
    if(!empty($errors)) {
        $_SESSION["errors"] = $errors;
        redirect_to("addNewSubject.php");
    }
    $query = "INSERT INTO subjects (menu_name, position, visible)
                VALUES ('{$menu_name}', {$position}, {$visible})";
                
    $result = mysqli_query($connection, $query);

    if ($result) {
        $_SESSION["message"] = "Subject Created Successfully.";
        redirect_to("manageWebsiteContent.php");
    } else {
        $_SESSION["message"] = "Subject Creation Failed!!!";
        redirect_to("addNewSubject.php");
    }

} else {
    redirect_to("addNewSubject.php");
}
?>

<?php if(isset($connection)) { mysqli_close($connection); } ?>