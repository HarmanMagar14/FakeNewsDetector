<?php
session_start();
session_unset();
session_destroy();
header("Location: ../UserAuthentication/index.php"); // Redirect to login page
exit();
?>