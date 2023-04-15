<?php

namespace sunRunTable;

use mysqli;

class RunnerTable implements \Table
{

    public static function addTableToDatabase(mysqli $conn): bool
    {
        $sql = <<<SQL
        CREATE TABLE IF NOT EXISTS runner (
            id_runner   INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            fName       VARCHAR(25) NOT NULL,
            lName       VARCHAR(25) NOT NULL,
            gender      VARCHAR(10),
            phone       VARCHAR(10)
        )
        SQL;
        return $conn->query($sql);
    }

    public static function addRunnerRace(mysqli $conn, string $fName, string $lName, ?string $gender,
        ?string $phone ): bool
    {
        $sql = <<<SQL
        INSERT INTO runner
        VALUES (NULL, $fName, $lName, $gender, $phone)
        SQL;
        return $conn->query($sql);
    }
}