<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require('dbcon.php');

// Handle login logic
if (isset($_POST['username']) && isset($_POST['password'])) {
    // removes backslashes
    $username = stripslashes($_POST['username']);
    //escapes special characters in a string
    $username = mysqli_real_escape_string($conn,$username);
    $password = stripslashes($_POST['password']);
    $password = mysqli_real_escape_string($conn,$password);

    //Checking if the user exists in the database
    $query = "SELECT * FROM `users` WHERE username='$username' AND password='".md5($password)."'";
    $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    $rows = mysqli_num_rows($result);
    
    if($rows==1){
        $_SESSION['username'] = $username;
        // Redirect user to index.php
        header("Location: index.php");
        exit();
    } else {
        include "incorrectinput.html";
    }
} else {
    include "login.html"; // Display login form
}
