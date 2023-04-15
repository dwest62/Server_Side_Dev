<?php

namespace dbfTable;

use mysqli;

class DestinationTagTable implements Table
{

    public static function addTable(mysqli $conn): bool|\mysqli_result
    {
        $sql = <<<SQL
            CREATE TABLE destination_tag(
                destination_tag_id int NOT NULL AUTO_INCREMENT,
                destination int NOT NULL,
                tag int NOT NULL,
                PRIMARY KEY (destination_tag_id),
                FOREIGN KEY (destination) REFERENCES destination(destination_id) ON DELETE CASCADE,
                FOREIGN KEY (tag) REFERENCES tag(tag_id) ON DELETE CASCADE ON UPDATE CASCADE
            )
        SQL;
        return $conn->query($sql);
    }

    public static function addEntry(mysqli $conn, int $destination, int $tag): bool|mysqli
    {
        $sql = <<<SQL
            INSERT INTO destination_tag VALUES (NULL, $destination, $tag)
        SQL;
        return $conn->query($sql);
    }
}