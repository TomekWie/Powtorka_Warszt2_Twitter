<?php  

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

}
