

<?php
session_start();

if(!isset($_SESSION['loggedUserId']))
{
  header('Location: login.php');
}

require __DIR__ . "/conn.php";
require __DIR__ . "/src/Tweet.php";
require __DIR__ . "/src/User.php";

if ($_SERVER['REQUEST_METHOD']=='POST')
{
  if ($_POST['tweetText']!='')
  {
    $newTweet = new Tweet();
    $newTweet->setUserId($_SESSION['loggedUserId']);
    $newTweet->setText($_POST['tweetText']);
    $newTweet->setCreationDate(date("Y-m-d H:i:s"));

    $newTweet->saveToDB($conn);
  }
  else
  {
    echo "Pustych tweetów nie puszczamy :) <br>";
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Twitter - main page</title>
  <style>
  body {background-color: gray;}
  h1 {color: darkgreen;}
  </style>
  <!-- <link rel="stylesheet" href="mystyle.css"> -->
  <meta charset="UTF-8">
  <meta name="description" content="Twitter main page">
  <meta name="keywords" content="Tweeter, Tweet">
  <meta name="author" content="Tomasz Wieckowski">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
  Wyloguj się klikając <a href='logout.php'> tutaj </a>

  <h1>Witaj na głównej stronie!</h1>
  <h3><a href='userMessages.php'>Zobacz swoje wiadomości</a></h3>
  <h3>Stwórz nowy Tweet:</h3>
  <form action="" method="post">
  Tweetnij! <input type="text" maxlength="140" height="200" name="tweetText"><br>
  <input type="submit" value="Submit">
  </form>

  <?php

  $allTweets = Tweet::loadAllTweets($conn);

  foreach ($allTweets as $singleTweet)
  {
    $userId = $singleTweet->getUserId();
    $text = $singleTweet->getText();
    $tweetId = $singleTweet->getId();
    $user = User::loadUserById($conn, $userId);
    $username = $user->getUsername();

    echo "<h3>Autor:<a href='singleUser.php?userId=$userId'> $username </a></h3> ";
    echo "<div> $text <div>";
    echo "<div> <a href='singleTweet.php?tweetId=$tweetId'>Zobacz więcej</a></div><hr>";
  }
  ?>

</body>

</html>
