<?php

require __DIR__ . './../conn.php';

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
      $sql = "INSERT INTO `User` (`username`, `hashedPassword`, `email`)
      VALUES ('$this->username', '$this->hashedPassword', '$this->email')";

      $result = $connection->query($sql);

      if ($result == true)
      {
        $this->id = $connection->insert_id;
        return true;
      }
      else
      {
        echo "Błąd podczas zapisywania nowego usera do bazy: " . $connection->error;
      }
    }
    else
    {
      $sql = "UPDATE `User`
              SET `email`='$this->email',
                  `username`='$this->username',
                  `hashedPassword`='$this->hashedPassword'
              WHERE `id`='$this->id'";

      $result=$connection->query($sql);

      if($result==true)
      {
        return true;
      }
      echo "Błąd podczas update'u usera o id $id: " . $connection->error;
    }
    return false;
  }

  public function delete(mysqli $connection)
  {
    if ($this->id != -1)
    {
      $sql = "DELETE FROM `User` WHERE `id`='$this->id'";
      $result=$connection->query($sql);
      if($result==true)
      {
        $this->id = -1;
        return true;
      }
      return false;
    }
    return true;
  }

  static public function loadUserById(mysqli $connection, $id)
  {
    $sql = "SELECT * FROM `User` WHERE `id`=$id";
    $result = $connection->query($sql);

    if ($result == true && $result->num_rows==1)
    {
      $row = $result->fetch_assoc();

      $loadedUser = new User;
      $loadedUser->username = $row['username'];
      $loadedUser->email = $row['email'];
      $loadedUser->hashedPassword = $row['hashedPassword'];
      $loadedUser->id = $row['id'];

      return $loadedUser;
    }
    return null;
  }

  static public function loadUserByEmail(mysqli $connection, $email)
  {
    $sql = "SELECT * FROM `User` WHERE `email`= $email";
    $result = $connection->query($sql);

    if ($result == true && $result->num_rows==1)
    {
      $row = $result->fetch_assoc();

      $loadedUser = new User;
      $loadedUser->username = $row['username'];
      $loadedUser->email = $row['email'];
      $loadedUser->hashedPassword = $row['hashedPassword'];
      $loadedUser->id = $row['id'];

      return $loadedUser;
    }
    return null;
  }

  static public function loadAllUsers(mysqli $connection)
  {
    $usersArr=[];
    $sql = "SELECT * FROM `User`";
    $result = $connection->query($sql);

    if ($result==true && $result->num_rows != 0)
    {
      foreach ($result as $row)
      {
        $user = new User();
        $user->id = $row['id'];
        $user->username = $row['username'];
        $user->email = $row['email'];
        $user->hashedPassword = $row['hashedPassword'];

        $usersArr[]=$user;
      }
    }
    return $usersArr;
  }
}

// $u = new User();
// $u->setUsername('a');
// $u->setEmail('a@a');
// $u->setHashedPassword('aaa');
// $u->saveToDB($conn);
