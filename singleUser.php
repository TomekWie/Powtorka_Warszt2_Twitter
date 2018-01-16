<?php
session_start();

if(!isset($_SESSION['loggedUserId']))
{ header('Location: login.php'); }

require __DIR__ . "/conn.php";
require __DIR__ . "/src/Tweet.php";
require __DIR__ . "/src/User.php";
require __DIR__ . "/src/Comment.php";
?>

<!DOCTYPE html>
<html>
<head>
  <title>Twitter - page of single user </title>
  <style>
  body {background-color: gray;}
  h1 {color: darkgreen;}
  </style>
  <!-- <link rel="stylesheet" href="mystyle.css"> -->
  <meta charset="UTF-8">
  <meta name="description" content="Twitter single user page">
  <meta name="keywords" content="Tweeter, Tweet">
  <meta name="author" content="Tomasz Wieckowski">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

  <?php
  $user = User::loadUserById($conn, $_GET['userId']);
  $username = $user->getUsername();
  $userId = $user->getId();

  echo "Powrót do strony <a href='index.php'>głownej</a><br>";
  echo "Wyloguj się klikając <a href='logout.php'>tutaj</a><br>";

  echo "<h3>Tweety autorstwa $username
        (wyślij <a href='sendMessage.php?userId=$userId'> wiadomość </a>) </h3> ";
  $allTweetsOfUser = Tweet::loadAllTweetsByUserId($conn, $_GET['userId']);

  foreach ($allTweetsOfUser as $singleTweet)
  {
    $userId = $singleTweet->getUserId();
    $text = $singleTweet->getText();
    $tweetId = $singleTweet->getId();
    $tweetCreationDate = $singleTweet->getCreationDate();
    $countAllCommentsOnTweetId = Comment::countAllCommentsOnTweetId($conn, $tweetId);

    echo "<div> Tweet z $tweetCreationDate <div>";
    echo "<div><b> $text </b><div>";
    echo "<div> Ten tweet ma $countAllCommentsOnTweetId komentarzy <div>";
    echo "<div> <a href='singleTweet.php?tweetId=$tweetId'>Zobacz więcej</a></div><hr>";
  }
  ?>

</body>
</html>
