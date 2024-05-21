<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/media.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/myscript.js"></script>
    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>home</title>
</head>
<body>
    

<?php 
    include 'header.php'; 
?>
</div>


<div class="bodytop">
    <?php
include "slider.html";
    ?>
</div>
<div>
    <?php
include "divider.html";
    ?>
</div>


<div>
    <?php

    include 'uploadimginst.php'; 

?>
</div>


<div>
 <?php
 if (isset($_SESSION['username'])) {
    include 'footer.php'; 
 }
?>
</div>
</body>
</html>

