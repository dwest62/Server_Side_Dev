<?php

class DBFactory
{
    private mysqli $mysqli;
    private function __construct(
        ?string $hostname,
        ?string $userName,
        ?string $password,
        ?string $database
    )
    {
        $conn = new mysqli(
            self::getParam($hostname, "host"),
            self::getParam($userName, "user"),
            self::getParam($password, "password"),
            $database
        );

        if($conn->connect_error) {
            die("Connection Error: $conn->connect_error");
        }
        $this->mysqli = $conn;
    }

    public static function createConnection(
        ?string $hostname,
        ?string $userName,
        ?string $password,
        ?string $database
    ): DBFactory
    {
        $factory = new DBFactory($hostname, $userName, $password, $database);
        if($factory->getMysqli()->connect_error) {
            die("Connection Error: {$factory->getMysqli()->connect_error}");
        }
        return $factory;
    }


    public function createDatabase(string $dbName): bool
    {
        $sql = "CREATE DATABASE IF NOT EXISTS $dbName";
        if(!$this->mysqli->error)
        {
            $this->mysqli->select_db($dbName);
        }
        return $this->mysqli->query($sql);
    }


    public function databaseExists(string $dbName): bool
    {
        $sql = "SELECT schema_name FROM information_schema.schemata WHERE SCHEMA_NAME LIKE '$dbName'";
        return $this->mysqli->query($sql)->num_rows;
    }


    public function dropDatabase(string $dbName): bool
    {
        $sql =
            "DROP DATABASE $dbName";
        return $this->mysqli->query($sql);
    }

    private function getParam(?string $param, string $type): string
    {
        if ($param || $param = ini_get("mysql.default_$type")):
            return $param;
        else: die("Connection Error: Invalid Server Parameter for $type");
        endif;
    }

    public function getMysqli(): mysqli
    {
        return $this->mysqli;
    }

    public function displayQuerySuccess($result): string
    {
        return $result ? "Success" : "Failed: {$this->mysqli->error}";
    }

}