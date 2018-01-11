<?php

session_start();

require __DIR__ . "/conn.php";
require __DIR__ . "/src/User.php";


var_dump($_POST);

if ($_SERVER['REQUEST_METHOD']=='POST')
{
  if ($_POST['username']!='' && $_POST['email']!='' && $_POST['pass1']!='' && $_POST['pass2']!='')
  {

    if(User::loadUserByEmail($conn, $_POST['email']))//sprawdzamy czy email jest w bazie
    {
      $duplicateEmail = "Użytkownik o takim emailu jest już zarejestrownay. Podaj inny.";
    }
    else if ($_POST['pass1'] != $_POST['pass2'])
    {
      $wrongPasswords = "Twoje hasła nie są identyczne, spróbuj jeszcze raz";
    }
    else
    {
      $newUser = new User();
      $newUser->setEmail($_POST['email']);
      $newUser->setHashedPassword($_POST['pass1']);
      $newUser->setUsername($_POST['username']);
      $newUser->saveToDB($conn);

      $loggedUserId = $conn->insert_id;
      $_SESSION["loggedUserId"] = $loggedUserId;
      header('Location: index.php');
    }
  }
  else
  {
    $lackOfData="Wypełnij wszystkie dane niezbędne do rejestracji";
  }
}

?>

<!DOCTYPE HTML>

<html>
<head>
  <title>Twitter - registration page</title>
  <style>
  body {background-color: gray;}
  h1 {color: darkgreen;}
  </style>
  <!-- <link rel="stylesheet" href="mystyle.css"> -->
  <meta charset="UTF-8">
  <meta name="description" content="Twitter registration page">
  <meta name="keywords" content="Tweeter, Tweet, registration">
  <meta name="author" content="Tomasz Wieckowski">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

  <h1>Witaj na stronie rejestracji!</h1>
  <h3>Wypełnij poniższy formularz, by dołączyć do naszej społeczności:</h3>
  <form action="" method="post">
  Imię i nazwisko <input type="text" name="username"><br>
  Email <input type="email" name="email"><br>
  Hasło <input type="password" name="pass1"><br>
  Powtórz hasło <input type="password" name="pass2"><br>
  <input type="submit" value="Wyślij">
  </form>

  <div style="color:yellow">
  <?php
  if (isset($lackOfData))
  {echo $lackOfData;}
  else if(isset($duplicateEmail))
  {echo $duplicateEmail;}
  else if(isset($wrongPasswords))
  {echo $wrongPasswords;}
  ?>
  </div>

</body>

</html>
