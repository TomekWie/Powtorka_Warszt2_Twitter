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


  public function saveToDB(mysqli $conn)
  {
    if($this->id == -1)
    {
      $sql = "INSERT INTO Tweet (userId, text, creationDate) VALUES ('$this->userId', '$this->text', '$this->creationDate')";

      $result = $conn->query($sql);
      if ($result==true)
      {
        $this->id = $conn->insert_id;
        return true;
      }
    }
    echo "Błąd " . $conn->error;
    return false;
  }


  static public function loadTweetById (mysqli $conn, $id)
  {
    $sql = "SELECT * FROM Tweet WHERE id = $id";
    $result = $conn->query($sql);
    if ($result==true && $result->num_rows == 1)
    {
      $row = $result->fetch_assoc();
      $tweet = new Tweet();
      $tweet->id = $row['id'];
      $tweet->setText($row['text']);
      $tweet->setUserId($row['userId']);
      $tweet->setCreationDate($row['creationDate']);
      return $tweet;
    }
    return null;
  }


  static public function loadAllTweetsByUserId(mysqli $conn, $userId)
  {
    $userTweets = [];
    $sql = "SELECT * FROM Tweet WHERE userId = $userId ORDER BY creationDate DESC";
    $result = $conn->query($sql);

    if ($result==true && $result->num_rows != 0)
    {
      foreach ($result as $row)
      {
        $tweet= new Tweet();
        $tweet->id = $row['id'];
        $tweet->setText($row['text']);
        $tweet->setUserId($row['userId']);
        $tweet->setCreationDate($row['creationDate']);

        $userTweets[] = $tweet;
      }
    }
    return $userTweets;
  }


  static public function loadAllTweets(mysqli $conn)
  {
    $sql = "SELECT * FROM Tweet ORDER BY creationDate DESC";
    $result = $conn->query($sql);
    $allTweets = [];

    if ($result ==  true && $result->num_rows != 0)
    {
      foreach ($result as $row)
      {
        $tweet = new Tweet();
        $tweet->id = $row['id'];
        $tweet->userId = $row['userId'];
        $tweet->text = $row['text'];
        $tweet->creationDate = $row['creationDate'];
        $allTweets[] = $tweet;
      }
    }
    return $allTweets;
  }
}
