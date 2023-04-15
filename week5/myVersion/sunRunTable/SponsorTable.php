<?php

namespace sunRunTable;

use mysqli;

class SponsorTable implements \Table
{
    public static function buildTable(mysqli $conn): bool
    {
        $sql = <<<SQL
        CREATE TABLE IF NOT EXISTS sponsor (
            id_sponsor      INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            sponsorName     VARCHAR(50) NOT NULL,
            id_runner       INT(6),
            FOREIGN KEY (id_runner) references runner(id_runner) ON DELETE CASCADE
        )
        SQL;
        return $conn->query($sql);
    }

    public static function addSponsor(mysqli $conn, string $sponsorName, int $id_runner): bool
    {
        $sql = <<<SQL
        INSERT INTO sponsor
        VALUES (NULL, '$sponsorName', $id_runner)
        SQL;
        return $conn->query($sql);
    }
}