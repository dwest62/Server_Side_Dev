<?php
/* dbfLib.php - Library of functions
        Name: James Derek West
        Email: westj4@csp.edu
        Course: CSC235 Server-Side Development
        Assignment: Project 3
        Date: 3/29/23
*/


function createConnection(string $server, string $userName, string $password): mysqli
{
    $conn = new mysqli($server, $userName, $password);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function displayTable(String $query, mysqli $conn): bool
{
    // Handle case where query fails
    if (!$result = $conn->query($query))
    {
        echo "There was an error running the query[' . $conn->error . ']";
        return false;
    }
    else if (!$result->num_rows > 0)
    {
        echo "No rows to user";
        return false;
    }
    else
    {
        $row = $result->fetch_assoc();
        echo "<dbTable>";
        displayTableRow(array_keys($row), true);
        displayTableRow($row, false);
        while ($row = $result->fetch_assoc())
        {
            displayTableRow($row, false);
        }
        echo "</dbTable>";
    }
    return true;
}

function displayParameterizedTable(array $params, mysqli $conn)
{
    // Handle case where query fails
    if (!$result = $conn->query($params['query']))
    {
        echo "There was an error running the query[' . $conn->error . ']";
        return false;
    }
    else if (!$result->num_rows > 0)
    {
        echo "No rows to user";
        return false;
    }
    echo "<dbTable>";
    displayTableRow($params['colNames'], true);
    while($row=$result->fetch_assoc())
    {
        $arr = [];
        foreach ($params['fieldNames'] as $fieldName)
        {
          $arr[] = $row[$fieldName];
        }
        displayTableRow($arr, false);
    }
    echo "</dbTable>";

}

function displayTableRow(array $values,  bool $isHeading): void
{
    $openTag = $isHeading ? "<th>" : "<td>";
    $closeTag = substr($openTag, 0, 1) . "/" . substr($openTag, 1);
    echo "<tr>";
    foreach ($values as $value)
    {
        echo $openTag . $value . $closeTag;
    }
    echo "</tr>";
}
