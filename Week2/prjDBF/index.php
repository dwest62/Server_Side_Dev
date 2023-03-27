<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Product page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- prjDBF/index.php - Display product information pulls from database
        Name: James Derek West
        Email: westj4@csp.edu
        Course: CSC235 Server-Side Development
        Assignment: Project 2
        Date: 3/27/2023
    -->

    <?PHP
        // Constants
        // define('DB_USERNAME', 'root');
        // define('DB_PASSWORD', 'mysql');
        // define('DB_NAME', 'prjdbf');

        define('DB_USERNAME', 'root');
        define('DB_PASSWORD', 'XxABWPJ3ESB3');
        define('DB_NAME', 'prjdbf');

        define("TABLE_OPTIONS", 
        [
            "product" => 
            [
                "colNames" => ["Product Name", "Color", "Price", "On Hand Quantity", "Product Page"],
                "fieldNames" => ["product_name", "color", "price", "quantity", "product_page"],
                "query" => "Select * FROM product"
            ],
            "manufacturer" => 
            [
                "colNames" => ["Manufacturer", "Manufacturer Website"],
                "fieldNames" => ["manufacturer_name", "manufacturer_page"],
                "query" => "Select * FROM manufacturer"
            ],
            "department" =>
            [
                "colNames" => ["Department", "Department Manager"],
                "fieldNames" => ["department_name", "manager"],
                "query" => "Select * FROM department"      
            ]
        ]);

        // Returning visitor?
        if(array_key_exists('hidIsReturning', $_POST)) {
            echo '<h1>Welcome BACK to Product Info Page</h1>';
        } else {
            echo '<h1>Welcome FIRST TIME to Product Info Page</h1>';
        }

        function displayTable($option) {
            define("TABLE_PARAMS", TABLE_OPTIONS[$option]);

            // Connect to database
            $db = new mysqli('localhost', DB_USERNAME, DB_PASSWORD, DB_NAME);

            // Handle case where connection to db failed
            if($db->connect_errno > 0) {
                die('Unable to connect to database['.$db->connect_error.']');
            }

            // Handle case where query fails
            if(!$result = $db->query(TABLE_PARAMS["query"])) {
                die('There was an error running the query['.$db->error.']');
            }

            echo "<table><tr>";
            foreach(TABLE_PARAMS["colNames"] as $name) {
                echo "<th>".$name."</th>";
            }
            echo "</tr>";


            while($row=$result->fetch_assoc()) {
                echo "<tr>";
                foreach(TABLE_PARAMS["fieldNames"] as $field) {
                    echo "<td>".$row[$field]."</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
            $db->close();
        }
    ?>
</head>
<body>
    <!-- Allow user to select which table to view -->
    <form name="formDBF" method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
        What information would you like to veiw?
        <select name="table_option" onchange="this.form.submit()">
            <option value="null">Select an item</option>
            <option value="product">Product</option>
            <option value="manufacturer">Manufacturer</option>
            <option value="department">Department</option>
        </select>

        <!-- Hidden field informing server if this is a return visitor -->
        <input type="hidden" name="hidIsReturning" value="true" />
    </form>
    <?php
        if(array_key_exists('table_option', $_POST) && $_POST['table_option'] != "null"){
            displayTable($_POST['table_option']);
        } 
    ?>
</body>
</html>