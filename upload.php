<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/media.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/myscript.js"></script>
</head>
<body>
<?php
// Create database connection
include "dbcon.php";

// Initialize message variable
$msg = "";

// If upload button is clicked ...
if (isset($_POST['upload'])) {

    // Get text
    $text = mysqli_real_escape_string($db, $_POST['text']);

    // Image file directory
    $target = "../images/" . basename($_FILES['image']['name']);

    // Get image name
    $image = $_FILES['image']['name'];
    $text = $_POST['text'];
    $trn_date = date("Y-m-d H:i:s");
    $posttitle =  $_POST['posttitle'];

    $sql = "INSERT INTO uploadpost (image, posttitle ,text, trn_date, user_id) VALUES ('$image', '$posttitle','$text', '$trn_date', '$user_id')";

    // Execute query
    mysqli_query($db, $sql); // Store data in database table

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $msg = "Image uploaded successfully";
    } else {
        $msg = "Failed to upload image";
    }

    // Redirect to prevent form resubmission
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

$result = mysqli_query($db, "SELECT * FROM uploadpost");
?>
<?php
include "upload.html";
?>
