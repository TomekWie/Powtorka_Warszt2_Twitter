<?php
session_start();

if(!isset($_SESSION['loggedUserId']))
{
  header('Location: login.php');
}

require __DIR__ . "/conn.php";
require __DIR__ . "/src/Tweet.php";
require __DIR__ . "/src/User.php";

?>

<!DOCTYPE html>
<html>

<head>
  <title>Twitter - page of single tweet </title>
  <style>
  body {background-color: gray;}
  h1 {color: darkgreen;}
  </style>
  <!-- <link rel="stylesheet" href="mystyle.css"> -->
  <meta charset="UTF-8">
  <meta name="description" content="Twitter single tweet page">
  <meta name="keywords" content="Tweeter, Tweet">
  <meta name="author" content="Tomasz Wieckowski">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

  <?php

  $singleTweet = Tweet::loadTweetById($conn, $_GET['tweetId']);

  $userId = $singleTweet->getUserId();
  $text = $singleTweet->getText();
  $creationDate = $singleTweet->getCreationDate();
  $user= User::loadUserById($conn, $userId);
  $username = $user->getUsername();

  echo "Autor: <a href='singleUser.php?userId=$userId'> $username </a>";
  echo "<div> <h2>$text</h2> <div>";
  echo "<div><h3> stworzony: $creationDate <h3></div><hr>";

  ?>

</body>

</html>
