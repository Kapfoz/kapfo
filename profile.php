<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page or display an error message
    header("Location: login.php");
    exit;
}

// Retrieve username from session
$username = $_SESSION['username'];

// Connect to database
$connection = mysqli_connect('localhost', 'root', '', 'kapfos');

// Check connection
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Prepare and execute query to fetch user's email based on username
$query = "SELECT email, profession, address FROM users WHERE username = ?";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if query was successful
if ($result) {
    // Fetch the first row from the result set
    $user = mysqli_fetch_assoc($result);
} else {
    // Display an error message if the query fails
    $user = array(); // Set $user to an empty array
    echo "Error: Unable to fetch user information.";
}

// Close statement
mysqli_stmt_close($stmt);

// Close database connection
mysqli_close($connection);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Profile Page</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="bodytop">
        <div class="profilecont">
         <div class="profileinner">
          <img src="../Image/user.png"><br>
             <?php echo $_SESSION['username'] ?><br>
            Email: <?php echo $user['email']; ?><br>
            Profession: <?php echo $user['profession']; ?><br>
            Address: <?php echo $user['address']; ?><br>

            <div class="logoutbtm">
                <a href="logout.php"><button>Logout</button></a>
            </div>
         </div>
        </div>
    </div>
</body>
</html>
