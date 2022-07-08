<?php
session_start();

$title = 'Deconnexion';
include('../includes/logging.php');

session_destroy();
header('location: ../index.php');

?>