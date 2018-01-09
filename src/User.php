<?php

require __DIR__ . '/../conn.php';

class User
{
  private $id;
  private $username;
  private $hashedPassword;
  private $email;

  public function __construct()
  {
    $this->id = -1;
    $this->username = '';
    $this->hashedPassword = '';
    $this->email = '';
  }

  public function getId()
  {return $this->id;}

  public function getUsername()
  {return $this->username;}

  public function getHashedPassword()
  {return $this->hashedPassword;}

  public function getEmail()
  {return $this->email;}


  public function setUsername($username)
  {$this->username = $username;}

  public function setHashedPassword($password)
  {$this->hashedPassword = password_hash($password, PASSWORD_BCRYPT);}

  public function setEmail ($email)
  {$this->email = $email;}


  public function saveToDB(mysqli $connection)
  {
    if($this->id == -1)
    {
      $sql = "INSERT INTO `Users` (`username`, `hashed_password`, `email`)
      VALUES ('$this->username', '$this->hashedPassword', '$this->email')";

      $result = $connection->query($sql);

      if ($result == true)
      {
        $this->id = $connection->insert_id;
        return true;
      }
      else
      {
        echo "Błąd podczas zapisywania nowego Usera do bazy: " . $connection->error;
        return false;
      }
    }
    echo "User prawdopdobnie jest już w bazie: jego id to: $this->id";
    return false;
  }
}

$user1 = new User();
$user1->setUsername('Dorian Padawan');
$user1->setEmail('dorian222@gmail.com');
$user1->setHashedPassword('kuwety');
$user1->saveToDB($conn);
