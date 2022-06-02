<?php 
	if(!isset($overview)){ 
		$overview = "public"; 
	} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Widget Corp <?php if ($overview == "admin") {echo "Admin";}?></title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   
</head>
<body>
    <div id="header">
        <h1>Widget Corp <?php if ($overview == "admin") {echo "Admin";}?></h1>
    </div>