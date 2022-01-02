<?php

namespace Space;

abstract class InformationEntity {

    //For database connection 
    const DB_HOSTNAME = "localhost";
    const DB_USERNAME = "root";
    const DB_PASSWORD = "";
    const DB_DATABASE = "space";
    //Error Types
    const CONNECTION_ERROR = 100;
    const INITIALIZATION_ERROR = 104;

    protected $error = 0;
    protected $connected = false;
    protected \mysqli $connection;
    protected $initialized = false;

    public function __construct() {
        $this->connection = new \mysqli(self::DB_HOSTNAME, self::DB_USERNAME, self::DB_PASSWORD, self::DB_DATABASE);
        if ($this->connection->errno) {
            $this->connected = false;
            $this->SetError(self::CONNECTION_ERROR);
        } else {
            $this->connected = true;
        }
    }

    /**
     * Validate this information entity and throws an Exception if there is an error
     * @throws InformationEntityException in case of any error
     */
    final protected function ValidateInformationEntity() {
        if (!$this->connected || $this->error != 0) {
            $error_type = $this->GetErrorType();
            throw new InformationEntityException($error_type);
        }
    }

    /**
     * Verify if there is an error
     * @return bool 
     * @throws InformationEntityException in case of any error regarding this information entity
     */
    public function HasError() {
        return (!$this->connected || $this->error != 0);
    }

    /**
     * Gets the type of the error, in case of no error returns "No Error"
     * @return string the name indentifying the type of the error
     * @throws InformationEntityException in case of any error regarding this information entity
     */
    public function GetErrorType(): string {

        if ($this->error == self::CONNECTION_ERROR || !$this->connected)
            return "Connection Error";
        if ($this->error == self::INITIALIZATION_ERROR)
            return "Initialization Error";

        return "No Error";
    }

    /**
     * Returns a value indicating if the information entity has been initialized or not
     * @return bool 
     */
    public function Initialized() {
        return $this->initialized;
    }

    public function Connected(): bool {
        return $this->connected;
    }

    /**
     * Check if there is connection error
     * @return bool 
     * @throws InformationEntityException in case of any error regarding this information entity
     */
    public function HasConnectionError() {
        return $this->Connected();
    }

    /**
     * Set the error number for this information entity
     * @param int $num (QUERY_ERROR, EXISTENCE_ERROR,CONNECTION_ERROR, INITIALIZATION_ERROR)
     */
    protected function SetError(int $num) {
        $this->error = $num;
    }

    /**
     * Retrieves informations about an information entity from the database
     * @param int $id - the id of the information entity
     * @return array an associative array containing the informations of the information entity
     * @return bool false if an error occur
     */
    protected abstract function GetInformations(int $id);

    public function __destruct() {
        if ($this->connected)
            $this->connection->close();
    }

    /**
     * Returns a connection to the database
     * @return \mysqli a connection to the database
     */
    public static function GetConnection() {
        $connection = \mysqli_connect(self::DB_HOSTNAME, self::DB_USERNAME, self::DB_PASSWORD, self::DB_DATABASE);
        mysqli_set_charset($connection, "utf8mb4");
        return $connection;
    }

}
