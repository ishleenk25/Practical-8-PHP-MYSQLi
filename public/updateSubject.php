<?php require_once("../includefiles/session.php"); ?>
<?php require_once("../includefiles/db.php"); ?>
<?php require_once("../includefiles/functions.php"); ?>
<?php require_once("../includefiles/validations.php"); ?>
<?php check_if_logged_in(); ?>
<?php find_selected_page_from_subject(); ?>
<?php 
    if(!$current_subject) {
        redirect_to("manageWebsiteContent.php");
    }
?>
<?php 
if (isset($_POST['submit'])) {
    $required_fields = array("menu_name", "position", "visible");
    validate_presences($required_fields);
    $fields_with_max_lengths = array("menu_name" => 30);
    validate_max_lengths($fields_with_max_lengths);
    if(empty($errors)) {
        $id = $current_subject["id"];
        $menu_name = mysql_prep($_POST['menu_name']);
        $position = (int) $_POST['position'];
        $visible = (int) $_POST['visible'];

        $query = "UPDATE subjects SET menu_name = '{$menu_name}', 
                position = {$position}, visible = {$visible} WHERE id = {$id} LIMIT 1";
                    
        $result = mysqli_query($connection, $query);
                    
        if ($result && mysqli_affected_rows($connection) >= 0) {
            $_SESSION["message"] = "Subject updated.";
            redirect_to("manageWebsiteContent.php");
        } else {
            $_SESSION["message"] = "Subject update failed.";
        }
    }
} 
?>
<?php $overview = "admin"; ?>
<?php include("../includefiles/header.php"); ?>
<div id="main">
    <div id="navigation">
        <?php echo navigation($current_subject, $current_page); ?>
    </div>
    <div id="page">
        <?php
            if(!empty($message)) {
                echo "<div class=\"message\">" . htmlentities($message) . "</div>";
            }
        ?>
        <?php echo error_handler($errors); ?>
        <h2>Edit Subject: <?php echo htmlentities($current_subject["menu_name"]); ?></h2>
        
        <form action="updateSubject.php?subject=<?php echo urlencode($current_subject["id"]); ?>" method="post">
            <p>Subject Name:
                <input type="text" name="menu_name" 
                    value="<?php echo htmlentities($current_subject["menu_name"]); ?>" />
            </p>
            <p>Position:
                <select name="position">
                <?php 
                    $subject_set = find_all_subjects(false);
                    $subject_count = mysqli_num_rows($subject_set);
                    for($count=1; $count <= $subject_count; $count++) 
                    {
                        echo "<option value=\"{$count}\"";
                        if($current_subject["position"] == $count) {
                            echo " selected";
                        }
                        echo ">{$count}</option>";
                    }
                ?>
                </select>            
            </p>
            <p>Visible:
                <input type="radio" name="visible" value="0" 
                    <?php if ($current_subject["visible"] == 0) {echo "checked"; } ?>/>No
                &nbsp;
                <input type="radio" name="visible" value="1" 
                    <?php if ($current_subject["visible"] == 1) {echo "checked"; } ?>/>Yes
            </p>
            <input type="submit" name="submit" value="Confirm Subject Updation" />
        </form>
        
        <br />
        <a href="manageWebsiteContent.php">Cancel</a>
        &nbsp;
        &nbsp;
        <a href="deleteaSubject.php?subject=<?php echo urlencode($current_subject["id"]); ?>" onclick="return confirm('Are you sure?');">Delete Subject</a>
    </div>
</div>
<?php include("../includefiles/footer.php"); ?>    
