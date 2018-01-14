<?php

require __DIR__ . "/../conn.php";

class Comment
{

  private $id;
  private $userId;
  private $tweetId;
  private $text;
  private $creationDate;

  public function __construct()
  {
    $this->id = -1;
    $this->userId = '';
    $this->tweetId = '';
    $this->text = '';
    $this->creationDate = '';
  }

  public function getId()
  {return $this->id;}

  public function getUserId()
  {return $this->userId;}

  public function getTweetId()
  {return $this->tweetId;}

  public function getText()
  {return $this->text;}

  public function getCreationDate()
  {return $this->creationDate;}

  public function setUserId($userId)
  {$this->userId = $userId;}

  public function setTweetId($tweetId)
  {$this->tweetId = $tweetId;}

  public function setText($text)
  {$this->text = $text;}

  public function setCreationDate($creationDate)
  {$this->creationDate = $creationDate;}

  public function saveToDB(mysqli $conn)
  {
    if($this->id == -1)
    {
      $sql = "INSERT INTO Comment (userId, tweetId, text, creationDate) VALUES ('$this->userId', '$this->tweetId', '$this->text', '$this->creationDate')";

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

  static public function loadCommentById (mysqli $conn, $id)
  {
    $sql = "SELECT * FROM Comment WHERE id = $id";
    $result = $conn->query($sql);
    if ($result==true && $result->num_rows == 1)
    {
      $row = $result->fetch_assoc();
      $comment = new Comment();
      $comment->id = $row['id'];
      $comment->setText($row['text']);
      $comment->setUserId($row['userId']);
      $comment->setTweetId($row['tweetId']);
      $comment->setCreationDate($row['creationDate']);

      return $comment;
    }
    return null;
  }

  static public function loadAllCommentsByTweetId(mysqli $conn, $tweetId)
  {
    $tweetComments = [];
    $sql = "SELECT * FROM Comment WHERE postId = $tweetId ORDER BY creationDate DESC";
    $result = $conn->query($sql);

    if ($result==true && $result->num_rows != 0)
    {
      foreach ($result as $row)
      {
        $comment= new Comment();
        $comment->id = $row['id'];
        $comment->setText($row['text']);
        $comment->setUserId($row['userId']);
        $comment->setTweetId($row['tweetId']);
        $comment->setCreationDate($row['creationDate']);

        $tweetComments[] = $comment;
      }
    }
    return $tweetComments;
  }
}
