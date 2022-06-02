<?php require_once("../includefiles/session.php"); ?>
<?php require_once("../includefiles/db.php"); ?>
<?php require_once("../includefiles/functions.php"); ?>
<?php require_once("../includefiles/validations.php"); ?>
<?php check_if_logged_in(); ?>
<?php 
    if(isset($_POST['submit'])) {
        $required_fields = array("username", "password");
        validate_presences($required_fields);
        $fields_with_max_lengths = array("username" => 30);
        validate_max_lengths($fields_with_max_lengths);
        if (empty($errors)) {
            $username = mysql_prep($_POST["username"]);
            $hashed_password = encrypt_password($_POST["password"]);
            $query = "INSERT INTO admins ( ";
            $query .= "username, hashed_password ";
            $query .= ") VALUES ( ";
            $query .= "'{$username}', '{$hashed_password}' ";
            $query .= ")";
            $result = mysqli_query($connection, $query);

            if($result) {
                $_SESSION["message"] = "Admin User Created Successfully!";
                redirect_to("manageAdmins.php");
            } else{
                $_SESSION["message"] = "Admin Creation Failed!!!";
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

        <h2>Create New Admin</h2>
        <form action="addNewAdmin.php" method="post">
            <p>Username:
                <input type="text" name="username" value="" />
            </p>
            <p>Password:
                <input type="password" name="password" value="" />
            </p>
            <input type="submit" name="submit" value="Make Admin" />
        </form>
        <br />
        <a href="manageAdmins.php">Cancel</a>
    </div>
</div>

<?php include("../includefiles/footer.php"); ?>    

