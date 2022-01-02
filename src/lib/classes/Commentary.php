<?php

namespace Space;

final class Commentary extends InformationEntity {

    //Commentary Informations
    private $id = false;
    private $owner = false;
    private $post = false;
    private $content = false;
    private $date = false;
    private $time = false;

    public function __construct(int $id) {
        parent::__construct(); //Connect to database server
        if ($this->connected) {  //Is connected
            $result = $this->GetInformations($id);
            if (is_array($result)) {
                $this->id = $result["id"];
                $this->owner = $result["owner"];
                $this->post = $result["post"];
                $this->content = $result["content"];
                $this->date = $result["date"];
                $this->time = $result["time"];
                $this->initialized = true;
            } else {
                $this->SetError(self::INITIALIZATION_ERROR);
            }
        }
    }

    /**
     * Gets informations about a commentary from the database
     * @param int $id - the id of the commentary
     * @return array an associative array containing the informations of the commentary 
     * @return int (QUERY_ERROR or EXISTENCE_ERROR) if an error occur
     */
    protected function GetInformations(int $id) {
        $result = $this->connection->query("select * from commentary where id = $id");

        if ($this->connection->errno)
            return false;

        if (mysqli_num_rows($result) < 1)
            return false;

        return mysqli_fetch_array($result, MYSQLI_ASSOC);
    }

    /**
     * Gets the id of the commentary
     * @return int the id of the commentary
     */
    public function GetId() {
        $this->ValidateInformationEntity();
        return $this->id;
    }

    /**
     * Returns the owner of the commentary
     * @return \Space\Star the owner of the commentary
     */
    public function GetOwner() {
        $this->ValidateInformationEntity();
        return new Star($this->owner);
    }

    /**
     * Returns the post of the commentary
     * @return \Space\Post the post of the commentary
     */
    public function GetPost() {
        $this->ValidateInformationEntity();
        return new Post($this->post);
    }

    /**
     * Gets the content of the commentary
     * @return string the content of the commentary
     */
    public function GetContent() {
        $this->ValidateInformationEntity();
        return htmlspecialchars($this->content);
    }

    public function GetRawContent() {
        $this->ValidateInformationEntity();
        return $this->content;
    }

    /**
     * Gets the date of the commentary
     * @return string the date of the commentary 
     */
    public function GetDate() {
        $this->ValidateInformationEntity();
        return $this->date;
    }

    /**
     * Gets the time of the commentary
     * @return string the time of the commentary
     */
    public function GetTime() {
        $this->ValidateInformationEntity();
        return $this->time;
    }

    /**
     * Deletes the commentary
     * @return bool true for success and false for failure
     */
    public function Delete() {
        $this->ValidateInformationEntity();
        return $this->connection->query("call delete_commentary($this->id)");
    }

    /**
     * Edit the commentary
     * @param string $new_content - the new content of the commentary
     * @return bool - true for success, false for failure
     */
    public function EditCommentary(string $new_content) {
        if(empty($new_content)) return false;
        $this->ValidateInformationEntity();
        return $this->connection->query("call alter_commentary($this->id,'$new_content')");
    }
    
    public static function Exists(int $commentid){
        if (empty($commentid) || !is_numeric($commentid)) return false;
        $connection = self::GetConnection();
        if (mysqli_errno($connection)) return false; //If an error occur, let's suppose the commentary id is invalid
        $result = mysqli_query($connection, "select * from commentary where id = $commentid");
        $rows = mysqli_num_rows($result);
        mysqli_close($connection);
        if ($rows < 1) return false;
        return true;
    }

}
