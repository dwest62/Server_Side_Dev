<?php

namespace sunRunTable;

use mysqli;

class RaceTable implements \Table
{
    public static function buildTable(mysqli $conn): bool
    {
        $sql = <<<SQL
        CREATE TABLE IF NOT EXISTS race (
            id_race     INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            raceName    VARCHAR(25) NOT NULL,
            entranceFee SMALLINT
        )
        SQL;
        return $conn->query($sql);
    }

    public static function addRace(mysqli $conn, string $raceName, int $entranceFee): bool
    {
        $sql = <<<SQL
        INSERT INTO race (id_race, raceName, entranceFee)
        VALUES (NULL, '$raceName', $entranceFee)
        SQL;
        return $conn->query($sql);
    }
}