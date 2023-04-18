<?php

include_once "Table.php";
class DestinationTable extends Table
{
    private string $name = "destination";
    public static function addTable(mysqli $conn): bool
    {
        $sql = <<<SQL
            CREATE TABLE destination(
                destination_id int NOT NULL AUTO_INCREMENT,
                destination_name varchar(50) NOT NULL UNIQUE,
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
        return $this->name;
    }

    public function add(mysqli $conn, Destination $destination): bool
    {
        $desc = addslashes($destination->getDescription());
        $sql =<<<SQL
        CALL addDestination('{$destination->getName()}', '{$desc}', '{$destination->getImageUrl()}', 
            '{$destination->getWebsite()}', '{$destination->getZip()}', '{$destination->getLine1()}', '{$destination->getLine2()}', 
            '{$destination->getCity()}')
        SQL;
        $destination->clear();
        return $conn->query($sql);
    }

    public function getById(mysqli $conn, int $id): Destination
    {
        $stmt = $conn->prepare(
            <<<SQL
            SELECT *, LENGTH(destination_desc) AS 'len' FROM destination WHERE destination_id = ?
            SQL
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $result->free();
        $stmt->close();
        if($data) {
            return new Destination($data['destination_id'], $data['destination_name'], $data['destination_desc'], $data['zip'],
                $data['line_1'], $data['line_2'], $data['city'], $data['image_url'], $data['website']);
        } else {
            return new Destination();
        }
    }
    public function getOptions(mysqli $conn): array
    {
        $result = $conn->query("SELECT destination_id, destination_name FROM destination ORDER BY destination_name");
        if(!$result)
        {
            echo $conn->error;
            return [];
        } else {
            $data = $result->fetch_all(1);
            $result->free();
        }

        return $data;
    }
    public function update(mysqli $conn, Destination $destination): bool
    {
        $desc = addslashes($destination->getDescription());
        $sql =<<<SQL
        CALL updateDestination({$destination->getId()},'{$destination->getName()}', '{$desc}', '{$destination->getImageUrl()}', 
            '{$destination->getWebsite()}', '{$destination->getZip()}', '{$destination->getLine1()}', '{$destination->getLine2()}', 
            '{$destination->getCity()}')
        SQL;
        return $conn->query($sql);
    }
    public function delete(mysqli $conn, Destination $destination): bool
    {
        $sql =<<<SQL
            CALL deleteDestination({$destination->getId()});
        SQL;
        $destination->clear();
        return $conn->query($sql);
    }

    public function getErrMsg(mysqli $conn, string $name): string
    {
        switch ($conn->errno)
        {
            case 1062:
                return "Error adding $name: a destination with that name already exists.";
            default:
                return "Error: $conn->error";
        }
    }
}