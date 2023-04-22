<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- registration.php - Register new racers - edit, delete
      James West
      Written:  4/22/23
      Revised: 4/22/23
      Source: Modeled from Concordia St. Paul University - CSC 235 Server-Side Development Lesson 6 Module
      -->
    <title>SunRun Registration</title>
    <link rel="stylesheet" type="text/css" href="registration.css">
    <!DOCTYPE html>

    <?PHP
    // Set up connection constants
    // Using default username and password for AMPPS
    define("SERVER_NAME", "localhost");
    define("DBF_USER_NAME", "root");
    define("DBF_PASSWORD", "mysql");
    define("DATABASE_NAME", "sunRun");
    // Global connection object
    $conn = new mysqli(SERVER_NAME, DBF_USER_NAME, DBF_PASSWORD, DATABASE_NAME);

    require_once(getcwd() . "/sunRunLib.php");
    // Connect to database
    createConnection();
    $thisRunner = [
        "id_runner" => "new",
        "fName" => "",
        "lName" => "",
        "phone" => "",
        "gender" => "",
        "sponsor" => ""
    ];
    // Is this a return visit?
    if (array_key_exists('hidIsReturning', $_POST)) {
        //echo '<h1>Welcome BACK</h1>';
        echo "<hr /><strong>\$_POST: </strong>";
        print_r($_POST);

        // Did the user select a runner from the list?
        // 'new' is the value of the first item on the runner list box
        if (isset($_POST['lstRunner']) && !($_POST['lstRunner'] == 'new')) {
            // Extract runner and sponsor information
            $sql = "SELECT runner.id_runner, fName, lName, phone, gender, sponsorName 
               FROM runner 
               LEFT OUTER JOIN sponsor ON runner.id_runner = sponsor.id_runner 
               WHERE runner.id_runner =" . $_POST['lstRunner'];
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            // Create an associative array mirroring the record in the HTML table
            // This will be used to populate the text boxes with the current runner info
            $thisRunner = [
                "id_runner" => $row['id_runner'],
                "fName" => $row['fName'],
                "lName" => $row['lName'],
                "phone" => $row['phone'],
                "gender" => $row['gender'],
                "sponsor" => $row['sponsorName']
            ];
            $thisRunnerStr = print_r($thisRunner, true);
            displayMessage("\$thisRunner Array: $thisRunnerStr ", "green");
        } // end if lstRunner        // Determine which button may have been clicked

        if (isset($_POST['btnSubmit'])) {
            switch ($_POST['btnSubmit']) {
                // = = = = = = = = = = = = = = = = = = =
                // DELETE
                // = = = = = = = = = = = = = = = = = = =
                case 'delete':

                    //Make sure a runner has been selected.
                    if ($_POST["txtFName"] == "") {
                        displayMessage("Please select a runner's name.", "red");
                    } else {
                        $sql = "DELETE FROM runner WHERE id_runner = " . $thisRunner["id_runner"];
                        $result = $conn->query($sql);


                        // Remove any records in Table:sponsor
//                        $sql = "DELETE FROM sponsor WHERE id_runner = " . $thisRunner["id_runner"];
//                        $result = $conn->query($sql);

                        $sql = <<<SQL
                            DELETE FROM sponsor WHERE id_runner = ?;
                        SQL;
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $thisRunner['id_runner']);
                        $result = $stmt->execute();
                        if ($result) {
                            displayMessage($thisRunner['fName'] . " " . $thisRunner['lName'] . " deleted.", "green");
                        }
                        $stmt->close();
                    } // end of if($_POST[txtFName])
                    clearThisRunner();
                    break;
                // = = = = = = = = = = = = = = = = = = =
                // ADD NEW RUNNER
                // = = = = = = = = = = = = = = = = = = =
                case 'new':
                    // displayMessage("ADD button pushed.", "green");
                    $unfrmtPhone = unFormatPhone($_POST['txtPhone']);
                    $sql = <<<SQL
                                SELECT COUNT(*) AS total FROM runner
                                WHERE fName = '{$_POST['txtFName']}'
                                AND lName = '{$_POST['txtLName']}'
                                AND phone = $unfrmtPhone
                            SQL;
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();

                    if ($row['total'] > 0) {
                        displayMessage('This runner is already registered', 'red');
                    } else {
                        // Check for empty name fields or phone
                        if ($_POST['txtFName'] == "" || $_POST['txtLName'] == "" || $_POST['txtPhone'] == "") {
                            displayMessage("Please type in a first and last name and a phone number.", "red");
                        } // First name and last name are populated
                        else {
                            $sql = "INSERT INTO runner (id_runner, fName, lName, phone, gender)
                            VALUES (NULL, '"
                                . $_POST['txtFName'] . "', '"
                                . $_POST['txtLName'] . "', '"
                                . unformatPhone($_POST['txtPhone']) . "', '"
                                . $_POST['lstGender'] . "')";
                            $result = $conn->query($sql);

                            // My preferred way
                            $sql = <<<SQL
                                INSERT INTO sponsor (id_sponsor, sponsorName, id_runner)
                                VALUES (NULL, ?,
                                    (SELECT id_runner FROM runner WHERE fName = ? AND lName = ?)
                                )
                            SQL;

                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("sss", $_POST['txtSponsor'], $_POST['txtFName'], $_POST['txtLName']);
                            $result = $stmt->execute();
                            $stmt->close();

                            // What you were maybe looking for?
//                            $stmt1 = $conn->prepare("SELECT id_runner FROM runner WHERE fName = ? AND lName = ?");
//                            $stmt1->bind_param("ss", $_POST['txtFName'], $_POST['txtLName']);
//                            $stmt1->execute();
//                            $stmt1->store_result();
//                            $stmt1->bind_result($tempId);
//                            $stmt1->fetch();
//                            $stmt1->free_result();
//                            $stmt1->close();
//                            $sql = <<<SQL
//                                INSERT INTO sponsor (id_sponsor, sponsorName, id_runner)
//                                VALUES (NULL, ?, ?)
//                            SQL;
//
//                            $stmt2 = $conn->prepare($sql);
//                            $stmt2->bind_param("si", $_Post['txtSponsor'], $tempId);
//                            $stmt2->execute();
//                            $stmt2->close();
                        }
                    }
                    clearThisRunner();
                    break;

// = = = = = = = = = = = = = = = = = = =
// UPDATE
// = = = = = = = = = = = = = = = = = = =
                case 'update':
                    //displayMessage("UPDATE button pushed.", "green");
                    // Check for empty name
                    if ($_POST['txtFName'] == "" || $_POST['txtLName'] == "") {
                        displayMessage("Please select a runner's name.", "red");
                    } // First name and last name are selected
                    else {
                        $isSuccessful = false;
                        // Update Table:runner

//                        $sql = "UPDATE runner SET fName='" . $_POST['txtFName'] . "', "
//                            . " lName = '" . $_POST['txtLName'] . "', "
//                            . " phone = '" . unformatPhone($_POST['txtPhone']) . "', "
//                            . " gender = '" . $_POST['lstGender'] . "'
//                            WHERE id_runner = " . $thisRunner['id_runner'];

                        $conn->close();
                        createConnection();
                        $ufPhone = unFormatPhone($_POST['txtPhone']);
                        $sql = "CALL runnerUpdate(?,?,?,?,?)";
                        $stmt = $conn->prepare($sql);

                        $stmt->bind_param(
                            "issss",
                            $thisRunner['id_runner'],
                            $_POST['txtFName'],
                            $_POST['txtLName'],
                            $_POST['lstGender'],
                            $ufPhone
                        );
                        $result = $stmt->execute();
                        $stmt->close();

                        $conn->close();
                        createConnection();


                        $result = $conn->query($sql);
                        if ($result) {
                            $isSuccessful = true;
                        }
                        // Update Table:sponsor
                        // !!!! Does not update sponsor unless an entry already exists in the table !!!!
                        $sql = "UPDATE sponsor SET sponsorName='" . $_POST['txtSponsor'] . "' WHERE id_runner = " . $thisRunner['id_runner'];
                        $result = $conn->query($sql);
                        if (!$result) {
                            $isSuccessful = false;
                        }
                        // If successful update the variables
                        if ($isSuccessful) {
                            displayMessage("Update successful!", "green");
                            $thisRunner['id_runner'] = $_POST['lstRunner'];
                            $thisRunner['fName'] = $_POST['txtFName'];
                            $thisRunner['lName'] = $_POST['txtLName'];
                            $thisRunner['phone'] = unformatPhone($_POST['txtPhone']);
                            $thisRunner['gender'] = $_POST['lstGender'];
                            $thisRunner['sponsor'] = $_POST['txtSponsor'];

                            // Save array as a serialized session variable
                            $_SESSION['sessionThisRunner'] = urlencode(serialize($thisRunner));
                        }
                    }
                    // Zero out the current selected runner
                    clearThisRunner();
                    break;

            } // end of switch( )
        }

    }
    ?>

</head>
<body>
<div id="frame">
    <h1>SunRun Registration</h1>

    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"
          method="POST"
          name="frmRegistration"
          id="frmRegistration">

        <label for="lstRunner"><strong>Select Runner's Name</strong></label>

        <select name="lstRunner" id="lstRunner" onChange="this.form.submit();">
            <option value="new">Select a name</option>
            <?PHP
            // Loop through the runner table to build the <option> list
            $sql = "SELECT id_runner, CONCAT(fName,' ',lName) AS 'name' 
           FROM runner ORDER BY lName";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id_runner'] . "'>" . $row['name'] . "</option>\n";
            }
            ?>
        </select>
        &nbsp;&nbsp;<a href="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">New</a>
        <br/>
        <br/>

        <fieldset>
            <legend>Runner's Information</legend>

            <div class="topLabel">
                <label for="txtFName">First Name</label>
                <input type="text" name="txtFName" id="txtFName" value="<?php echo $thisRunner['fName']; ?>"/>

            </div>

            <div class="topLabel">
                <label for="txtLName">Last Name</label>
                <input type="text" name="txtLName" id="txtLName" value="<?php echo $thisRunner['lName']; ?>"/>
            </div>

            <div class="topLabel">
                <label for="txtPhone">Phone</label>
                <input type="text" name="txtPhone" id="txtPhone"
                       value="<?php echo formatPhone($thisRunner['phone']); ?>"/>
            </div>

            <div class="topLabel">
                <label for="lstGender">Gender</label>
                <select name="lstGender" id="lstGender">
                    <option value="female">Female</option>
                    <option value="male">Male</option>
                </select>
            </div>

            <div class="topLabel">
                <label for="txtSponsor">Sponsor</label>
                <input type="text" name="txtSponsor" id="txtSponsor" value="<?php echo $thisRunner['sponsor']; ?>"/>
            </div>
        </fieldset>

        <br/>
        <button name="btnSubmit"
                value="delete"
                style="float:left;"
                onclick="this.form.submit();">
            Delete
        </button>

        <button name="btnSubmit"
                value="new"
                style="float:right;"
                onclick="this.form.submit();">
            Add New Runner Information
        </button>

        <button name="btnSubmit"
                value="update"
                style="float:right;"
                onclick="this.form.submit();">
            Update
        </button>
        <br/>
        <!-- Use a hidden field to tell server if return visitor -->
        <input type="hidden" name="hidIsReturning" value="true"/>
    </form>
    <br/><br/>
    <h2>Registered Runners</h2>

    <?PHP
    displayRunnerTable();
    echo "<br />";
    ?>
    <script>

        // Update the values of the list boxes based on the current selection
        document.getElementById("lstRunner").value = "<?PHP echo $thisRunner['id_runner']; ?>";
        document.getElementById("lstGender").value = "<?PHP echo $thisRunner['gender']; ?>";
    </script>

    <h1>Prepared Statements as a defense against SQL Injection</h1>
    <h2>What is SQL injection?</h2>
    <p>SQL injection is a technique used by hackers to attempt to execute their own SQL commands by "injecting" them into
        user inputs. For example, consider a query which uses a username password combination to locate a particular user id:

        <hr/><br/>SELECT user_id FROM users WHERE uname=$uname AND passcode=$pass;<br/><hr/><br/>

        Additionally, consider $uname and $passcode as containing raw user input passed through a POST call. A hacker could
        enter a username that they didn't know (say "paul" the password to and for the password field enter 1 OR "1"="1".
        They query above would then evaluate to:

        <hr/><br/>SELECT user_id FROM users WHERE uname="paul" AND passcode=1 OR "1"="1";<br/><hr/><br/>

        Here, the "injected" sql is the "1"="1" which would allow the user to bypass the uname and passcode check.
    </p>

    <h2>How do prepared statements defend against SQL Injection?</h2>
    <p>A prepared statement is technique used to create a parameterized query. First a template is sent to the DBMS
    (such as mysql). The DBMS parses the statement and prepares it for execution. At this point, the parameter values
    in the statement are unknown, but the DBMS is ready to execute the query. Finally, the values for the parameters are
    provided to the DBMS which executes the query using these parameters. Prepared statements have several advantages. One
    advantage is that the DBMS can compile and optimize the statement which can increase performance if multiple calls to
     the statement are made.</p>
    <p>Another advantage is that prepared statements involve the separation of executable code from parameterized data.
    This makes them a great defense against SQL injection, which relies on data being falsely recognized as sql code.</p>

    <h1>Control of user input</h1>
    <h2>Controlling for embedded HTML and javascript</h2>
    <p>To control for text input involving HTML using php, one can use the built-in php functions strip_tags() or html_entities().
        The function strip_tags(), for example, takes two arguments: a string to be parsed, and optionally, allowable tags.
        It returns a new string consisting of all the characters in the old minus any html tags not specified in the second
        parameter.</p>
    <p>The function html_entities() takes in 4 arguments: the string to be parsed, optional flags which provide an array
        of customization to the function (e.g., ENT_NOQUOTES - a constant represented a flag that prompts the function to
        leave single and double quotation marks alone), an optional encoding string, which defines what encode scheme (e.g.,
         ISO-8859-1) is to be used to encode the html, and a bool which specifies whether the existing html entities will
         be encoded.
    </p>
    <p>
        The function strip_tags() is useful when a developer would like to remove html tags from a string, whereas the
        function html_entities() is useful when a developer would like to encode the html tags instead.
    </p>
</div>

</body>
</html>