<?php
session_start();

require __DIR__ . "/conn.php";
require __DIR__ . "/src/Tweet.php";
require __DIR__ . "/src/User.php";

if($_SERVER['REQUEST_METHOD']=='POST')
{
  if($_POST['email']!='' && $_POST['password']!='')
  {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM Users
            WHERE email='$email'";

            echo "KKK";
    $result = $conn->query($sql);
    if ($result == true)
    {
      $user=$result->fetch_assoc();
      $hash=$user['hashed_password'];
      if (password_verify($password,$hash))
      {
        $loggedUserId = $user['id'];
        $_SESSION["loggedUserId"] = $loggedUserId;
        header('Location: index.php');
      }
    }
    $wrongPass = "Nie pamiętasz hasła? Spróbuj ponownie! <br>";
  }
  else
  {
    $lackOfPass = "Podaj swój email i hasło <br>";
  }
}

?>

<!DOCTYPE html>

<html>
<head>
  <title>Twitter - login page</title>
  <style>
  body {background-color: gray;}
  h1 {color: darkgreen;}
  </style>
  <!-- <link rel="stylesheet" href="mystyle.css"> -->
  <meta charset="UTF-8">
  <meta name="description" content="Twitter login page">
  <meta name="keywords" content="Tweeter, Tweet, login">
  <meta name="author" content="Tomasz Wieckowski">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

  <h1>Witaj na stronie logowania!</h1>
  <h3>Zaloguj się:</h3>
  <form action="" method="post">
  Podaj swój email <input type="email" name="email"><br>
  Podaj swoje hasło <input type="password" name="password"><br>
  <input type="submit" value="Submit">
  </form><br>

  <div style="color:yellow">
  <?php
  if (isset($lackOfPass))
  {echo $lackOfPass;}
  if(isset($wrongPass))
  {echo $wrongPass;}
  ?>
  </div>

  <h3>Nie masz jeszcze konta?</h3>
  Zarajestru się klikając <a href='reg.php'> tutaj </a>

</body>

</html>
