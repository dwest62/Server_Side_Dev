<?php

namespace sunRunTable;

use mysqli;

class runnerRaceTable implements \Table
{
    public static function addTableToDatabase(mysqli $conn): bool
    {
        $sql = <<<SQL
        CREATE TABLE IF NOT EXISTS runner_race (
            id_runner INT(6) NOT NULL ,
            id_race   INT(6) NOT NULL ,
            bibNumber INT(6),
            paid      BOOLEAN,
            FOREIGN KEY (id_runner) REFERENCES runner(id_runner) ON DELETE CASCADE,
            FOREIGN KEY (id_race) REFERENCES race(id_race) ON DELETE CASCADE,
            PRIMARY KEY (id_runner, id_race)
        )
        SQL;
        return $conn->query($sql);
    }

    public static function addRunnerRace(mysqli $conn, int $id_runner, int $id_race, ?int $bibNumber, ?bool $paid ): bool
    {
        $sql = <<<SQL
        INSERT INTO runner_race
        VALUES ($id_runner, $id_race, $bibNumber, $paid)
        SQL;
        return $conn->query($sql);
    }
}