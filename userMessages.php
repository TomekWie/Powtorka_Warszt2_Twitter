<?php
session_start();

if(!isset($_SESSION['loggedUserId']))
{
  header('Location: login.php');
}

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

  $allMessagesWhereUserIsSenderOrReceiver = Message::loadAllMessagesWhereUserIsSenderOrReceiver($conn, $_SESSION['loggedUserId']);

  foreach ($allMessagesWhereUserIsSenderOrReceiver as $message)
  {
    $senderId = $message->getSenderId();
    $receiverId = $message->getReceiverId();
    $senderName = User::loadUserById($conn, $senderId)->getUsername();
    $receiverName = User::loadUserById($conn, $receiverId)->getUsername();
    $text = $message->getText();
    $creationDate = $message->getCreationDate();
    $messageId = $message->getId();
    
    echo "Wiadomość od:<a href='singleUser.php?userId=$senderId'> $senderName </a> ";
    echo "Wiadomość do:<a href='singleUser.php?userId=$receiverId'> $receiverName </a> ";
    echo "<div> $text <div>";
    echo "<div> $creationDate <div><hr>";
  }
  ?>

</body>

</html>
