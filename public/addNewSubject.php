<?php require_once("../includefiles/session.php"); ?>
<?php require_once("../includefiles/db.php"); ?>
<?php require_once("../includefiles/functions.php"); ?>
<?php check_if_logged_in(); ?>
<?php $overview = "admin"; ?>
<?php include("../includefiles/header.php"); ?>
<?php find_selected_page_from_subject(); ?>
<div id="main">
    <div id="navigation">
        <?php echo navigation($current_subject, $current_page); ?>
    </div>
    <div id="page">
        <?php echo message(); ?>
        <?php $errors = errors(); ?>
        <?php echo error_handler($errors); ?>
        <h2>Add New Subject</h2>
        <form action="addNewSubjectValidate.php" method="post">
            <p>Subject Name:
                <input type="text" name="menu_name" value="" />
            </p>
            <p>Position:
                <select name="position">
                <?php 
                    $subject_set = find_all_subjects();
                    $subject_count = mysqli_num_rows($subject_set);
                    for($count=1; $count <= ($subject_count + 1); $count++) 
                    {
                        echo "<option value=\"{$count}\">{$count}</option>";
                    }
                ?>
                </select>            
            </p>
            <p>Visible:
                <input type="radio" name="visible" value="0" />No
                &nbsp;
                <input type="radio" name="visible" value="1" />Yes
            </p>
            <input type="submit" name="submit" value="Create Subject"/>
        </form>
        <br />
        <a href="manageWebsiteContent.php">Cancel</a>
    </div>
</div>
<?php include("../includefiles/footer.php"); ?>    
