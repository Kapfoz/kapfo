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
<div id="content">
<?php
include "../php/dbcon.php";

// Check if the database connection is successful
if (!$db) {
    // Handle the case where the connection fails
    echo "Error: Unable to connect to the database. Please try again later.";
    exit; // Exit the script
}

// Execute your database query
$result = mysqli_query($db, "SELECT * FROM uploadpost");

// Check if the query was successful
if ($result) {
    // Fetch data from the result set
    while ($row = mysqli_fetch_array($result)) {
        // Display the fetched data
        echo "<div class='row'>";
        echo "<div class='datetime'>";
        echo "<br>";
        echo "Date:" . $row['trn_date'];
        echo "</div>";

        if (!empty($row['text']) && !empty($row['image'])) {
            echo "<div class='column'>";
            echo "<p>" . $row['text'] . "</p>";
            echo "</div>";
            echo "<div class='column'>";
            echo "<div id='img_div'>";
            echo "<img src='../images/" . $row['image'] . "' >";
            echo "</div>";
            echo "</div>";
        } elseif (!empty($row['text'])) {
            echo "<div class='column'>";
            echo "<p>" . $row['text'] . "</p>";
            echo "</div>";
        } elseif (!empty($row['image'])) {
            echo "<div class='column'>";
            echo "<div id='img_div'>";
            echo "<img src='../images/" . $row['image'] . "' >";
            echo "</div>";
            echo "</div>";
        }

        // Button to collapse/expand all comments
        echo "<button class='collapse-comments-btn' data-post-id='" . $row['post_id'] . "'><i class='fas fa-comments'></i> View Comments</button>";

        // All comments section
        echo "<div id='all-comments-" . $row['post_id'] . "' class='comments-section' style='display: none;'>";
        echo "<h3>All Comments</h3>";
        // Retrieve comments for this post
        $post_id = $row['post_id'];
        $comments_result = mysqli_query($db, "SELECT * FROM comment WHERE post_id='$post_id' ORDER BY trn_date DESC");
        while ($comment_row = mysqli_fetch_array($comments_result)) {
            echo "<div class='commentbox'>";
            echo "<div class='commentbo'>";
            echo "&nbsp &nbsp Date: " . $comment_row["trn_date"];
            echo "<p>" . $comment_row['comment'] . "</p>";
            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
        echo "</div>"; // closing div for row
        echo "<hr>"; // Divider line
    }
}
?>
</div>

<script>
    $(document).ready(function(){
        $(".collapse-comments-btn").click(function(){
            var postId = $(this).data("post-id");
            $("#all-comments-" + postId).toggle();
        });
    });
</script>
