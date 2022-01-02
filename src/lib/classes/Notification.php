<?php

namespace Space;

class Notification extends InformationEntity {

    private $id = false;
    private $owner = false;
    private $title = false;
    private $content = false;
    private $date = false;
    private $time = false;
    private $seen = false;

    public function __construct(int $not_id) {
        parent::__construct();
        if ($this->connected) {
            $result = $this->GetInformations($not_id);
            if (is_array($result)) {
                $this->id = $result["id"];
                $this->owner = $result["owner"];
                $this->content = $result["content"];
                $this->date = $result["date"];
                $this->time = $result["time"];
                $this->seen = $result["seen"];
                $this->title = $result["title"];
                $this->initialized = true;
            } else {
                $this->SetError(self::INITIALIZATION_ERROR);
            }
        }
    }

    /**
     * Gets informations about a notification from the database
     * @param int $id - the id of the notification
     * @return array an associative array containing the informations of the notification 
     * @return int (QUERY_ERROR,EXISTENCE_ERROR) if an error occur
     */
    protected function GetInformations(int $id) {

        $result = $this->connection->query("select * from notification where id = $id");

        if ($this->connection->errno)
            false;

        if (mysqli_num_rows($result) < 1)
            false;

        return mysqli_fetch_array($result, MYSQLI_ASSOC);
    }

    /**
     * Gets the id of the notification
     * @return int the id of the notification
     */
    public function GetId() {
        $this->ValidateInformationEntity();
        return $this->id;
    }

    /**
     * Gets the title of the notification
     * @return string the title of the notfication
     */
    public function GetTitle() {
        $this->ValidateInformationEntity();
        return $this->title;
    }

    /**
     * Returns the owner of the notification
     * @return \Space\Star the star related to the notification
     */
    public function GetOwner() {
        $this->ValidateInformationEntity();
        return new Star($this->owner);
    }

    /**
     * Gets the content of the notification
     * @return string the content of the notification
     */
    public function GetContent() {
        $this->ValidateInformationEntity();
        return urldecode($this->content);
    }

    /**
     * Gets the date of the notification
     * @return string the date of the notification 
     */
    public function GetDate() {
        $this->ValidateInformationEntity();
        return $this->date;
    }

    /**
     * Gets the time of the notification
     * @return string the time of the notification
     */
    public function GetTime() {
        $this->ValidateInformationEntity();
        return $this->time;
    }

    /**
     * Check if the notification has been seen or not
     * @return bool 
     */
    public function Seen() {
        $this->ValidateInformationEntity();
        return $this->seen;
    }

    /**
     * Deletes the notification
     * @return bool true for success and false for failure
     */
    public function Delete() {
        $this->ValidateInformationEntity();
        return $this->connection->query("call delete_notification($this->id)");
    }

    /**
     * Marks the notification as read
     * @return bool true for success and false for failure
     */
    public function MarkAsRead() {
        $this->ValidateInformationEntity();

        $result = $this->connection->query("call see_notification($this->id)");
        if ($result)
            $this->seen = true;
        return $result;
    }

    /**
     * Marks the notification as unread
     * @return bool true for success and false for failure
     */
    public function MarkAsUnread() {
        $this->ValidateInformationEntity();

        $result = $this->connection->query("call unsee_notification($this->id)");
        if ($result)
            $this->seen = false;
        return $result;
    }
    
    public static function Exists(int $notid){
        if (empty($notid) || !is_numeric($notid)) return false;
        $connection = self::GetConnection();
        if (mysqli_errno($connection)) return false; //If an error occur, let's suppose the notification id is invalid
        $result = mysqli_query($connection, "select * from notification where id = $notid");
        $rows = mysqli_num_rows($result);
        mysqli_close($connection);
        if ($rows < 1) return false;
        return true;
    }

}
