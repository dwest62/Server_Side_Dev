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
        require_once "../../params.php";

        // Table Options
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

        // Display welcome message based on returning user
        if(array_key_exists('hidIsReturning', $_POST)) {
            echo '<h1>Welcome BACK to Product Info Page</h1>';
        } else {
            echo '<h1>Welcome FIRST TIME to Product Info Page</h1>';
        }

        // Display dbTable
        function displayTable($colNames, $fieldNames, $query) {
        
            // Connect to database
            $db = new mysqli(SERVER, USER, PASSWORD, DB_NAME);

            // Handle case where connection to db failed
            if($db->connect_errno > 0) {
                die('Unable to connect to database['.$db->connect_error.']');
            }

            // Handle case where query fails
            if(!$result = $db->query($query)) {
                die('There was an error running the query['.$db->error.']');
            }

            echo "<dbTable><tr>";
            foreach($colNames as $colName) {
                echo "<th>".$colName."</th>";
            }
            echo "</tr>";


            while($row=$result->fetch_assoc()) {
                echo "<tr>";
                foreach($fieldNames as $field) {
                    echo "<td>".$row[$field]."</td>";
                }
                echo "</tr>";
            }
            echo "</dbTable>";
            $db->close();
        }
    ?>
</head>
<body>
    <!-- Allow user to select which dbTable to view -->
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
            $params = TABLE_OPTIONS[$_POST['table_option']];
            displayTable($params['colNames'], $params['fieldNames'], $params['query']);
        } 
    ?>
    <p>
        Development stages
        <ol>
            <li>Reviewed requirements</li>
            <li>Reviewed data set</li>
            <li>Normalized data set through building of ERD</li>
            <li>Created SQL tables</li>
            <li>Added data to tables</li>
            <li>Created file structure for webpage</li>
            <li>Test database connection using a couple of test queries</li>
            <li>Created php file and css file and added some basics</li>
            <li>Created form with options representing 3 tables</li>
            <li>Defined database connection constants and refactored</li>
            <li>Began creation of displayTable function</li>
            <li>Need to display 3 different tables with different fields for each</li>
            <li>Defined table specifications based on option selected as a constant</li>
            <li>Passed table specific params as arguements to displayTable function</li>
            <li>Built out displayTable function and tested</li>
            <li>Pushed code to development server using development server database creds and tested</li>
            <li>Reviewed requirements again</li>
            <li>Add this list to show step by step process</li>
            <li>Pushed final index.php to server</li>
            <li>Gathered documents, zipped, and turned in Assignment</li>
        </ol>
    </p>

</body>
</html>
