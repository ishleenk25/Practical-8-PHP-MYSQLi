<?php require_once("../includefiles/session.php"); ?>
<?php require_once("../includefiles/db.php"); ?>
<?php require_once("../includefiles/functions.php"); ?>
<?php check_if_logged_in(); ?>
<?php $overview = "admin"; ?>
<?php include("../includefiles/header.php"); ?>
<?php find_selected_page_from_subject(); ?>
<div id="main">
    <div id="navigation">
        <br />
        <a href="admin.php">&laquo; Main Menu</a><br />
        <?php echo navigation($current_subject, $current_page); ?>
        <br />
        <a href="addNewSubject.php">+ Add a Subject</a>
    </div>
    <div id="page">
    <?php echo message(); ?>
        <?php if($current_subject) {?>
            <h2>Manage Subject</h2>
            Menu Name: <?php echo htmlentities($current_subject["menu_name"]); ?><br />
            Position: <?php echo $current_subject["position"]; ?><br />
            Visible: <?php echo $current_subject["visible"] == 1 ? 'yes': 'no' ; ?><br />
            <br />
            <a style="margin-right:2em" href="updateSubject.php?subject=<?php echo urlencode($current_subject["id"]); ?>">Edit Subject</a>
             <div style="margin-top: 2em; border-top: 1px solid #000;">
                <h3>Page in this subject:</h3>
                <ul>
                    <?php 
                        $subject_pages = find_pages_for_subjects_admin_view($current_subject["id"]);
                        while ($page = mysqli_fetch_assoc($subject_pages)) {
                            echo "<li>";
                            $safe_page_id = urlencode($page['id']);
                            echo "<a href=\"manageWebsiteContent.php?page={$safe_page_id}\">";
                            echo htmlentities($page["menu_name"]);
                            echo "</a></li>";
                        }
                    ?>
                </ul>
                <br />
                + <a href="addNewPage.php?subject=<?php echo urlencode($current_subject["id"]);?>">
                Add a new page to this subject</a>
            </div>
        <?php } elseif($current_page) {?>
            <h2>Manage Page</h2>
            Menu Name: <?php echo htmlentities($current_page["menu_name"]); ?><br />
            Position: <?php echo $current_page["position"]; ?><br />
            Visible: <?php echo $current_page["visible"] == 1 ? 'yes': 'no' ; ?><br />
            Content:<br />
            <div class="view-content">
                <?php echo htmlentities($current_page["content"]); ?>
            </div>
            <br /><br />
            <a style="margin-right:2em" href="updatePage.php?page=<?php echo urlencode($current_page["id"]); ?>">Edit page</a>
            <?php } else {?>
            Please select a subject or a page.
        <?php }?>
    </div>
</div>

<?php include("../includefiles/footer.php"); ?>    
