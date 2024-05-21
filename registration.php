<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
   // session_start();
}

require('dbcon.php');

// Handle registration logic
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
    // removes backslashes
    $username = stripslashes($_POST['username']);
    //escapes special characters in a string
    $username = mysqli_real_escape_string($conn,$username); 
    $email = stripslashes($_POST['email']);
    $email = mysqli_real_escape_string($conn,$email);
    $password = stripslashes($_POST['password']);
    $password = mysqli_real_escape_string($conn,$password);
    $profession = stripslashes($_POST['profession']);
    $profession = mysqli_real_escape_string($conn,$profession);
    $address = stripslashes($_POST['address']);
    $address = mysqli_real_escape_string($conn,$address);
    $trn_date = date("Y-m-d H:i:s");
    
    $query = "INSERT into `users` (username, password, email, trn_date, profession, address)
    VALUES ('$username', '".md5($password)."', '$email', '$trn_date','$profession', '$address')";
    
    $result = mysqli_query($conn,$query);

    if($result){
        include "welcome.html";
    }
} else {
    include "registration.html"; // Display registration form
}
