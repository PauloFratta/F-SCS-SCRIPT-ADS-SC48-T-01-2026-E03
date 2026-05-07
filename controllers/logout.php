<?php
session_start();
session_destroy();
header('Location: ../models/login.php');
exit;
?>