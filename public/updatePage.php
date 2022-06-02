<?php require_once("../includefiles/session.php"); ?>
<?php require_once("../includefiles/db.php"); ?>
<?php require_once("../includefiles/functions.php"); ?>
<?php require_once("../includefiles/validations.php"); ?>
<?php check_if_logged_in(); ?>

<?php find_selected_page_from_subject(); ?>

<?php 
    if(!$current_page) {
        redirect_to("manageWebsiteContent.php");
    }
?>

<?php 
if (isset($_POST['submit'])) {
    $id = $current_page["id"];
    $menu_name = mysql_prep($_POST['menu_name']);
    $position = (int) $_POST['position'];
    $visible = (int) $_POST['visible'];
    $content = mysql_prep($_POST["content"]);
    $required_fields = array("menu_name", "position", "visible", "content");
    validate_presences($required_fields);
    $fields_with_max_lengths = array("menu_name" => 30);
    validate_max_lengths($fields_with_max_lengths);
    if(empty($errors)) {
        $query = "UPDATE pages SET menu_name = '{$menu_name}', 
                position = {$position}, visible = {$visible}, 
                content = '{$content}' WHERE id = {$id} LIMIT 1";
        $result = mysqli_query($connection, $query);
        if ($result && mysqli_affected_rows($connection) == 1) {
            $_SESSION["message"] = "Page updated.";
            redirect_to("manageWebsiteContent.php?page={$id}");
        } else {
            $_SESSION["message"] = "Page update failed.";
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
        <h2>Update Page: <?php echo htmlentities($current_page["menu_name"]); ?></h2>
        <form action="updatePage.php?page=<?php echo urlencode($current_page["id"]); ?>" method="post">
            <p>Menu Name:
                <input type="text" name="menu_name" 
                    value="<?php echo htmlentities($current_page["menu_name"]); ?>" />
            </p>
            <p>Position:
                <select name="position">
                <?php 
                    $page_set = find_pages_for_subjects($current_page["subject_id"]);
                    $page_count = mysqli_num_rows($page_set);
                    for($count=1; $count <= $page_count; $count++) 
                    {
                        echo "<option value=\"{$count}\"";
                        if($current_page["position"] == $count) {
                            echo " selected";
                        }
                        echo ">{$count}</option>";
                    }
                ?>
                </select>            
            </p>
            <p>Visible:
                <input type="radio" name="visible" value="0" 
                    <?php if ($current_page["visible"] == 0) {echo "checked"; } ?>/>No
                &nbsp;
                <input type="radio" name="visible" value="1" 
                    <?php if ($current_page["visible"] == 1) {echo "checked"; } ?>/>Yes
            </p>
            <p>Content:<br />
                <textarea name="content" cols="80" rows="20">
                    <?php echo htmlentities($current_page["content"]); ?>
                </textarea>
            </p>
            <input type="submit" name="submit" value="Confirm Page Updation" />
        </form>
        <br />
        <a href="manageWebsiteContent.php?page=<?php echo urlencode($current_page["id"]); ?>">Cancel</a>
        &nbsp;
        &nbsp;
        <a href="deleteaPage.php?page=<?php echo urlencode($current_page["id"]); ?>"
         onclick="return confirm('Are you sure?');">Delete Page</a>
    </div>
</div>

<?php include("../includefiles/footer.php"); ?>    
