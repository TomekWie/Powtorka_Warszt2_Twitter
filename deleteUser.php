<?php
session_start();

if(!isset($_SESSION['loggedUserId']))
{ header('Location: login.php'); }

require __DIR__ . "/conn.php";
require __DIR__ . "/src/User.php";

User::deleteUserById($conn, $_SESSION['loggedUserId']);

session_unset();
header('Location: login.php');
