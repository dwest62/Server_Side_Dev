<?php

namespace dbfTable;

use mysqli;

class TagTable implements Table
{
    public static function addTable(mysqli $conn): bool|\mysqli_result
    {
        $sql = <<<SQL
            CREATE TABLE tag(
                tag_id int NOT NULL AUTO_INCREMENT,
                tag_type int,
                tag_name varchar(30) NOT NULL,
                PRIMARY KEY (tag_id),
                FOREIGN KEY (tag_type) REFERENCES tag_type(tag_type_id) ON DELETE CASCADE
            )
        SQL;
        return $conn->query($sql);
    }

    public function addEntry(mysqli $conn, ?int $tag_type, string $tag_name): bool|\mysqli_result
    {
        $sql = <<<SQL
            INSERT INTO tag VALUES (NULL, $tag_type, $tag_name)
        SQL;
        return $conn->query($sql);
    }
}