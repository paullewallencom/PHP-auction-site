<?php
session_start();
require(“config.php”);
$db = mysql_connect($dbhost, $dbuser, $dbpassword);
mysql_select_db($dbdatabase, $db);
?>

<!DOCTYPE HTML PUBLIC “-//W3C//DTD HTML 4.01
        Transitional//EN” “http://www.w3.org/TR/html4/loose.dtd”>
<html>
<head>
    <title><?php echo $config_forumsname; ?></title>
    <link rel=”stylesheet” href=”stylesheet.css” type=”text/css” />
</head>
<body>
<div id=”header”>
    <h1>BidTastic Auctions</h1>
    <div id=”menu”>
        <a href=”index.php”>Home</a>
        <?php
        if(isset($_SESSION[‘USERNAME’]) == TRUE) {
            echo “<a href=’logout.php’>Logout</a>”;
}
else {
            echo “<a href=’login.php’>Login</a>”;
}
?>
        <a href=”newitem.php”>New Item</a>
    </div>
    <div id=”container”>
        <div id=”bar”>
            <?php require(“bar.php”); ?>
        </div>
        <div id=”main”>