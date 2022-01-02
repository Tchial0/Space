<?php

namespace Space;

class Constellation extends InformationEntity {

    private $id = false;
    private $name = false;
    private $owner = false;
    private $img_name = false;
    private $description = false;
    private $date = false;

    public function __construct($id) {
        parent::__construct();
        if ($this->connected) {
            $result = $this->GetInformations($id);
            if (is_array($result)) {
                $this->id = $result["id"];
                $this->name = $result["name"];
                $this->owner = $result["owner"];
                $this->img_name = $result["img_name"];
                $this->description = $result["description"];
                $this->date = $result["date"];
                $this->initialized = true;
            } else {
                $this->SetError(self::INITIALIZATION_ERROR);
            }
        }
    }

    /**
     * Gets informations about a constellation from the database server
     * @param int $id - the id of the constellation
     * @return array an associative array containing the informations of the constellation 
     * @return int (QUERY_ERROR,EXISTENCE_ERROR) if an error occur
     */
    protected function GetInformations(int $id) {

        $result = $this->connection->query("select * from constellation where id = $id");

        if ($this->connection->errno)
            return false;

        if (mysqli_num_rows($result) < 1)
            return false;

        return mysqli_fetch_array($result, MYSQLI_ASSOC);
    }

    /**
     * Gets the name of the constellation
     * @return string the name of the constellation
     */
    public function GetName() {
        $this->ValidateInformationEntity();
        return $this->name;
    }

    /**
     * Gets the id of the constellation
     * @return int the id of the constellation
     */
    public function GetId() {
        $this->ValidateInformationEntity();
        return $this->id;
    }

    public function GetImageName() {
        $this->ValidateInformationEntity();
        return $this->img_name;
    }

    public function GetDate() {
        $this->ValidateInformationEntity();
        return $this->date;
    }

    public function GetDescription() {
        $this->ValidateInformationEntity();
        return htmlspecialchars($this->description);
    }

    /**
     * Gets the ids of the posts of this constellation
     * @param int $part - the start index of the posts to present
     * @param int $range - the quantity of posts to present
     * @return boolean|int|array false for failure, 0 if there is no post, an associative array containing the ids of the posts
     */
    public function GetPosts(int $part, int $range) {
        $this->ValidateInformationEntity();
        $command = "select id from post where const = $this->id limit $part,$range";
        $result = $this->connection->query($command);

        if ($this->connection->errno)
            return false;

        if (mysqli_num_rows($result) < 1)
            return 0;

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function AddStar(int $id) {
        $this->ValidateInformationEntity();
        $result = $this->connection->query("call add_star_in_const($id,$this->id)");
        return $result;
    }

    public function ContainsStar(int $id) {
        $this->ValidateInformationEntity();

        $command_text = "select id from star_in_const where const = $this->id and star = $id";
        $result = $this->connection->query($command_text);

        if ($this->connection->errno)
            return false;

        return (mysqli_num_rows($result) > 0 );
    }

    /**
     * Gets the ids of the members of this constellation
     * @return boolean|int|array false for failure, 0 if there is no post, an associative array containing the ids of the members
     */
    public function GetMembers() {
        $this->ValidateInformationEntity();

        $result = $this->connection->query("select star as id from star_in_const where const = $this->id");

        if ($this->connection->errno)
            return false;

        if (mysqli_num_rows($result) < 1)
            return 0;

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    /**
     * Counts the members of the constellation
     * @return int|bool the number of members or false in case of error
     */
    public function MembersCount() {
        $this->ValidateInformationEntity();

        $result = $this->connection->query("select count(*) from star_in_const where const = $this->id");

        if ($this->connection->errno)
            return false;

        return mysqli_fetch_array($result)[0];
    }

    /**
     * Counts the posts of the constellation
     * @return int|bool the number of posts or false in case of error
     */
    public function PostsCount() {
        $this->ValidateInformationEntity();

        $command_text = "select count(*) from post where const = $this->id";
        $result = $this->connection->query($command_text);

        if ($this->connection->errno)
            return false;

        return mysqli_fetch_array($result)[0];
    }

    public function HasOwner() {
        $this->ValidateInformationEntity();
        return ($this->owner != -1);
    }

    public function GetOwner() {
        $this->ValidateInformationEntity();
        return new Star($this->owner);
    }
    
    public function RemoveStar(int $star){
        if(!Star::Exists($star) || !$this->ContainsStar($star)) return false;
        $this->ValidateInformationEntity();
        return ($this->connection->query("delete from star_in_const where const = $this->id and star = $star"));
    }

    public static function IsValidName(string $name) {
        if (empty($name))
            return false; //The name can not be an empty string 
        if (mb_strlen($name) > 20 || mb_strlen($name) < 4)
            return false; //The name of a constellation must have at leat 4 characters and at most 20 characters uppercase
        $valid_chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

        for ($i = 0; $i < mb_strlen($name); $i++) {
            if (mb_substr_count($valid_chars, $name[$i]) == 0)
                return false;
        }
        return true;
    }

    public static function ExistsName(string $name) {
        if (!self::IsValidName($name))
            return false;

        $connection = self::GetConnection();
        if (mysqli_errno($connection))
            return true; //In case of error, suppose "existence"
        $result = mysqli_query($connection, "select const_name_exists('$name')");
        if (is_bool($result))
            return true; //In case of error, suppose "existence"
        $exists = (mysqli_fetch_array($result))[0];
        mysqli_close($connection);
        return ($exists == 1);
    }

    public static function GetConstID(string $name) {
        if (!self::ExistsName($name))
            return false;
        $connection = self::GetConnection();
        if (mysqli_errno($connection))
            return false;
        $result = mysqli_query($connection, "select get_const_id('$name')");
        if (is_bool($result))
            return false;
        $id = (mysqli_fetch_array($result))[0];
        mysqli_close($connection);
        return $id;
    }

    public static function Exists(int $id) {
        if (!is_numeric($id))
            return false;
        $connection = self::GetConnection();
        if (mysqli_errno($connection))
            return false;
        $result = mysqli_query($connection, "select const_id_exists($id)");
        if (is_bool($result))
            return false;
        $id = (mysqli_fetch_array($result))[0];
        mysqli_close($connection);
        return ($id == 1);
    }

    /**
     * Search for constellations 
     * @param string $name - the name to search for
     * @return boolean|array - a array containing the ids of the constellations whose names look like the given name for search or false in case of any error
     */
    public static function Search(string $name) {

        $connection = self::GetConnection();
        if (mysqli_errno($connection))
            return false;

        $result = mysqli_query($connection, "select id from constellation where constellation.name like '%$name%'");
        if (is_bool($result)) {
            mysqli_close($connection);
            return false;
        }
        $ids = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_close($connection);
        return $ids;
    }

}
