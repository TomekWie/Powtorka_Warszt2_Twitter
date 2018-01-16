<?php
session_start();

if(!isset($_SESSION['loggedUserId']))
{ header('Location: login.php'); }

require __DIR__ . "/conn.php";
require __DIR__ . "/src/User.php";
require __DIR__ . "/src/Message.php";
require __DIR__ . "/src/Comment.php";
?>

<!DOCTYPE html>
<html>
<head>
  <title>Twitter - page of single message </title>
  <style>
  body {background-color: gray;}
  h1 {color: darkgreen;}
  </style>
  <!-- <link rel="stylesheet" href="mystyle.css"> -->
  <meta charset="UTF-8">
  <meta name="description" content="Twitter single message page">
  <meta name="author" content="Tomasz Wieckowski">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

  <?php
  $singleMessage = Message::loadMessageById($conn, $_GET['messageId']);
  $singleMessage->setHasBeenRead(1);
  $singleMessage->saveToDB($conn);

  $senderId = $singleMessage->getSenderId();
  $receiverId = $singleMessage->getReceiverId();
  $senderName = User::loadUserById($conn, $senderId)->getUsername();
  $receiverName = User::loadUserById($conn, $receiverId)->getUsername();
  $text = $singleMessage->getText();
  $creationDate = $singleMessage->getCreationDate();

  echo "Powrót do strony <a href='index.php'> głownej </a><br>";
  echo "Wyloguj się klikając <a href='logout.php'> tutaj </a><br>";
  echo "Wróć do wszystkich wiadomości klikając <a href='userMessages.php'>tutaj</a><br><br>";
  echo "Wiadomość od:<a href='singleUser.php?userId=$senderId'>$senderName</a>
        do <a href='singleUser.php?userId=$receiverId'>$receiverName</a>";
  echo "<div><b> $text </b><div>";
  echo "<div> Wiadomość stworzona: $creationDate </div><br>";

  if ($_SESSION['loggedUserId']!=$senderId)
  {
    echo " Odpisz klikając <a href='sendMessage.php?userId=$senderId'><b> tutaj </b></a>";
  }
  ?>

</body>
</html>
