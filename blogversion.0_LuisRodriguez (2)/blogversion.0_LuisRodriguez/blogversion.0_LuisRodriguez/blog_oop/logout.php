<?php
require_once('includes/bootstrap.php');
$session->logout();
//session_start();
//session_destroy();
header("Location: index1.php");

?>
