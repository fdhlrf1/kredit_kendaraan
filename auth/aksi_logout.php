<?php
session_start();

session_unset();
session_destroy();

//redirect ke login
header("Location: ../index.php");
exit();