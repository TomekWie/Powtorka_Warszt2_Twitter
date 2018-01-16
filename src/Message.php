<?php

require __DIR__ . "/../conn.php";

class Message
{
  private $id;
  private $senderId;
  private $receiverId;
  private $text;
  private $creationDate;
  private $hasBeenRead;

  public function __construct()
  {
    $this->id = -1;
    $this->senderId = '';
    $this->receiverId = '';
    $this->text = '';
    $this->creationDate = '';
    $this->hasBeenRead = '';
  }

  public function getId()
  {return $this->id;}

  public function getSenderId()
  {return $this->senderId;}

  public function getReceiverId()
  {return $this->receiverId;}

  public function getText()
  {return $this->text;}

  public function getCreationDate()
  {return $this->creationDate;}

  public function getHasBeenRead()
  {return $this->hasBeenRead;}

  public function setSenderId($senderId)
  {$this->senderId = $senderId;}

  public function setReceiverId($receiverId)
  {$this->receiverId = $receiverId;}

  public function setText($text)
  {$this->text = $text;}

  public function setCreationDate($creationDate)
  {$this->creationDate = $creationDate;}

  public function setHasBeenRead($hasBeenRead)
  {$this->hasBeenRead = $hasBeenRead;}


  public function saveToDB(mysqli $conn)
  {
    if($this->id == -1)
    {
      $sql = "INSERT INTO Message (senderId, receiverId, text, creationDate, hasBeenRead) VALUES ('$this->senderId', '$this->receiverId', '$this->text', '$this->creationDate', '$this->hasBeenRead')";

      $result = $conn->query($sql);
      if ($result==true)
      {
        $this->id = $conn->insert_id;
        return true;
      }
    }
    else
    {
      $sql = "UPDATE `Message`
              SET `senderId`='$this->senderId',
                  `receiverId`='$this->receiverId',
                  `hasBeenRead`='$this->hasBeenRead'
              WHERE `id`='$this->id'";

      $result=$conn->query($sql);
      if($result==true)
      {
        return true;
      }
      echo "Błąd podczas update'u wiadomości o id $this->id: " . $conn->error;
    }
    echo "Błąd " . $conn->error;
    return false;
  }


  static public function loadAllMessagesWhereUserIsSenderOrReceiver(mysqli $conn, $userId)
  {
    $allMessages = [];
    $sql = "SELECT * FROM Message WHERE senderId = $userId OR receiverId = $userId ORDER BY creationDate DESC";
    $result = $conn->query($sql);

    if ($result==true && $result->num_rows != 0)
    {
      foreach ($result as $row)
      {
        $message= new Message();
        $message->id = $row['id'];
        $message->setText($row['text']);
        $message->setSenderId($row['senderId']);
        $message->setReceiverId($row['receiverId']);
        $message->setCreationDate($row['creationDate']);
        $message->setHasBeenRead($row['hasBeenRead']);

        $allMessages[] = $message;
      }
    }
    return $allMessages;
  }


  static public function loadMessageById (mysqli $conn, $id)
  {
    $sql = "SELECT * FROM Message WHERE id = $id";
    $result = $conn->query($sql);
    if ($result==true && $result->num_rows == 1)
    {
      $row = $result->fetch_assoc();
      $message = new Message();
      $message->id = $row['id'];
      $message->setText($row['text']);
      $message->setSenderId($row['senderId']);
      $message->setReceiverId($row['receiverId']);
      $message->setCreationDate($row['creationDate']);
      $message->setHasBeenRead($row['hasBeenRead']);

      return $message;
    }
    return null;
  }


  static public function loadAllMessagesBySenderId(mysqli $conn, $senderId)
  {
    $sentMessages = [];
    $sql = "SELECT * FROM Message WHERE senderId = $senderId ORDER BY creationDate DESC";
    $result = $conn->query($sql);

    if ($result==true && $result->num_rows != 0)
    {
      foreach ($result as $row)
      {
        $message= new Message();
        $message->id = $row['id'];
        $message->setText($row['text']);
        $message->setSenderId($row['senderId']);
        $message->setReceiverId($row['receiverId']);
        $message->setCreationDate($row['creationDate']);
        $message->setHasBeenRead($row['hasBeenRead']);

        $tweetMessages[] = $message;
      }
    }
    return $sentMessages;
  }


  static public function loadAllMessagesByReceiverId(mysqli $conn, $receiverId)
  {
    $receivedMessages = [];
    $sql = "SELECT * FROM Message WHERE receiverId = $receiverId ORDER BY creationDate DESC";
    $result = $conn->query($sql);

    if ($result==true && $result->num_rows != 0)
    {
      foreach ($result as $row)
      {
        $message= new Message();
        $message->id = $row['id'];
        $message->setText($row['text']);
        $message->setSenderId($row['senderId']);
        $message->setReceiverId($row['receiverId']);
        $message->setCreationDate($row['creationDate']);
        $message->setHasBeenRead($row['hasBeenRead']);

        $receivedMessages[] = $message;
      }
    }
    return $receivedMessages;
  }
}
