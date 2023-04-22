<!DOCTYPE html>
<html lang='en'>
   <head>
   <meta charset="utf-8" />
   <title>Sun Run Create</title>
   </head>
<body>
<?PHP
/* sunRunCreate.php - Demonstrate SQL create and populate
             Registration data for the Sun Run Marathon
   Written by Peter K. Johnson for The Learning House
   Written  08-01-15
   Revised: 08-05-15 Refactor code grouping the create and add records together
                     Populate runner_race table 
*/
   
// Set up connection constants
// Using default username and password for AMPPS  
define("SERVER_NAME","localhost");
define("DBF_USER_NAME", "root");
define("DBF_PASSWORD", "mysql");
define("DATABASE_NAME", "sunRun");

// Create connection object
$conn = new mysqli(SERVER_NAME, DBF_USER_NAME, DBF_PASSWORD);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Start with a new database to start primary keys at 1
$sql = "DROP DATABASE " . DATABASE_NAME;
runQuery($sql, "DROP " . DATABASE_NAME, true);

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS " . DATABASE_NAME;
if ($conn->query($sql) === TRUE) {
    echo "The database " . DATABASE_NAME . " exists or was created successfully!<br />";
} else {
    echo "Error creating database " . DATABASE_NAME . ": " . $conn->error;
    echo "<br />";
}

// Select the database
$conn->select_db(DATABASE_NAME);

/*******************************
 * Create Tables
 *******************************/
// Create Table:runner
$sql = "CREATE TABLE IF NOT EXISTS runner (
        id_runner INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        fName     VARCHAR(25) NOT NULL,
        lName     VARCHAR(25) NOT NULL,
        gender    VARCHAR(10),
        phone     VARCHAR(10)
        )";
runQuery($sql, "Table:runner", false);

// Create Table:race
$sql = "CREATE TABLE IF NOT EXISTS race (
     id_race     INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
     raceName        VARCHAR(25) NOT NULL,
     entranceFee SMALLINT
     )";
runQuery($sql, "Table:race", false);

// Create Table:runner_race if it doesn't exist
// One racer can run multiple races
$sql = "CREATE TABLE IF NOT EXISTS runner_race (
  id_runner INT(6),
  id_race   INT(6),
  bibNumber INT(6),
  paid      BOOLEAN
  )"; 
runQuery($sql, "Table:runner_race", false);

// Create Table:sponsor
$sql = "CREATE TABLE IF NOT EXISTS sponsor (
     id_sponsor      INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
     sponsorName     VARCHAR(50) NOT NULL,
     id_runner       INT(6)
     )";
runQuery($sql, "Table:sponsor", false);

/***************************************************
 * Populate Tables Using Sample Data
 * This data will later be collected using a form
 ***************************************************/
// Populate Table:runner
$runnerArray = array(
   array("Johnny", "Hayes", "male", "1234567890"),
   array("Robert", "Fowler", "male","2234567890"),
   array("James", "Clark", "male","3234567890"),
   array("Marie-Louise", "Ledru", 'female',"4234567890")
   );

foreach($runnerArray as $runner) {
   $sql = "INSERT INTO runner (fName, lName, gender,phone) "
       . "VALUES ('" . $runner[0] . "', '" 
       . $runner[1] . "', '" 
       . $runner[2] . "', '"
       . $runner[3] . "')";
       
   //echo "\$sql string is: " . $sql . "<br />";
   runQuery($sql, "New record insert $runner[1]", false);
} 

// Populate Table:race
$raceArray = array(
   array("10K", 46),
   array("5K", 46),
   array("Marathon", 85),
   array("Half Marathon", 75)
);

foreach($raceArray as $race) {
   $sql = "INSERT INTO race (id_race, raceName, entranceFee) "
       . "VALUES (NULL, '" . $race[0] . "', '" 
       . $race[1] . "')";
       
   //echo "\$sql string is: " . $sql . "<br />";
   runQuery($sql, "New record insert $race[1]", false);
}


// Populate Table:sponsor
$sponsorArray = array(
   array("Nike",  2),
   array("Western Hospital", 3),
   array("House of Heroes", 4)
   );
   
foreach($sponsorArray as $sponsor) {
   $sql = "INSERT INTO sponsor (id_sponsor, sponsorName, id_runner) "
       . "VALUES (NULL, '" . $sponsor[0] . "', '" 
       . $sponsor[1] . "')";
       
   //echo "\$sql string is: " . $sql . "<br />";
   runQuery($sql, "New record insert $sponsor[0]", false);
}

// Add a sponsor that is not yet sponsoring a runner.
$sql = "INSERT INTO sponsor (id_sponsor, sponsorName, id_runner) "
       . "VALUES (NULL, 'Wells Fargo Bank', NULL)";
   runQuery($sql, "New record insert Wells Fargo", false);
       

// Populate Table:runner_race
// Determine id_runner for Robert Fowler
$sql = "SELECT id_runner FROM runner WHERE fName='Robert' AND lName='Fowler'";
$result = $conn->query($sql);
$record = $result->fetch_assoc();
//echo '$record: <pre>';
//print_r($record);
//echo '</pre>';
$thisRunner = $record['id_runner'];
//echo '$thisRunner: ' . $thisRunner . '<br />';

// Determine id_race for Half Marathon
$sql = "SELECT id_race FROM race WHERE raceName='Half Marathon'";
$result = $conn->query($sql);
$record = $result->fetch_assoc();
$thisRace = $record['id_race'];
//echo '$thisRace: ' . $thisRace . '<br />';


// Check to make sure runner hasn't already registered for this race
$sql = "SELECT id_race FROM runner_race WHERE id_race = " . $thisRace;
if ($result = $conn->query($sql)) {
   //determine number of rows result set 
   $row_count = $result->num_rows;
   if($row_count > 0) {
      echo "Runner " . $thisRunner
      . " has already registered for race " 
      . $thisRace . "<br />";
   } else { // Not a duplicate
      $sql = "INSERT INTO runner_race (id_runner, id_race, bibNumber, paid) 
         VALUES (" . $thisRunner . ", " . $thisRace . ", 1234, true)";
      runQuery($sql, "Insert " . $thisRunner . " and " . $thisRace, false);
   } // end of if($row_count)
} // end if($result)

// Add each sample runner to the Marathon and Half Marathon
foreach($runnerArray as $runner) {
   //echo "<strong>Adding $runner[0] $runner[1]</strong><br />";
   buildRunnerRace($runner[0], $runner[1], "Marathon");
   buildRunnerRace($runner[0], $runner[1], "Half Marathon");
} 


// Add in extra runners who aren't registered for a race yet.
$sql = "INSERT INTO runner (id_runner, fName, lName, gender,phone) "
    . "VALUES (NULL, 'John', 'Watson', 'male', '5071237899')";
   runQuery($sql, "New record insert John Watson", false);

$sql = "INSERT INTO runner (id_runner, fName, lName, gender,phone) "
    . "VALUES (NULL, 'Sally', 'Johnson', 'female', '8121237800')";
   runQuery($sql, "New record insert Sally Johnson", false);

$sql = "INSERT INTO runner (id_runner, fName, lName, gender,phone) "
    . "VALUES (NULL, 'Paula', 'Radcliff', 'female', '8029881123')";
   runQuery($sql, "New record insert Sally Johnson", false);


/***************************************************
 * Display the Data
 ***************************************************/
// Table:runner
$sql = "SELECT * FROM runner";
echo "<strong>Table: runner</strong><br />";
$result = $conn->query($sql);
displayResult($result, $sql);
echo "<br />";

// Table:race
$sql = "SELECT * FROM race";
echo "<strong>Table: race</strong><br />";
$result = $conn->query($sql);
displayResult($result, $sql);
echo "<br />";

// Table:sponsor
$sql = "SELECT * FROM sponsor";
echo "<strong>Table: sponsor</strong><br />";
$result = $conn->query($sql);
displayResult($result, $sql);
echo "<br />";

 
// Close the database
$conn->close();


/****************************************************************
 * buildRunnerRace( ) - Register runner for specific races
 *                       using sample data.
 *  Sets up a table with two foreign keys 
 *  connecting Table:runner to Table:race
 *    Parameters:  $fName - runner's first name
 *                 $lName - runner's last name
 *                 $thisRace - register this runner to this race
 ****************************************************************/
function buildRunnerRace($fName, $lName, $thisRace) {
   global $conn;
   
   // Populate Table:runner_race
   // Determine id_runner
   $sql = "SELECT id_runner FROM runner 
           WHERE fName='" . $fName 
           . "' AND lName='" . $lName . "'";
   $result = $conn->query($sql);
   $record = $result->fetch_assoc();
   $runnerID = $record['id_runner'];
   //echo '$thisRunner: ' . $thisRunner;
   
   // Determine id_race
   $sql = "SELECT id_race FROM race WHERE raceName='" . $thisRace . "'";
   $result = $conn->query($sql);
   $record = $result->fetch_assoc();
   $raceID = $record['id_race'];
   //echo ' -- $raceID: ' . $raceID . '<br />';
   

   
   // Check to make sure runner hasn't already registered for this race
   $sql = "SELECT id_race FROM runner_race 
     WHERE id_race = " . $raceID 
     . " AND id_runner = " . $runnerID;
   $result = $conn->query($sql);
   
   /* determine number of rows result set */
   $row_count = $result->num_rows;
   if($row_count > 0) {
      echo "Runner " . $runnerID
      . " has already registered for race " 
      . $thisRace . "<br />";
   } else { // Not a duplicate
      $sql = "INSERT INTO runner_race (id_runner, id_race, bibNumber, paid) 
         VALUES (" . $runnerID . ", " . $raceID . ", 1234, true)";
      runQuery($sql, "Insert " . $runnerID . " and " . $thisRace, false);
   } // end if($result)
   
} // end of buildRunnerRace( )


/********************************************
 * displayResult( ) - Execute a query and display the result
 *    Parameters:  $rs -  result set to display as 2D array
 *                 $sql - SQL string used to display an error msg
 ********************************************/
function displayResult($result, $sql) {
   if ($result->num_rows > 0) {
      echo "<table border='1'>\n";
      // print headings (field names)
      $heading = $result->fetch_assoc( );
      echo "<tr>\n";
      // print field names 
      foreach($heading as $key=>$value){
         echo "<th>" . $key . "</th>\n";
      }
      echo "</tr>\n";
      
      // Print values for the first row
      echo "<tr>\n";
      foreach($heading as $key=>$value){
         echo "<td>" . $value . "</td>\n";
      }
                 
       // output rest of the records
       while($row = $result->fetch_assoc()) {
           //print_r($row);
           //echo "<br />";
           echo "<tr>\n";
           // print data
           foreach($row as $key=>$value) {
              echo "<td>" . $value . "</td>\n";
           }
           echo "</tr>\n";
       }
       echo "</table>\n";
   } else {
       echo "<strong>zero results using SQL: </strong>" . $sql;
   }
} // end of displayResult( )



/********************************************
 * runQuery( ) - Execute a query and display message
 *    Parameters:  $sql         -  SQL String to be executed.
 *                 $msg         -  Text of message to display on success or error
 *     ___$msg___ successful.    Error when: __$msg_____ using SQL: ___$sql____.
 *                 $echoSuccess - boolean True=Display message on success
 ********************************************/
function runQuery($sql, $msg, $echoSuccess) {
   global $conn;
    
   // run the query
   if ($conn->query($sql) === TRUE) {
      if($echoSuccess) {
         echo $msg . " successful.<br />";
      }
   } else {
      echo "<strong>Error when: " . $msg . "</strong> using SQL: " . $sql . "<br />" . $conn->error;
   }   
} // end of runQuery( ) 
?>


</body>
</html>