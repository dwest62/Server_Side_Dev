<?php

include_once "Table.php";
class DestinationTable extends Table
{
    public static function addTable(mysqli $conn): bool
    {
        $sql = <<<SQL
            CREATE TABLE destination(
                destination_id int NOT NULL AUTO_INCREMENT,
                destination_name varchar(50) NOT NULL,
                destination_desc varchar(5000) NOT NULL,
                image_url varchar(50),
                website varchar(300),
                zip varchar(35) NOT NULL,
                line_1 varchar(95) NOT NULL,
                line_2 varchar(95) NOT NULL,
                city varchar(35) NOT NULL,
                PRIMARY KEY (destination_id)
        )
        SQL;
        return $conn->query($sql);
    }

    public function getName(): string
    {
        return "destination";
    }
}