<?php require_once("../includefiles/session.php"); ?>
<?php require_once("../includefiles/db.php"); ?>
<?php require_once("../includefiles/functions.php"); ?>
<?php require_once("../includefiles/validations.php"); ?>
<?php check_if_logged_in(); ?>

<?php 
    $admin = find_admin_by_id($_GET["id"]);

    if(!$admin) {
        redirect_to("manageAdmins.php");
    }
?>

<?php 
    if(isset($_POST['submit'])) {
        $required_fields = array("username", "password");
        validate_presences($required_fields);
        $fields_with_max_lengths = array("username" => 30);
        validate_max_lengths($fields_with_max_lengths);
        if (empty($errors)) {
            $id = $admin["id"];
            $username = mysql_prep($_POST["username"]);
            $hashed_password = encrypt_password($_POST["password"]);
            $query = "UPDATE admins SET ";
            $query .= "username = '{$username}', ";
            $query .= "hashed_password = '{$hashed_password}' ";
            $query .= "WHERE id= {$id} ";
            $query .= "LIMIT 1";
            $result = mysqli_query($connection, $query);
            if($result) {
                $_SESSION["message"] = "Admin Updated Successfully!";
                redirect_to("manageAdmins.php");
            } else{
                $_SESSION["message"] = "Admin Updation Failed!!!";
            }
        }
    } 
?>

<?php $overview = "admin"; ?>
<?php include("../includefiles/header.php"); ?>
<div id="main">
    <div id="navigation">
        &nbsp;
    </div>
    <div id="page">
        <?php echo message(); ?>
        <?php echo error_handler($errors); ?>
        <h2>Update Admin Details</h2>
        <form action="updateAdminDetails.php?id=<?php echo urlencode($admin["id"]); ?>" method="post">
            <p>Username:
                <input type="text" name="username" value="<?php echo htmlentities($admin["username"])?>" />
            </p>
            <p>Password:
                <input type="password" name="password" value="" />
            </p>
            <input type="submit" name="submit" value="Confirm Details Updation" />
        </form>
        <br />
        <a href="manageAdmins.php">Cancel</a>
    </div>
</div>
<?php include("../includefiles/footer.php"); ?>    

