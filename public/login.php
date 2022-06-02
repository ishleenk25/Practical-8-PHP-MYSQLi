<?php require_once("../includefiles/session.php"); ?>
<?php require_once("../includefiles/db.php"); ?>
<?php require_once("../includefiles/functions.php"); ?>
<?php require_once("../includefiles/validations.php"); ?>
<?php 
    $username = "";
    if(isset($_POST['submit'])) {
        $required_fields = array("username", "password");
        validate_presences($required_fields);
        if (empty($errors)) {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $found_admin = login_attempt($username, $password);
            if($found_admin) {
                $_SESSION["admin_id"] = $found_admin["id"];
                $_SESSION["username"] = $found_admin["username"];
                redirect_to("admin.php");
            } else{
                $_SESSION["message"] = "Username/Password not found.";
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
        <h2>Login</h2>
        <form action="login.php" method="post">
            <p>Username:
                <input type="text" name="username" value="<?php echo htmlentities($username); ?>" />
            </p>
            <p>Password:
                <input type="password" name="password" value="" />
            </p>
            <input type="submit" name="submit" value="Submit" />
        </form>
    </div>
</div>
<?php include("../includefiles/footer.php"); ?>    

