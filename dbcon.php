<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "kapfos";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
$db = mysqli_connect("localhost", "root", "", "kapfos");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

global $mysqli;

