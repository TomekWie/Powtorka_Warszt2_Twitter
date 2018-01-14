
<?php
session_start();

if(!isset($_SESSION['loggedUserId']))
{
  header('Location: login.php');
}

require __DIR__ . "/conn.php";
require __DIR__ . "/src/User.php";
require __DIR__ . "/src/Message.php";

  $receiverId = $_GET['userId'];

  if($receiverId == $_SESSION['loggedUserId'])
  {
    die("Nie możesz wysłac wiadomości do samego siebie :( <br>
        <a href='index.php'>Wróć do strony głównej</a>");
  }

  $receiver = User::loadUserById($conn, $receiverId);
  $receiverName = $receiver->getUsername();

if ($_SERVER['REQUEST_METHOD']=='POST')
{
  if ($_POST['messageText']!='')
  {
    $newMessage = new Message();
    $newMessage->setSenderId($_SESSION['loggedUserId']);
    $newMessage->setReceiverId($_GET['userId']);
    $newMessage->setText($_POST['messageText']);
    $newMessage->setCreationDate(date("Y-m-d H:i:s"));
    $newMessage->setHasBeenRead(0);
    $newMessage->saveToDB($conn);
    echo "Wiadomość została wysłana :) <br>";
    echo "Zobacz swoje wiadomości klikając <a href='userMessages.php'> tutaj </a>";
    echo "lub wróc do <a href='index.php'> strony głównej </a>";
  }
  else
  {
    echo "Pustych wiadomości nie puszczamy :) <br>";
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Twitter - send message page</title>
  <style>
  body {background-color: gray;}
  h1 {color: darkgreen;}
  </style>
  <!-- <link rel="stylesheet" href="mystyle.css"> -->
  <meta charset="UTF-8">
  <meta name="description" content="Twitter send message page">
  <meta name="keywords" content="Tweeter, Tweet">
  <meta name="author" content="Tomasz Wieckowski">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

  <h3>Wyślij wiadomość do <?php echo "$receiverName" ?>:</h3>
  <form action="" method="post">
  <input type="text"name="messageText"><br>
  <input type="submit" value="Submit">
  </form>

  Powrót do strony <a href='index.php'> głownej </a>;
  Wyloguj się klikając <a href='logout.php'> tutaj </a>;
</body>

</html>
