<?php
session_start();

if(!isset($_SESSION['loggedUserId']))
{ header('Location: login.php'); }

require __DIR__ . "/conn.php";
require __DIR__ . "/src/Tweet.php";
require __DIR__ . "/src/User.php";
require __DIR__ . "/src/Comment.php";

if ($_SERVER['REQUEST_METHOD']=='POST')
{
  if ($_POST['commentText']!='')
  {
    $newComment = new Comment();
    $newComment->setUserId($_SESSION['loggedUserId']);
    $newComment->setTweetId($_GET['tweetId']);
    $newComment->setText($_POST['commentText']);
    $newComment->setCreationDate(date("Y-m-d H:i:s"));
    $newComment->saveToDB($conn);
  }
  else
  {
    echo "Pustych komentarzy nie puszczamy :) <br>";
  }
}
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

  echo "Powrót do strony <a href='index.php'> głownej </a><br>";
  echo "Wyloguj się klikając <a href='logout.php'> tutaj </a><br>";
  echo "Autor: <a href='singleUser.php?userId=$userId'> $username </a>";
  echo "<div> <h2>$text</h2> <div>";
  echo "<div> Tweet stworzony: $creationDate </div>";
  ?>

  <h3>Napisz komentarz:</h3>
  <form action="" method="post">
  <input type="text" maxlength="60" height="200" name="commentText"><br>
  <input type="submit" value="Wyślij">
  </form>

  <?php
  $allCommentsOfSingleTweet = Comment::loadAllCommentsByTweetId($conn, $_GET['tweetId']);

  echo "<hr><h3>Komentarze:</h3>";

  foreach ($allCommentsOfSingleTweet as $singleComment)
  {
    $userId = $singleComment->getUserId();
    $text = $singleComment->getText();
    $commentId = $singleComment->getId();
    $creationDate = $singleComment->getCreationDate();
    $user = User::loadUserById($conn, $userId);
    $username = $user->getUsername();

    echo "Autor: <a href='singleUser.php?userId=$userId'> $username </a>";
    echo "<div><b> $text </b><div>";
    echo "<div> stworzony: $creationDate </div><hr>";
  }
  ?>

</body>
</html>
