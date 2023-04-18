<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Product page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- prjCRUD/dbfJoin.php - Demonstrates the use of Joins
        Name: James Derek West
        Email: westj4@csp.edu
        Course: CSC235 Server-Side Development
        Assignment: Project 3
        Date: 3/27/2023
    -->

    <?PHP
    require_once "dbfLib.php";
    require_once "../../params.php";
    require_once "tableParams.php";
    ?>
</head>
<body>
<h1>Difference between MYSQL JOINS</h1>
<p>
    SQL databases have been standard in the industry for some time due in large part to their ability to handle
    complex relational data, particularly one-to-many and many-to-many relationships. In order to access this data,
    developers use queries which tell the database what data is required. One-to-many relationships are
    often described in SQL databases by incorporating a foreign key in the many side of the relationship. This foreign
    key references a primary key in another table. In many cases, however, developers need to access not just the
    foreign key, but the data from the entry in the other table of which the foreign key references. To do this, the
    tables can be "JOIN"ed. MYSQL provides the use of 4 types of joins: JOIN (INNER JOIN), LEFT OUTER JOIN,
    RIGHT OUTER JOIN, and CROSS JOIN.<br /><br />

    A JOIN involves two tables and JOIN condition. The default JOIN for MYSQL is INNER JOIN which returns only entries
    from both tables which meet this JOIN condition.<br /><br />

    A LEFT OUTER JOIN, by contrast, return all entries the first table. If the first table contains entries which do not
    meet the JOIN condition, they are still returned, but may not contain any data (NULL) for fields involving the
    second table. No entries from the second table which do not meet the condition will be retrieved.<br /><br />

    A RIGHT OUTER JOIN is the same as a LEFT OUTER JOIN except the first and second table are swapped.<br /><br />

    An INNER JOIN is useful when a developer wants to query only the entries from both tables which match the JOIN
    condition.<br /><br />

    OUTER JOINs are useful when a developer wants to query entries from one table despite whether it matches the
    conditional while restricting entries which do not match the conditional from the other table.<br /><br />

    Lastly, CROSS JOIN is like taking a RIGHT OUTER JOIN and LEFT OUTER JOIN and combining them while removing
    duplicates. It is useful for displaying all data.<br /><br />
</p>
<h1>Demonstration</h1>
<!-- Allow user to select which table to view -->
<form name="formDBF" method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
    What information would you like to view?
    <select name="option" onchange="this.form.submit()">
        <option value="null">Select an item</option>
        <?php

            foreach (TABLE_OPTIONS as $key=>$value)
            {
                echo "<option value='$key'>{$value['name']}</option>";
            }
        ?>
    </select>

    <!-- Hidden field informing server if this is a return visitor -->
    <input type="hidden" name="hidIsReturning" value="true" />
</form>

<?php
if(array_key_exists('option', $_POST) && $_POST['option'] != "null")
{
    $conn = createConnection(SERVER, USER, PASSWORD);
    $conn->select_db(DB_NAME);

    $params = TABLE_OPTIONS[$_POST['option']];
    displayParameterizedTable($params, $conn);
    echo "<p id='table_details'><strong>Query</strong>: " . $params['query'];
    echo "<br/><strong>Explanation</strong>: " . $params['explanation'] . "</p><div id='bar'></div>";

    $conn->close();
}
?>
</body>
</html>
