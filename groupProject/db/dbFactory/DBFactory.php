<?php

namespace dbFactory;

use mysqli;
use mysqli_result;

class DBFactory
{
    private mysqli $mysqli;
    private function __construct(
        ?string $hostname = null,
        ?string $server = null,
        ?string $userName = null,
        ?string $password = null,
        string $database = null,
    )
    {
        $conn = new mysqli(
            self::getParam($hostname, ParamType::HOST_NAME),
            self::getParam($server, ParamType::SERVER),
            self::getParam($userName, ParamType::USER),
            self::getParam($password, ParamType::PASSWORD),
            $database
        );

        if($conn->connect_error) {
            die("Connection Error: $conn->connect_error");
        }
        $this->mysqli = $conn;
    }

    public static function createConnection(
        ?string $hostname = null,
        ?string $server = null,
        ?string $userName = null,
        ?string $password = null,
        string $database = null
    ): DBFactory
    {
        $factory = new DBFactory($hostname, $server, $userName, $password, $database);
        if($factory->getMysqli()->connect_error) {
            die("Connection Error: {$factory->getMysqli()->connect_error}");
        }
        return $factory;
    }


    public function createDatabase(string $dbName): bool|mysqli_result
    {
        $sql = "CREATE DATABASE IF NOT EXISTS $dbName";
        if(!$this->mysqli->error)
        {
            $this->mysqli->select_db($dbName);
        }
        return !$this->mysqli->query($sql);
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

    private function getParam(string|null $param, ParamType $type): string
    {
        if ($param || $param = ini_get("mysql.default_$type->value")):
            return $param;
        else: die("Connection Error: Invalid Server Parameter for $type->name");
        endif;
    }

    public function getMysqli(): mysqli
    {
        return $this->mysqli;
    }

    public function displayQueryResult(bool|mysqli_result $result): string
    {
        return $result ? "Success" : "Failed: {$this->mysqli->error}";
    }

}