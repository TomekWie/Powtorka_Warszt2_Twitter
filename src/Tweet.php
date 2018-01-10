<?php

require __DIR__ . "/../conn.php";

class Tweet
{

  private $id;
  private $userId;
  private $text;
  private $creationDate;

  public function __construct()
  {
    $this->id = -1;
    $this->userId = '';
    $this->text = '';
    $this->creationDate = '';
  }

  public function getId()
  {return $this->id;}

  public function getUserId()
  {return $this->userId;}

  public function getText()
  {return $this->text;}

  public function getCreationDate()
  {return $this->creationDate;}

  public function setUserId($userId)
  {$this->userId = $userId;}

  public function setText($text)
  {$this->text = $text;}

  public function setCreationDate($creationDate)
  {$this->creationDate = $creationDate;}

}

// $tweet1 = new Tweet();
// var_dump($tweet1);
// echo $tweet1->getId();
// echo $tweet1->getUserId();
// echo $tweet1->getText();
// echo $tweet1->getCreationDate();
// $tweet1->setUserId(24);
// $tweet1->setText('IV episode of Star Wars sucks!');
// $tweet1->setCreationDate(date("Y-m-d H:i:s"));
// var_dump($tweet1);
// echo $tweet1->getId();
// echo $tweet1->getUserId();
// echo $tweet1->getText();
// echo $tweet1->getCreationDate();
