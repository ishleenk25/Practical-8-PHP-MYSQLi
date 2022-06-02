<?php require_once("../includefiles/session.php"); ?>
<?php require_once("../includefiles/db.php"); ?>
<?php require_once("../includefiles/functions.php"); ?>
<?php check_if_logged_in(); ?>
<?php $admins = find_all_admins(); ?>
<?php $overview = "admin"; ?>
<?php include("../includefiles/header.php"); ?>
<div id="main">
    <div id="navigation">
        <br />
        <a href="admin.php">&laquo; Main Menu</a><br />
        <br />
    </div>
    <div id="page">
        <?php echo message(); ?>
        <h2>Manage Admins</h2>
        <table>
            <tr>
                <th style="text-align: left; width: 200px;">Username</th>
                <th colspan="2" style="text-align: left; width: 200px;">Actions</th>
            </tr>
            <?php while($admin = mysqli_fetch_assoc($admins)) { ?>
                <tr>
                    <td>
                        <?php echo htmlentities($admin["username"]); ?>
                    </td>
                    <td><a href="updateAdminDetails.php?id=<?php echo urlencode($admin["id"]); ?>">Edit</a></td>    
                    <td><a href="deleteAnAdmin.php?id=<?php echo urlencode($admin["id"]); ?>"
                    onclick="return confirm('You will not be able to redo this and will have to add the admin user again. Are you sure you want to delete?');">Delete</a></td>    
                </tr>
            <?php }?>
        </table>
        <br />
        <a href="addNewAdmin.php">Add new admin</a>
    </div>
</div>
<?php include("../includefiles/footer.php"); ?>    

