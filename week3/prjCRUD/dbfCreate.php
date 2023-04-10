<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Product page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- prjCRUD/dbfCreate.php - Display product information pulls from database
        Name: James Derek West
        Email: westj4@csp.edu
        Course: CSC235 Server-Side Development
        Assignment: Project 3
        Date: 3/29/2023
    -->

    <?PHP
    // link library
    require_once "dbfLib.php";
    require_once "../../params.php";

    // Initialize Paths to data for populating tables
    const PRODUCT_JSON_PATH = "data/product.json";
    const MANUFACTURER_JSON_PATH = "data/manufacturer.json";
    const DEPARTMENT_JSON_PATH = "data/department.json";


    $conn = createConnection(SERVER, USER, PASSWORD);

    /**
     * Main function
     */
    function main(): void
    {
        global $conn;

        // Drop database if exists.
        echo "<p>Database " . (databaseExists()
                ? (DATABASE_NAME . " exists.<br/>DROPPING database > " . getQueryResultMsg(dropDatabase()))
                : DATABASE_NAME . " does not exist.");

        // Create new database
        echo "<br />Creating database " . DATABASE_NAME . " from scratch > " . getQueryResultMsg(createNewDatabase());

        // Select database
        $conn->select_db(DATABASE_NAME);

        // Add tables
        echo "<br />Adding Tables > ";
        echo "<br />" . getQueryResultMsg(addTables()) . "<br />";

        // Add data to tables
        echo "<br />Adding data to Tables > <br />";
        echo getQueryResultMsg(addDataToTables());
	echo "</p>";
    }

    /**
     * Add data from json files to database
     * @return bool true if operation succeeds, otherwise false
     */
    function addDataToTables(): bool
    {
        global $conn;
        $productData = json_decode(file_get_contents(PRODUCT_JSON_PATH), true);
        $manufacturerData = json_decode(file_get_contents(MANUFACTURER_JSON_PATH), true);
        $departmentData = json_decode(file_get_contents(DEPARTMENT_JSON_PATH), true);

        // Add manufacturer data
        echo "&emsp;Manufacturer Table:<br />";
        foreach ($manufacturerData as $entry) {
            $sql =
                "INSERT INTO manufacturer (manufacturer_id, manufacturer_name, manufacturer_page)
                    VALUES (
                            NULL,
                            '{$entry["manufacturer_name"]}',
                            '{$entry["manufacturer_page"]}'
                    )";
            $result = $conn->query($sql);
            if (!$result) {
                echo $conn->error . "</br>";
                return false;
            }
            echo "&emsp;&emsp;" . $entry["manufacturer_name"] . " added!" . "<br />";
        }

        // Add Department data
        echo "&emsp;Department Table:<br />";
        foreach ($departmentData as $entry) {
            $sql =
                "INSERT INTO department
                    VALUES (
                            NULL,
                            '{$entry["department_name"]}',
                            '{$entry["manager"]}'
                    )";
            $result = $conn->query($sql);
            if (!$result) {
                echo $conn->error . "</br>";
                return false;
            }
            echo "&emsp;&emsp;" . $entry["department_name"] . " added!" . "<br />";
        }

        // Add product data
        echo "&emsp;Product Table:<br />";
        foreach ($productData as $entry) {
            $sql =
                "INSERT INTO product
                    VALUES (
                            {$entry['product_id']},
                            {$entry["department"]},
                            {$entry["manufacturer"]},
                            '{$entry['product_name']}',
                            '{$entry['color']}',
                            {$entry['price']},
                            {$entry['quantity']},
                            '{$entry['product_page']}'
                    )";
            $result = $conn->query($sql);
            if (!$result) {
                echo $conn->error . "</br>";
                return false;
            }
            echo "&emsp;&emsp;" . $entry["product_name"] . " added!" . "<br />";
        }
        return true;
    }

    /**
     * @return bool true if operation succeeds, otherwise false.
     */
    function addDepartmentTable(): bool
    {
        global $conn;

        $sql =
            "CREATE TABLE department (
                    department_id int NOT NULL AUTO_INCREMENT,
                    department_name varchar(100) NOT NULL,
                    manager varchar(100) NOT NULL,
                    PRIMARY KEY (department_id)
                )";

        return $conn->query($sql);
    }

    /**
     * @return bool true if operation succeeds, otherwise false.
     */
    function addManufacturerTable(): bool
    {
        global $conn;

        $sql =
            "CREATE TABLE manufacturer (
                    manufacturer_id int NOT NULL AUTO_INCREMENT,
                    manufacturer_name varchar(30) NOT NULL,
                    manufacturer_page varchar(3000) NOT NULL,
                    PRIMARY KEY (manufacturer_id)
                )";

        return $conn->query($sql);
    }

    /**
     * @return bool true if operation succeeds, otherwise false.
     */
    function addProductTable(): bool
    {
        global $conn;
        $sql =
            "CREATE TABLE product(
                    product_id int NOT NULL AUTO_INCREMENT,
                    department int,
                    manufacturer int,
                    product_name varchar(30) NOT NULL,
                    color varchar(15) NOT NULL,
                    price decimal(10, 2) NOT NULL,
                    quantity smallint NOT NULL,
                    page varchar(3000) NOT NULL,
                    PRIMARY KEY (product_id),
                    FOREIGN KEY (department) REFERENCES department(department_id),
                    FOREIGN KEY (manufacturer) REFERENCES manufacturer(manufacturer_id)
                )";
        return $conn->query($sql);
    }


    /**
     * @return bool true if operation succeeds, otherwise false.
     */
    function addTables(): bool
    {
        foreach (
            [
                ["manufacturer", "addManufacturerTable"],
                ["department", "addDepartmentTable"],
                ["product", "addProductTable"]
            ] as $nameFunc) {
            $success = ($nameFunc[1])();
            echo "<br />&emsp;Adding $nameFunc[0] table > " . getQueryResultMsg($success);
            if (!$success) {
                return false;
            }
        }
        return true;
    }

    // Source: https://www.tutorialspoint.com/how-to-check-if-a-mysql-database-exists. Checks if database exists.


    //
    /**
     * @return bool true if operation succeeds, otherwise false.
     */
    function createNewDatabase(): bool
    {
        global $conn;
        $sql =
            "CREATE DATABASE " . DATABASE_NAME;
        return $conn->query($sql);
    }

    /**
     * @return bool true if database exists, otherwise false.
     */
    function databaseExists(): bool
    {
        global $conn;
        $sql = "SELECT schema_name FROM information_schema.schemata WHERE SCHEMA_NAME LIKE " . "'" . DATABASE_NAME . "'";
        return $conn->query($sql)->num_rows;
    }

    /**
     * @return bool true if operation succeeds, otherwise false
     */
    function dropDatabase(): bool
    {
        global $conn;
        $sql =
            "DROP DATABASE " . DATABASE_NAME;
        return $conn->query($sql);
    }


    /**
     * @param bool $query was the query a success?
     * @return String "'success!' if true, otherwise 'failure!'
     */
    function getQueryResultMsg(bool $query): String
    {
        return $query ? "success!" : "failure!";
    }
    ?>
</head>
<body>
<h1>Creating database Log</h1>
<!-- Allow user to select which table to view -->
<?PHP
main();
?>
<h1>Tables</h1>
<?PHP

global $conn;

$sql = "SELECT * FROM product";
echo "<h3>Product Table</h3>";
displayTable($sql, $conn, NULL);

$sql = "SELECT * FROM department";
echo "<h3>Department Table</h3>";
displayTable($sql, $conn, NULL);

$sql = "SELECT * FROM manufacturer";
echo "<h3>Manufacturer Table</h3>";
displayTable($sql, $conn, NULL);

$conn->close();
?>


</body>
</html>
