<?php
require("header.php");
$verifystring = urldecode($_GET['verify']);
$verifyemail = urldecode($_GET['email']);

$sql = "SELECT id FROM users WHERE verifystring
= '" . $verifystring . "' AND email = '" .
        $verifyemail . "';";
$result = mysql_query($sql);
$numrows = mysql_num_rows($result);
if($numrows == 1) {
    $row = mysql_fetch_assoc($result);
    $sql = "UPDATE users SET active = 1 WHERE id = " . $row['id'];
    $result = mysql_query($sql);
    echo "Your account has now been verified.
You can now <a href='login.php'>log in</a>";
}else {
    echo "This account could not be verified.";
}
require("footer.php");
?>