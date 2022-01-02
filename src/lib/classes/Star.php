<?php

namespace Space;

class Star extends InformationEntity {

    private $id = false;
    private $name = false;
    private $img_name = false;
    private $password = false;
    private $birth = false;
    private $description = false;

    public function __construct(int $star_id) {
        parent::__construct();
        if ($this->connected) {
            $result = $this->GetInformations($star_id);
            if (is_array($result)) {
                $this->id = $result["id"];
                $this->name = $result["name"];
                $this->password = $result["password"];
                $this->birth = $result["birth"];
                $this->description = $result["description"];
                $this->img_name = $result["img_name"];
                $this->initialized = true;
            } else {
                $this->SetError(self::INITIALIZATION_ERROR);
            }
        }
    }

    /**
     * Gets informations about a star from the database
     * @param int $id - the id of the star
     * @return array an associative array containing the informations of the star 
     * @return int (QUERY_ERROR,EXISTENCE_ERROR) if an error occur
     */
    protected function GetInformations(int $id) {

        $result = $this->connection->query("select * from star where id = $id");

        if ($this->connection->errno)
            return false;

        if (mysqli_num_rows($result) < 1)
            return false;

        return mysqli_fetch_array($result, MYSQLI_ASSOC);
    }

    /**
     * Gets the name of the star
     * @return string the name of the star (maximum of 10 characters)
     */
    public function GetName() {
        $this->ValidateInformationEntity();
        return $this->name;
    }

    /**
     * Gets the password of the star
     * @return string the password of the star (maximum of  characters)
     */
    public function GetPassword() {
        $this->ValidateInformationEntity();
        return $this->password;
    }

    public function IsPassword(string $password) {
        $this->ValidateInformationEntity();
        return ($password == $this->password);
    }

    /**
     * Gets the id of the star
     * @return int the id of the star
     */
    public function GetId() {
        $this->ValidateInformationEntity();
        return $this->id;
    }

    /**
     * Gets the date of the creation of the star
     * @return string the date when this star was created
     */
    public function GetBirth() {
        $this->ValidateInformationEntity();
        return $this->birth;
    }

    /**
     * Gets the description of the star
     * @return string the description (maximum of 255 characters) 
     */
    public function GetDescription() {
        $this->ValidateInformationEntity();
        return htmlspecialchars($this->description);
    }

    public function GetImageName() {
        $this->ValidateInformationEntity();
        return htmlspecialchars($this->img_name);
    }

    /**
     * Alter the description of the star
     * @param $new_description string the new description of the star (maximum of 255 characters)
     * @return bool true for success and false for failure
     */
    public function AlterDescription(string $new_description) {
        $this->ValidateInformationEntity();

        $result = $this->connection->query("call alter_star_description($this->id,'$new_description')");

        if ($result)
            $this->description = $new_description;

        return $result;
    }

    /**
     * Alter the name of the star
     * @param $new_name string the new name of the star 
     * @return bool true for success and false for failure
     */
    public function AlterName(string $new_name) {

        $this->ValidateInformationEntity();

        $result = $this->connection->query("call alter_star_name($this->id,'$new_name')");

        if ($result)
            $this->name = $new_name;

        return $result;
    }

    /**
     * Alter the password of the star
     * @param $new_password string the new password for the star
     * @return bool true for success and false for failure
     */
    public function AlterPassword(string $new_password) {
        $this->ValidateInformationEntity();
        $hash = password_hash($new_password, PASSWORD_BCRYPT);
        $result = $this->connection->query("call alter_star_password($this->id,'$hash')");

        if ($result)
            $this->password = $hash;

        return $result;
    }
    
    public function AlterImageName(string $new_name){
        $this->ValidateInformationEntity();
        
        $result = $this->connection->query("call alter_star_img_name($this->id,'$new_name')");

        if ($result)
            $this->img_name = $new_name;

        return $result;
    }

    /**
     * Send a notification to the star
     * @param $title string the title of the notification
     * @return bool true for success and false for failure
     */
    public function Notify(string $title, string $content) {
        $this->ValidateInformationEntity();
        $content = urlencode($content);
        return $this->connection->query("call send_notification($this->id,'$title','$content')");
        ;
    }

    /**
     * Gets the ids of the notifications of this star
     * @return boolean|int|array false for failure, 0 if there is no notification, an associative array containing the ids of the notifications
     */
    public function GetNotifications() {

        $this->ValidateInformationEntity();

        $command = "select id from notification where owner = $this->id order by date desc, time desc";
        $result = $this->connection->query($command);

        if (is_bool($result)) {
            return false;
        }

        if (mysqli_num_rows($result) < 1)
            return 0;

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    /**
     * Counts the unread notifications related to this star
     * @return boolean|int false for failure, or the number of unread notifications
     */
    public function UNotsCount() {
        $this->ValidateInformationEntity();

        $command_text = "select star_unots_count($this->id)";
        $result = $this->connection->query($command_text);

        if (is_bool($result))
            return false;

        return mysqli_fetch_array($result)[0];
    }

    /**
     * Counts all the notifications related to this star
     * @return boolean|int false for failure, or the number of notifications related to this star
     */
    public function NotificationsCount() {
        $this->ValidateInformationEntity();

        $command_text = "select star_nots_count($this->id)";
        $result = $this->connection->query($command_text);

        if (is_bool($result))
            return false;

        return mysqli_fetch_array($result)[0];
    }

    /**
     * Clear all the notifications related to this star
     * @return bool true for success and false for failure
     */
    public function ClearNotifications() {
        $this->ValidateInformationEntity();
        return $this->connection->query("call star_clear_nots($this->id)");
    }

    public function SendPost(int $const, string $content) {
        $this->ValidateInformationEntity();
        return $this->connection->query("call send_post($this->id,$const,'$content')");
    }

    /**
     * Counts all the posts made by this star
     * @return boolean|int false for failure, or the number of posts
     */
    public function PostsCount() {
        $this->ValidateInformationEntity();

        $command_text = "select star_posts_count($this->id)";
        $result = $this->connection->query($command_text);

        if (is_bool($result))
            return false;

        return mysqli_fetch_array($result)[0];
    }

    /**
     * Counts all the commentaries made by this star
     * @return boolean|int false for failure, or the number of commentaries
     */
    public function CommentariesCount() {
        $this->ValidateInformationEntity();

        $command_text = "select star_comments_count($this->id)";
        $result = $this->connection->query($command_text);

        if (is_bool($result))
            return false;

        return mysqli_fetch_array($result)[0];
    }

    /**
     * Returns the ids of the constellations where this star belongs to
     * @return boolean false in case of error
     * @return array an associative array containing the ids of the constellations
     */
    public function GetConstellations() {
        $this->ValidateInformationEntity();
        $result = $this->connection->query("select const from star_in_const where star = $this->id");
        if (is_bool($result))
            return false;
        return mysqli_fetch_all($result);
    }

    public function ConstellationsCount() {
        $this->ValidateInformationEntity();
        $result = $this->connection->query("select count(*) from star_in_const where star = $this->id");
        if (is_bool($result))
            return false;
        return (mysqli_fetch_array($result))[0];
    }

    public function JoinedConst(int $const) {
        if (!is_numeric($const)) return false;
        $this->ValidateInformationEntity();
        $result = $this->connection->query("select id from star_in_const where star = $this->id and const = $const");
        if (is_bool($result))
            return false;
        return (mysqli_num_rows($result) > 0);
    }

    /**
     * Terminates the session of the current star
     */
    public static function LogOut() {
        if (!@session_start()) {
            return false;
        }

        if (isset($_SESSION["id"])) {
            unset($_SESSION["id"]);
        }
        return true;
    }

    /**
     * Check if there is an active session
     * @return bool
     */
    public static function OnSpace(): bool {
        if (!@session_start())
            return false;

        if (isset($_SESSION["id"]) == false) {
            return false;
        }

        if (!self::Exists($_SESSION["id"])) {
            return false;
        }

        return true;
    }

    /**
     * Returns the current session's star
     * @return \Space\Star - the current star, or false if there is no current star
     */
    public static function MyStar() {
        if (!self::OnSpace())
            return false;
        return new Star($_SESSION["id"]);
    }

    /**
     * Attempts to start session
     * @param int $id the id of the star
     * @return bool true for success and false for failure
     */
    public static function LogIn(int $id): bool {

        if (!@session_start()) {
            return false;
        }

        $_SESSION["id"] = $id;

        return true;
    }

    /**
     * Register a new star on space
     * @param string $name the name of the star
     * @param string $password the password of the star
     * @return boolean true for success and false for failure
     */
    public static function CreateStar(string $name, string $password) {
        $connection = self::GetConnection();
        if (mysqli_errno($connection))
            return false;
        $img_name = "default.png";

        $result = mysqli_query($connection, "call create_star('$name','$password','$img_name')");
        if ($result == false) {
            mysqli_close($connection);
            return false;
        }
        mysqli_close($connection);
        $star = new Star(Star::GetStarID($name));
        $id = $star->GetId();
        $content = "<a class='link-star' href='profile.php?star=$id'>$name</a> seja bem-vindo ao Space, agora és uma estrela.";
        $star->Notify("Bem-Vindo", $content);
        return true;
    }

    /**
     * Check whether a name is valid to be used by a star
     * @param string $name - the name to validate 
     * @return boolean - true for a valid name and false for an invalid name
     */
    public static function IsValidName(string $name): bool {
        if (empty($name))
            return false; //The name can not be an empty string 
        if (mb_strlen($name) > 15 || mb_strlen($name) < 5)
            return false; //The name must have at leat 4 characters and at most 10 characters
        $valid_chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

        for ($i = 0; $i < mb_strlen($name); $i++) {
            if (mb_substr_count($valid_chars, $name[$i]) == 0)
                return false;
        }
        return true;
    }

    /**
     * Check if a name is being used by a star
     * @param string $name - the name to be looked for
     * @return boolean - true in case of any error or case the name is not free, false if the name is free 
     */
    public static function IsRegisteredName(string $name) {
        if (self::IsValidName($name) == false)
            return false;
        $connection = self::GetConnection();
        if (mysqli_errno($connection))
            return true; //In case of any error, is supposed that the name is registered
        $result = mysqli_query($connection, "select star_name_exists('$name')");
        if (is_bool($result))
            return true; //In case of any error, is supposed that the name is registered
        $exists = (mysqli_fetch_array($result))[0];
        mysqli_close($connection);
        return ($exists == 1);
    }

    /**
     * Check whether a password is valid to be used by a star
     * @param string $password - the password to validate 
     * @return boolean - true for a valid password or false for an invalid password
     */
    public static function IsValidPassword(string $password) {
        if (empty($password))
            return false; //The password can not be an empty string 
        if (mb_strlen($password) > 10 || mb_strlen($password) < 5)
            return false; //The password must have at leat 5 characters and at most 10 characters
        $valid_chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        for ($i = 0; $i < mb_strlen($password); $i++) {
            if (mb_substr_count($valid_chars, $password[$i]) == 0)
                return false;
        }
        return true;
    }

    /**
     * Check whether a descriptino is valid to be used by a star
     * @param string $description - the description to validate 
     * @return boolean - true for a valid password or false for an invalid password
     */
    public static function IsValidDescription(string $description) {
        if (empty($description))
            return false;
        return true;
    }

    /**
     * Search for stars 
     * @param string $name - the name to search for
     * @return boolean|array - a array containing the ids of the stars whose names look like the given name for search or false in case of any error
     */
    public static function Search(string $name) {

        $connection = self::GetConnection();
        if (mysqli_errno($connection))
            return false;

        $result = mysqli_query($connection, "select id from star where star.name like '%$name%'");
        if (is_bool($result)) {
            mysqli_close($connection);
            return false;
        }
        $ids = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_close($connection);
        return $ids;
    }

    public static function GetStarID(string $name) {
        $connection = self::GetConnection();
        if (mysqli_errno($connection))
            return false;
        if (!self::IsValidName($name))
            return false;
        if (!self::IsRegisteredName($name))
            return false;

        $result = mysqli_query($connection, "select id from star where name = '$name'");
        if (is_bool($result))
            return false;
        $id = (mysqli_fetch_array($result, MYSQLI_ASSOC))["id"];
        mysqli_close($connection);
        return $id;
    }

    public static function Exists(int $id) {
        if (empty($id) || !is_numeric($id))
            return false;
        $connection = self::GetConnection();
        if (mysqli_errno($connection))
            return false; //If an error occur, let's suppose the notification id is invalid
        $result = mysqli_query($connection, "select * from star where id = $id");
        $rows = mysqli_num_rows($result);
        mysqli_close($connection);
        if ($rows < 1)
            return false;
        return true;
    }

}
