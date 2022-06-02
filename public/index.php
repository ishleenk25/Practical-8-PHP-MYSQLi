<?php require_once("../includefiles/session.php"); ?>
<?php require_once("../includefiles/db.php"); ?>
<?php require_once("../includefiles/functions.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Widget Corp</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div id="header">
        <h1>Widget Corp</h1>
    </div>
<?php find_selected_page_from_subject(true); ?>
<div id="main">
    <div id="navigation">
        <?php echo public_navigation($current_subject, $current_page); ?>
    </div>
    <div id="page"> 
        <?php if($current_page) {?>
            <h2><?php echo htmlentities($current_page["menu_name"]); ?></h2>
            <?php echo nl2br(htmlentities($current_page["content"])); ?>
        <?php } else {?>
            <p>Welcome to Widget Corp, A Content Management System!</p>

        <?php }?>
    </div>
</div>
<div id="footer">
<span>
          Check out our similar work at:
        </span>
        <span>
        <a href="https://www.linkedin.com/in/anshul-gupta-64886a185/" title="LinkedIn" class="fa fa-linkedin" aria-hidden="true">Anshul Gupta</a><span class="sr-only">LinkedIn</span>
      </span>
      <span>
        <a href="https://www.github.com/anshulg954" title="Github" class="fa fa-github" aria-hidden="true">anshulg954</a><span class="sr-only">Github</span>
      </span>
      <span>
        <a href="https://www.hackerrank.com/anshulg954" title="HackerRank" class="fab fa-hackerrank" aria-hidden="true">anshulg954</a><span class="sr-only">HackerRank</span>
      </span><br/>  
</body>
</html>   
