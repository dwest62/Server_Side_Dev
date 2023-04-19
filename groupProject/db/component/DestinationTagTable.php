<?php

include_once "Table.php";
class DestinationTagTable extends Table
{

    public static function addTable(mysqli $conn): bool
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
    public function getName(): string
    {
        return "destination_tag";
    }


    public function getDestinationTagsJoinTagType(DBHandler $dbh, Destination $destination): array
    {
        $conn = $dbh->getNewConn();
        $id = $destination->getId();
        $sql = <<<SQL
            CALL getDestinationTagsJoinTagType(?)
        SQL;
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(1);
        $stmt->free_result();
        $stmt->close();
        if(!$result){return [];}
        $dbh->getNewConn();
        return $result;

    }
}