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
    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<?php
// Check if a session is not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
    <?php
    // Check if the user is logged in (registered)
    if (isset($_SESSION['username'])) {
    ?>
   <div id="header">
        <div class="logo">
            <img src="../image/Nagaland_University_Logo.png">
        </div>
      
        <div class="tophead">Student's Forum</div>
        <span class="iconmenu">
            <a href="index.php">
                <i class="fas fa-home"></i>
            </a>
        </span>
        <span class="iconmenu">
            <a href="notification.php">
                <i class="fas fa-bell"></i>
            </a>
        </span>
        <span class="iconmenu">
            <a href="profile.php">
                <i class="fas fa-user"></i>
            </a>
        </span>
        <span class="iconmenu">
            <a href="about.php">
                <i class="fas fa-info-circle"></i>
            </a>
        </span>
    </div>
    <?php
    } else {
    ?>
    <div id="header">
        <div class="logo">
            <img src="../image/Nagaland_University_Logo.png">
        </div>
        <div class="tophead">Student's Forum</div>
        <span class="iconmenu">
            <a href="index.php">
                <i class="fas fa-home"></i>
            </a>
        </span>
        <span class="iconmenu">
            <a href="#" id="registrationButton">
                <i class="fas fa-user-plus"></i>
            </a>
        </span>
        <span class="iconmenu">
            <a href="about.php">
                <i class="fas fa-info-circle"></i>
            </a>
        </span>
        <span class="iconmenu">
            <a href="#" id="loginButton">
                <i class="fas fa-sign-in-alt"></i>
            </a>
        </span>
    </div>
    <?php
    }
    ?>

    <!-- Login Modal -->
    <div id="loginModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <!-- Include your login form here -->
                    <?php include 'login.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Modal -->
    <div id="registrationModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <!-- Include your registration form here -->
                    <?php include 'registration.php'; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
