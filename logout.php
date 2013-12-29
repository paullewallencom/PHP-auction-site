<?php
session_start();
session_unregister(“USERNAME”);
require(“config.php”);
header(“Location: “ . $config_basedir);
?>