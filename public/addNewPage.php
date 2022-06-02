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
    $required_fields = array("menu_name", "position", "visible", "content");
    validate_presences($required_fields);
    $fields_with_max_lengths = array("menu_name" => 30);
    validate_max_lengths($fields_with_max_lengths);
    if(empty($errors)) {        
        $subject_id = $current_subject["id"];
        $menu_name = mysql_prep($_POST['menu_name']);
        $position = (int) $_POST['position'];
        $visible = (int) $_POST['visible'];
        $content = mysql_prep($_POST["content"]);
        $query = "INSERT INTO pages (subject_id, menu_name, position, visible, content)
        VALUES ({$subject_id}, '{$menu_name}', {$position}, {$visible}, '{$content}')";
        $result = mysqli_query($connection, $query);
        if ($result && mysqli_affected_rows($connection) >= 0) {
            $_SESSION["message"] = "Page Created Successfully.";
            redirect_to("manageWebsiteContent.php");
        } else {
            $_SESSION["message"] = "Page Creation Failed!!!";
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
        <?php echo message(); ?>
        <?php echo error_handler($errors); ?>
        <h2>Create Page</h2>
        <form action="addNewPage.php?subject=<?php echo urlencode($current_subject["id"]); ?>" method="post">
            <p>Menu Name:
                <input type="text" name="menu_name" value="" />
            </p>
            <p>Position:
                <select name="position">
                <?php 
                    $page_set = find_pages_for_subjects($current_subject["id"]);
                    $page_count = mysqli_num_rows($page_set);
                    for($count=1; $count <= ($page_count + 1); $count++) 
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
            <p>Content:<br />
                <textarea name="content" cols="80" rows="20"></textarea>
            </p>
            <input type="submit" name="submit" value="Add New Page!" />
        </form>
        <br />
        <a href="manageWebsiteContent.php?subject=<?php echo urlencode($current_subject["id"]); ?>">Cancel</a>
    </div>
</div>
<?php include("../includefiles/footer.php"); ?>    
