<?php
session_start();

if(!isset($_SESSION['loggedUserId']))
{ header('Location: login.php'); }

require __DIR__ . "/conn.php";
require __DIR__ . "/src/User.php";

$loggedUserId = $_SESSION['loggedUserId'];
$loggedUser = User::loadUserById($conn, $loggedUserId);

if ($_SERVER['REQUEST_METHOD']=='POST')
{
  if ($_POST['email']=='' && $_POST['pass1']=='' && $_POST['pass2']=='')
  {
    $lackOfData = "Podaj dane do zmiany";
  }
  else if ($_POST['email']!='')
  {
    if(User::loadUserByEmail($conn, $_POST['email']))//sprawdzamy czy email jest w bazie
    {
      $wrongEmail = "Użytkownik o takim emailu jest już zarejestrownay. Podaj inny.";
    }
    else
    {
      $loggedUser->setEmail($_POST['email']);
      $properData = "Twoje dane zostały poprawnie zmienione :)";
    }
  }

  if ($_POST['pass1']!='' && $_POST['pass2'] !='')
  {
    if ($_POST['pass1'] != $_POST['pass2'])
    {
      $wrongPasswords = "Twoje hasła nie są identyczne, spróbuj jeszcze raz";
    }
    else
    {
      $loggedUser->setHashedPassword($_POST['pass1']);
      $properData = "Twoje dane zostały poprawnie zmienione :)";
    }
  }
  $loggedUser->saveToDB($conn);
}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Twitter - changing user data page</title>
  <style>
  body {background-color: gray;}
  h1 {color: darkgreen;}
  </style>
  <!-- <link rel="stylesheet" href="mystyle.css"> -->
  <meta charset="UTF-8">
  <meta name="description" content="Twitter changing user data page">
  <meta name="author" content="Tomasz Wieckowski">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

  Wyloguj się klikając <a href='logout.php'> tutaj </a><br>
  Powrót do strony <a href='index.php'> głownej </a><br>
  Usuń swój profil i wszystkie swoje dane z  naszego serwisu klikając
  <a href='deleteUser.php'> tutaj </a><br><br>

  <h2>Witaj <?php echo $loggedUser->getUsername(); ?>
      poniżej możesz zmienić swoje dane</h2>

  <form action="" method="post">
  Zmień swój adres email na: <input type="text" maxlength="30" name="email"><br>
  Zmień swoje hasło na: <input type="password" maxlength="40"  name="pass1"><br>
  Powtórz swoje nowe hasło:  <input type="password" maxlength="40"  name="pass2"><br>
  <input type="submit" value="Wyślij"></form>

  <div style="color:yellow">

  <?php
  if(isset($lackOfData))
  {echo $lackOfData;}
  else if(isset($properData))
  {echo $properData;}
  else if(isset($wrongEmail))
  {echo $wrongEmail;}
  else if(isset($wrongPasswords))
  {echo $wrongPasswords;}
  ?>

  </div>
</body>
</html>
