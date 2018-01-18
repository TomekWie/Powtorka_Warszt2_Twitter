<?php
session_start();

if(!isset($_SESSION['loggedUserId']))
{ header('Location: login.php'); }

require __DIR__ . "/conn.php";
require __DIR__ . "/src/Tweet.php";
require __DIR__ . "/src/User.php";
require __DIR__ . "/src/Comment.php";

$loggedUserName = User::loadUserById($conn, $_SESSION['loggedUserId'])->getUsername();

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

  <h1> Hej <?php echo "$loggedUserName" ?>! Witaj na głównej stronie !</h1>
  Wyloguj się klikając <a href='logout.php'> tutaj </a><br>
  Zmień swoje dane klikając <a href='changeUserData.php'> tutaj </a><br>
  Usuń swój profil i wszystkie swoje dane z  naszego serwisu klikając
  <a href='deleteUser.php'> tutaj </a><br>
  Zobacz swoje wiadomości klikając <a href='userMessages.php'>tutaj</a><br>

  <h3>Stwórz nowy Tweet:</h3>

  <form action="" method="post">
  <input type="text" maxlength="140" name="tweetText">
  <input type="submit" value="Tweetnij!"></form><br><hr>

  <?php
  $allTweets = Tweet::loadAllTweets($conn);

  foreach ($allTweets as $singleTweet)
  {
    $userId = $singleTweet->getUserId();
    $text = $singleTweet->getText();
    $tweetId = $singleTweet->getId();
    $user = User::loadUserById($conn, $userId);
    $username = $user->getUsername();
    $countAllCommentsOnTweetId = Comment::countAllCommentsOnTweetId($conn, $tweetId);

    echo "<div>Autor:<a href='singleUser.php?userId=$userId'> $username </a><div>";
    echo "<b>$text</b><br>";
    echo "<div> Ten tweet ma $countAllCommentsOnTweetId komentarzy. <a href='singleTweet.php?tweetId=$tweetId'><br>
    Zobacz więcej...</a><div><hr>";
  }
  ?>

</body>
</html>
