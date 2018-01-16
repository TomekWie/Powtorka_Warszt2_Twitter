<?php
session_start();

if(!isset($_SESSION['loggedUserId']))
{ header('Location: login.php'); }

require __DIR__ . "/conn.php";
require __DIR__ . "/src/User.php";
require __DIR__ . "/src/Message.php";
?>

<!DOCTYPE html>
<html>
<head>
  <title>Twitter - all messages page</title>
  <style>
  body {background-color: gray;}
  h1 {color: darkgreen;}
  </style>
  <!-- <link rel="stylesheet" href="mystyle.css"> -->
  <meta charset="UTF-8">
  <meta name="description" content="Twitter all messages page">
  <meta name="keywords" content="Tweeter, Tweet">
  <meta name="author" content="Tomasz Wieckowski">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

  <?php
  echo "Powrót do strony <a href='index.php'> głownej </a><br>";
  echo "Wyloguj się klikając <a href='logout.php'> tutaj </a><br>";
  echo "<h4>Twoje wiadomości:</h4> ";

  $allMessagesWhereUserIsSenderOrReceiver =
  Message::loadAllMessagesWhereUserIsSenderOrReceiver($conn, $_SESSION['loggedUserId']);

  foreach ($allMessagesWhereUserIsSenderOrReceiver as $message)
  {
    $senderId = $message->getSenderId();
    $receiverId = $message->getReceiverId();
    $senderName = User::loadUserById($conn, $senderId)->getUsername();
    $receiverName = User::loadUserById($conn, $receiverId)->getUsername();
    $text = $message->getText();
    $creationDate = $message->getCreationDate();
    $messageId = $message->getId();
    $hasBeenRead = $message->getHasBeenRead();
    $shortText = substr($text,0,30);

    echo $_SESSION['loggedUserId']==$senderId ?
    "Wiadomość do:<a href='singleUser.php?userId=$receiverId'> $receiverName </a> " :
    "Wiadomość od:<a href='singleUser.php?userId=$senderId'> $senderName </a> ";

    echo strlen($text)>30 ? "<div> $shortText... <div>" : "<div> $text <div>";
    echo $hasBeenRead == 1 ? "<div> wiadość odczytana <div>" : "<div> wiadomość nie odczytana <div>";
    echo "<div> $creationDate <div>";
    echo "<div> <a href='singleMessage.php?messageId=$messageId'>
    Zobacz więcej...</a><div><hr>";
  }
  ?>

</body>
</html>
