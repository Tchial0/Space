<?php

namespace Space;

final class ReportedError extends InformationEntity {

    private $id = false;
    private $owner = false;
    private $content = false;
    private $date = false;
    private $time = false;

    public function __construct(int $reported_error_id) {
        parent::__construct();
        if ($this->connected) {
            $result = $this->GetInformations($reported_error_id);
            if (is_array($result)) {
                $this->id = $result["id"];
                $this->owner = $result["owner"];
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
     * Retrieves informations about a reported error from the database
     * @param int $id - the id of the reported error
     * @return array an associative array containing the informations of the reported error 
     * @return int (QUERY_ERROR,EXISTENCE_ERROR) if an error occur
     */
    protected function GetInformations(int $id) {
        $result = $this->connection->query("select * from reported_error where id = $id");

        if ($this->connection->errno)
            return false;

        if (mysqli_num_rows($result) < 1)
            return false;

        return mysqli_fetch_array($result, MYSQLI_ASSOC);
    }

    /**
     * Gets the id of the repoted error
     * @return int the id of the reported error
     */
    public function GetId() {
        $this->ValidateInformationEntity();
        return $this->id;
    }

    /**
     * Gets the content of the reported error
     * @return string the content of the reported error
     */
    public function GetContent() {
        $this->ValidateInformationEntity();
        return htmlspecialchars($this->content);
    }

    /**
     * Gets the date of the reported error
     * @return string the date of the reported error
     */
    public function GetDate() {
        $this->ValidateInformationEntity();
        return $this->date;
    }

    /**
     * Gets the time of the reported error
     * @return string the time of the reported error
     */
    public function GetTime() {
        $this->ValidateInformationEntity();
        return $this->time;
    }

    public function GetOwner() {
        $this->ValidateInformationEntity();
        return new Star($this->owner);
    }
    
    public static function IsValidContent(string $content){
        if(empty($content) || empty(trim($content))) return false; 
        return true;
    }
    
    public static function ReportError(string $content){
        $connection = self::GetConnection();
        if (mysqli_errno($connection)) return false;
        $star_id = Star::MyStar()->GetId();
        $result = mysqli_query($connection, "call report_error($star_id,'$content')");
        mysqli_close($connection);
        return $result;
    }

}

?>