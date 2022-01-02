<?php

namespace Space;

class Message extends InformationEntity {

    private $id = false;
    private $owner = false;
    private $emitter = false;
    private $receptor = false;
    private $content = false;
    private $date = false;
    private $time = false;
    private $seen = false;

    public function __construct(int $msg_id) {
        parent::__construct();
        if ($this->connected) {
            $result = $this->GetInformations($msg_id);
            if (is_array($result)) {
                $this->id = $result["id"];
                $this->owner = $result["owner"];
                $this->emitter = $result["emitter"];
                $this->receptor = $result["receptor"];
                $this->time = $result["time"];
                $this->seen = $result["seen"];
                $this->content = $result["content"];
                $this->initialized = true;
            } else {
                $this->SetError(self::INITIALIZATION_ERROR);
            }
        }
    }

    /**
     * Gets informations about a message from the database
     * @param int $id - the id of the message
     * @return array an associative array containing the informations of the message 
     * @return false if an error occur
     */
    protected function GetInformations(int $id) {

        $result = $this->connection->query("select * from message where id = $id");

        if ($this->connection->errno)
            false;

        if (mysqli_num_rows($result) < 1)
            false;

        return mysqli_fetch_array($result, MYSQLI_ASSOC);
    }

    public function GetId() {
        $this->ValidateInformationEntity();
        return $this->id;
    }

   
    public function GetOwner() {
        $this->ValidateInformationEntity();
        return  new Star($this->owner);
    }

  
    public function GetEmitter() {
        $this->ValidateInformationEntity();
        return new Star($this->emitter);
    }

    public function GetReceptor(){
        $this->ValidateInformationEntity();
        return new Star($this->receptor);
    }

    /**
     * Gets the content of the message
     * @return string the content of the notification
     */
    public function GetContent() {
        $this->ValidateInformationEntity();
        return htmlspecialchars($this->content);
    }

    /**
     * Gets the date of the message
     * @return string the date of the message
     */
    public function GetDate() {
        $this->ValidateInformationEntity();
        return $this->date;
    }

    /**
     * Gets the time of the message
     * @return string the time of the message
     */
    public function GetTime() {
        $this->ValidateInformationEntity();
        return $this->time;
    }

    /**
     * Check if the message has been seen by the receptor
     * @return bool 
     */
    public function Seen() {
        $this->ValidateInformationEntity();
        return $this->seen;
    }

    /**
     * Deletes this message from the database
     * @return bool true for success and false for failure
     */
    public function Delete() {
        $this->ValidateInformationEntity();
        return $this->connection->query("call delete_message($this->id)");
    }

    /**
     * Marks the message as read
     * @return bool true for success and false for failure
     */
    public function MarkAsRead() {
        $this->ValidateInformationEntity();

        $result = $this->connection->query("call see_message($this->id)");
        if ($result)
            $this->seen = true;
        return $result;
    }

    /**
     * Marks the message as unread
     * @return bool true for success and false for failure
     */
    public function MarkAsUnread() {
        $this->ValidateInformationEntity();

        $result = $this->connection->query("call unsee_message($this->id)");
        if ($result)
            $this->seen = false;
        return $result;
    }
    
    public static function Exists(int $msg_id){
        if (empty($notid) || !is_numeric($notid)) return false;
        $connection = self::GetConnection();
        if (mysqli_errno($connection)) return false; //If an error occur, let's suppose the message id is invalid
        $result = mysqli_query($connection, "select * from message where id = $notid");
        $rows = mysqli_num_rows($result);
        mysqli_close($connection);
        if ($rows < 1) return false;
        return true;
    }

}
