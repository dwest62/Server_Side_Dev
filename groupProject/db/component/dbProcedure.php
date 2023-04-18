
<?PHP

    function getProcedures()
    {
        $procedures = [];
        $procedures['addDestination'] =
            <<<SQL
                CREATE PROCEDURE addDestination(
                    IN _destination_name varchar(50),
                    IN _destination_desc varchar(5000),
                    IN _image_url varchar(50),
                    IN _website varchar(300),
                    IN _zip varchar(35),
                    IN _line_1 varchar(95),
                    IN _line_2 varchar(95),
                    IN _city varchar(35)
                )
                BEGIN
                    INSERT INTO destination(destination_name, destination_desc, image_url, website, zip, line_1, line_2, city)
                    VALUES (_destination_name, _destination_desc, _image_url, _website, _zip, _line_1, _line_2, _city);
                END
            SQL;
        $procedures['updateDestination'] =
            <<<SQL
                CREATE PROCEDURE updateDestination(
                    IN id int,
                    IN _destination_name varchar(50),
                    IN _destination_desc varchar(5000),
                    IN _image_url varchar(50),
                    IN _website varchar(300),
                    IN _zip varchar(35),
                    IN _line_1 varchar(95),
                    IN _line_2 varchar(95),
                    IN _city varchar(35)
                )
                BEGIN
                    UPDATE destination
                    SET destination_name=_destination_name, destination_desc=_destination_desc, image_url=_image_url, 
                        website=_website, zip=_zip, line_1=_line_1, line_2=_line_2, city=_city
                    WHERE destination_id=id;
                END
            SQL;
        $procedures['deleteDestination'] =
            <<<SQL
            CREATE PROCEDURE deleteDestination(IN id int)
            BEGIN
                DELETE FROM destination WHERE destination_id=id;
            END;
            SQL;
        return $procedures;
    }
?>
