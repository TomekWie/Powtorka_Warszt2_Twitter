<?php

$server = 'localhost';
$user = 'root';
$pass = 'coderslab';
$dbName = 'Powtorka_Warszt2_Twitter';

$conn = new mysqli($server, $user, $pass, $dbName);
if ($conn->connect_error)
{
  die ("Błąd przy łaczeniu z bazą" . $conn->connect_error);
}
else
{
  echo "Połączenie z bazą udane :) <br>";
}
