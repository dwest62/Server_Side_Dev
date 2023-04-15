<?php

namespace dbfTable;

use mysqli;

class TagTypeTable implements Table
{
    public static function addTable(mysqli $conn): bool | \mysqli_result
    {
        $sql = <<<SQL
            CREATE TABLE tag_type(
                tag_type_id int NOT NULL AUTO_INCREMENT,
                tag_type_name varchar(30) NOT NULL,
                PRIMARY KEY (tag_type_id)
            )
        SQL;
        return $conn->query($sql);
    }

    public function addEntry(mysqli $conn, string $tag_type_name): bool | \mysqli_result
    {
        $sql = <<<SQL
            INSERT INTO tag_type VALUES (NULL, $tag_type_name)
        SQL;
        return $conn->query($conn);
    }
}