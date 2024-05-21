<?php
include "dbcon.php";
// Retrieve data from database
$result = mysqli_query($db, "SELECT * FROM uploadpost ORDER BY trn_date DESC");
?>

<div>
    <?php
include "header.php";

?>
<div class="bodytop">
<div id="notification">
    <?php
    while ($row = mysqli_fetch_array($result)) {
        echo "<div class='notbox'>";
        echo "<div class='notbox1'>";
        echo "<div class='datetime'>";
        echo "Someone Posted on: " . $row['trn_date'];
        echo "</div>";
        echo "<a href='../index.php'>";
        echo "Click here to view the post";
        echo "</a>";
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>
