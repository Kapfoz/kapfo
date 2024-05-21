<?php
ob_start(); // Start output buffering
// Start session
//session_start();

// Include database connection
include "dbcon.php";

// Initialize user_id from session if available
$user_id = isset($_SESSION['username']) ? $_SESSION['username'] : null;

// If upload button is clicked and user is logged in...
if (isset($_POST['upload']) && $user_id) {
    // Image file directory
    $target = "../images/" . basename($_FILES['image']['name']);
    
    // Get image name
    $image = $_FILES['image']['name'];
    $text = $_POST['text'];
    $trn_date = date("Y-m-d H:i:s");
    $posttitle =  $_POST['posttitle'];

    // Insert data into database
    $sql = "INSERT INTO uploadpost (image, posttitle ,text, trn_date, user_id) VALUES ('$image', '$posttitle','$text', '$trn_date', '$user_id')";
    mysqli_query($db, $sql); // Store data in database table

    // Upload image file
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $msg = "Image uploaded successfully";
    } else {
        $msg = "Failed to upload image";
    }
  // Redirect to prevent form resubmission
  echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}';</script>";
  exit;
}

// If comment button is clicked and user is logged in...
if (isset($_POST['comment_submit']) && $user_id) {
    // Get comment data
    $post_id = $_POST['post_id'];
    $comment_text = $_POST['comment_text'];
    $trn_date = date("Y-m-d H:i:s");

    // Insert comment into database
    $sql = "INSERT INTO comment (post_id, comment, trn_date, user_id) VALUES ('$post_id', '$comment_text', '$trn_date', '$user_id')";
    mysqli_query($db, $sql); // Store comment in database table
 // Redirect to prevent form resubmission
 echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}';</script>";
 exit;
}

// If delete post button is clicked and user is logged in...
if (isset($_POST['delete_post']) && $user_id) {
    $post_id = $_POST['post_id'];

    // Check if the user owns the post
    $check_query = "SELECT * FROM uploadpost WHERE post_id='$post_id' AND user_id='$user_id'";
    $result = mysqli_query($db, $check_query);
    if (mysqli_num_rows($result) > 0) {
        // User owns the post, delete it
        $delete_query = "DELETE FROM uploadpost WHERE post_id='$post_id'";
        mysqli_query($db, $delete_query);
        // Delete associated comments
        $delete_comments_query = "DELETE FROM comment WHERE post_id='$post_id'";
        mysqli_query($db, $delete_comments_query);
        // Set delete successful flag
        $delete_successful = true;
    }

  // Redirect to prevent form resubmission
echo "<script>window.location.href = 'deletesuccess.html';</script>";
exit;

}

// If delete comment button is clicked and user is logged in...
if (isset($_POST['delete_comment']) && $user_id) {
    $comment_id = $_POST['comment_id'];

    // Check if the user owns the comment
    $check_query = "SELECT * FROM comment WHERE comment_id='$comment_id' AND user_id='$user_id'";
    $result = mysqli_query($db, $check_query);
    if (mysqli_num_rows($result) > 0) {
        // User owns the comment, delete it
        $delete_query = "DELETE FROM comment WHERE comment_id='$comment_id'";
        mysqli_query($db, $delete_query);
        // Set delete successful flag
        $delete_successful = true;
    }
 // Redirect to prevent form resubmission
 echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}';</script>";
 exit;
}

// Retrieve data from database
$result = mysqli_query($db, "SELECT post_id, image,posttitle, text, trn_date, user_id FROM uploadpost ORDER BY trn_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/media.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="../js/myscript.js"></script>
</head>
<body>
    <div id="content">
        <?php
        while ($row = mysqli_fetch_array($result)) {
            echo "<div class='row'>";
            echo "<div class='datetime'>";
            echo "Author:" .$row['user_id'];
            echo "<br>";
            echo "Date:" . $row['trn_date'];
            echo "</div>";
            echo "<div>";
            echo "Title:" .$row['posttitle'];
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

            // If user is logged in and owns the post, show delete post button
            if ($user_id && $row['user_id'] == $user_id) {
                echo "<form method='post' action=''>";
                echo "<input type='hidden' name='post_id' value='" . $row['post_id'] . "'>";
                echo "<button type='submit' name='delete_post' class='delete-btn'>";
                echo "<i class='fas fa-trash-alt'></i>"; // Icon only
                echo "<span class='text desktop'>Delete Post</span>"; // Text
                echo "</button>";
                echo "</form>";
            }

            // If user is logged in, show "Write Comment" button
            if ($user_id) {
                echo "<button class='collapse-comment-btn' data-post-id='" . $row['post_id'] . "'>";
                echo "<i class='fas fa-comment'></i>"; // Icon only
                echo "<span class='text desktop'>Write Comment</span>"; // Text
                echo "</button>&nbsp &nbsp &nbsp";
            }

            // Button to collapse/expand all comments
            echo "<button class='collapse-comments-btn' data-post-id='" . $row['post_id'] . "'>";
            echo "<i class='fas fa-comments'></i>"; // Icon only
            echo "<span class='text desktop'>View Comments</span>"; // Text
            echo "</button>";

            // Comment input field
            if ($user_id) {
                echo "<div id='comment-input-" . $row['post_id'] . "' class='comments-section' style='display: none;'>";
                echo "<form method='post' action=''>";
                echo "<input type='hidden' name='post_id' value='" . $row['post_id'] . "'>";
                echo "<input type='text' name='comment_text' placeholder='Write a comment'>";
                echo "<input type='submit' name='comment_submit' value='Comment'>";
                echo "</form>";
                echo "</div>";
            }

            // All comments section
            echo "<div id='all-comments-" . $row['post_id'] . "' class='comments-section' style='display: none;'>";
            echo "<h3>All Comments</h3>";
            // Retrieve comments for this post
            $post_id = $row['post_id'];
            $comments_result = mysqli_query($db, "SELECT * FROM comment WHERE post_id='$post_id' ORDER BY trn_date DESC");
            while ($comment_row = mysqli_fetch_array($comments_result)) {
                echo "<div class='commentbox'>";
                echo "<div class='commentbo'>";
                echo "Author:" .$comment_row['user_id'];
                echo "&nbsp &nbsp Date: " . $comment_row["trn_date"];
                echo "<p>" . $comment_row['comment'] . "</p>";
                // If user is logged in and owns the comment, show delete comment button
                if ($user_id && $comment_row['user_id'] == $user_id) {
                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='comment_id' value='" . $comment_row['comment_id'] . "'>";
                    echo "<button type='submit' name='delete_comment' class='delete-bt'><i class='fas fa-trash-alt'></i></button>";
                    echo "</form>";
                }
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";

            echo "</div>"; // closing div for row
            echo "<hr >";
        }

        ?>
    </div>

    <script>
        // JavaScript to toggle the visibility of comment input field and comments section
        $(document).ready(function(){
            $(".collapse-comment-btn").click(function(){
                var postId = $(this).data("post-id");
                $("#comment-input-" + postId).toggle();
            });

            $(".collapse-comments-btn").click(function(){
                var postId = $(this).data("post-id");
                $("#all-comments-" + postId).toggle();
            });
        });
    </script>
</body>
</html>
