<?php

class DBFactory
{
    public static function connect(
        ?string $hostname = null,
        ?string $server = null,
        ?string $userName = null,
        ?string $password = null,
        ?string $database = null,
    ): mysqli | false
    {
        $conn = new mysqli(
            self::getParam($hostname, ParamType::HOST_NAME),
            self::getParam($server, ParamType::SERVER),
            self::getParam($userName, ParamType::USER),
            self::getParam($password, ParamType::PASSWORD),
            $database
        );

        if ($conn->connect_error) {
            die("Connection failed: $conn->connect_error");
        }
        return $conn;
    }

    /**
     * @return bool true if operation succeeds, otherwise false.
     */
    public static function createDatabase(string $dbName, mysqli $conn): bool
    {
        $sql = "CREATE DATABASE IF NOT EXISTS $dbName";
        return $conn->query($sql);
    }

    /**
     * @return bool true if database exists, otherwise false.
     */
    public static function databaseExists(string $dbName, mysqli $conn): bool
    {
        $sql = "SELECT schema_name FROM information_schema.schemata WHERE SCHEMA_NAME LIKE '$dbName'";
        return $conn->query($sql)->num_rows;
    }

    /**
     * @return bool true if operation succeeds, otherwise false
     */
    public static function dropDatabase(string $dbName, mysqli $conn): bool
    {
        $sql =
            "DROP DATABASE $dbName";
        return $conn->query($sql);
    }

    private static function getParam(string | null $param, ParamType $type): string
    {
        if($param):
            return $param;
        elseif ($param = ini_get("mysql.default_$type->value")):
            return $param;
        else:
            die("Connection Error: Invalid Server Paramet for $type->name");
        endif;
    }

}