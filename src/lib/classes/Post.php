<?php

namespace Space;

class Post extends InformationEntity {

    private $id = false;
    private $owner = false;
    private $const = false;
    private $content = false;
    private $date = false;
    private $time = false;

    public function __construct(int $id) {
        parent::__construct();
        if ($this->connected) {
            $result = $this->GetInformations($id);
            if (is_array($result)) {
                $this->id = $result["id"];
                $this->owner = $result["owner"];
                $this->const = $result["const"];
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
     * Gets informations about a post from the database
     * @param int $id - the id of the post
     * @return array an associative array containing the informations of the post 
     * @return int (QUERY_ERROR,EXISTENCE_ERROR) if an error occur
     */
    protected function GetInformations(int $id) {

        $result = $this->connection->query("select * from post where id = $id");

        if ($this->connection->errno)
            false;

        if (mysqli_num_rows($result) < 1)
            false;

        return mysqli_fetch_array($result, MYSQLI_ASSOC);
    }

    /**
     * Gets the id of the post
     * @return int the id of the post
     */
    public function GetId() {
        $this->ValidateInformationEntity();
        return $this->id;
    }

    /**
     * Returns the owner of the post
     * @return \Space\Star the star who owns the post
     */
    public function GetOwner() {
        $this->ValidateInformationEntity();
        return new Star($this->owner);
    }

    /**
     * Returns the constellation that contains this post
     * @return \Space\Constellation the constellation of the post
     */
    public function GetConstellation() {
        $this->ValidateInformationEntity();
        return new Constellation($this->const);
    }

    /**
     * Gets the content of the post
     * @return string the content of the post
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
     * Gets the date of the post
     * @return string the date of the post
     */
    public function GetDate() {
        $this->ValidateInformationEntity();
        return $this->date;
    }

    /**
     * Gets the time of the post
     * @return string the time of the post
     */
    public function GetTime() {
        $this->ValidateInformationEntity();
        return $this->time;
    }

    /**
     * Deletes the post
     * @return bool true for success and false for failure
     */
    public function Delete() {
        $this->ValidateInformationEntity();
        return $this->connection->query("call delete_post($this->id)");
    }

    /**
     * Returns the ids of the commentaries of this post
     * @param int $part - the start index of the commentaries to present
     * @param int $range - the quantity of commentaries to present
     * @return boolean|int|array false for failure, 0 if there is no post, an associative array containing the ids of the commentaries
     */
    public function GetCommentaries(int $part, int $range) {
        $this->ValidateInformationEntity();

        $command_text = "select id from commentary where post = $this->id limit $part,$range";

        $result = $this->connection->query($command_text);

        if ($this->connection->errno)
            return false;

        if (mysqli_num_rows($result) < 1)
            return 0;

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    /**
     * Counts the commentaries of the post
     * @return int|bool the number of commentaries or false in case of error
     */
    public function CommentariesCount() {
        $this->ValidateInformationEntity();

        $command_text = "select count(*) from commentary where post = $this->id";
        $result = $this->connection->query($command_text);

        if ($this->connection->errno)
            return false;

        return mysqli_fetch_array($result)[0];
    }

    /**
     * Send a comment to this post
     * @param int $star_id - the id of the owner of the commentary
     * @param string $content - the content of the commentary
     * @return bool - true for success and false for failure 
     */
    public function Comment(int $star_id, string $content) {
        $this->ValidateInformationEntity();
        return $this->connection->query("call send_commentary($star_id,$this->id,'$content')");
    }

    /**
     * Edit the post
     * @param string $new_content - the new content of the post
     * @return bool - true for success, false for failure
     */
    public function EditPost(string $new_content) {
        $this->ValidateInformationEntity();
        return $this->connection->query("call alter_post($this->id,'$new_content')");
    }

    /**
     * Check if the id is a post id
     * @param int $postid - the id of the post
     * @return boolean - true if the given id is valid and exists, false otherwise 
     */
    public static function Exists($postid) {
        if (empty($postid) || !is_numeric($postid)) return false;
        $connection = self::GetConnection();
        if (mysqli_errno($connection)) return false; //If an error occur, let's suppose the post id is invalid
        $result = mysqli_query($connection, "select * from post where id = $postid");
        $rows = mysqli_num_rows($result);
        mysqli_close($connection);
        if ($rows < 1) return false;
        return true;
    }
    
    public static function IsValidPostContent(string $content){
        if(empty($content) || empty(trim($content))) return false;
        return true;
    }

}
