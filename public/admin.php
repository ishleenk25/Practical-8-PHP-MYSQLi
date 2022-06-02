<?php require_once("../includefiles/session.php"); ?>
<?php require_once("../includefiles/functions.php"); ?>
<?php check_if_logged_in(); ?>
<?php $overview= "admin";?>
<?php include("../includefiles/header.php"); ?>
<div id="main">
    <div id="navigation">
        &nbsp;
    </div>
    <div id="page">
        <h2>Admin Menu</h2>
        <p>Welcome to the admin area, <?php echo htmlentities($_SESSION["username"]); ?>.</p>
        <ul>
            <li><a href="manageWebsiteContent.php">Manage Website Content</a></li>
            <li><a href="manageAdmins.php">Manage Admin Users</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</div>
<?php include("../includefiles/footer.php"); ?>    