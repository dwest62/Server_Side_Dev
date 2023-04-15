<?php

namespace dbfTable;

use mysqli;

class DestinationTable implements Table
{
    public static function addTable(mysqli $conn): bool|\mysqli_result
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

    public static function addData(mysqli $conn, string $destination_name, string $destination_desc, string $image_url,
        string $website, string $zip, string $line_1, string $line_2, string $city): bool|mysqli
    {
        $sql = <<<SQL
            INSERT INTO destination VALUES (NULL, $destination_name, $destination_desc, $image_url, $website, $zip, 
                                            $line_1, $line_2, $city)
        SQL;
        return $conn->query($sql);
    }

}