<!-- 
    admin.php - web interface for database 
    Student Name: Dylan Johnson, James West
    Written:  4/10/23
    Revised:  
-->


<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <title>Administration Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">

    <?PHP
<<<<<<< HEAD
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
=======
>>>>>>> origin/main
        // Set up connection constants
        // Using default username and password for AMPPS  
        require_once "../../dbf/dbfLib.php";
        require_once "../../../params.php";

            

        // Global connection object
        $conn = createConnection(SERVER, USER, PASSWORD);
<<<<<<< HEAD
        $conn->us
=======
>>>>>>> origin/main


        // Did the user select a runner from the list?
        // 'new' is the value of the first item on the runner list box 
<<<<<<< HEAD
//        if(isset($_POST['lstDestination']) && !($_POST['lstDestination'] == 'new')){
//            // Extract runner and sponsor information
//            $sql = "SELECT destination_id, destination_name
//                    FROM destination
//                    WHERE destination_id =" . $_POST['lstDestination'];
//            $result = $conn->query($sql);
//            $row = $result->fetch_assoc();
//        } // end if tableEdit
=======
        if(isset($_POST['lstDestination']) && !($_POST['lstDestination'] == 'new')){
            // Extract runner and sponsor information
            $sql = "SELECT destination_id, destination_name 
                    FROM destination
                    WHERE destination_id =" . $_POST['lstDestination'];
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
        } // end if tableEdit
>>>>>>> origin/main
        
        /*
        if(isset($_POST['lstRunner']) && !($_POST['lstRunner'] == 'new')){


        } // end if lstRunner

        // Determine which button may have been clicked
        switch($_POST['btnSubmit']) {

            // = = = = = = = = = = = = = = = = = = = 
            // DELETE Selected Destination
            // = = = = = = = = = = = = = = = = = = = 
            case 'delete':

                break;


            // = = = = = = = = = = = = = = = = = = = 
            // ADD NEW Destination
            // = = = = = = = = = = = = = = = = = = = 
            case 'new':
            
                break;

            // = = = = = = = = = = = = = = = = = = = 
            // UPDATE Existing Destionation
            // = = = = = = = = = = = = = = = = = = = 
            case 'update':
                
                break;

                            
        } // end of switch( )
        */

    ?>

    </head>
    <body>
        <div id="frame">
            <h1>Minnesota Destination CRUD</h1>

            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" name="tableEdit" id="tableEdit">
                <label for="lstDestination"><strong>Select Destination</strong></label>
<<<<<<< HEAD
                <select name="lstDestination" id="lstDestination" onChange="this.form.submit();">
                    <option value="new">Select a name</option>

=======

                <select name="lstDestination" id="lstDestination" onChange="this.form.submit();">
                    <option value="new">Select a name</option>
>>>>>>> origin/main
                    <?php
                        // Loop through the runner table to build the <option> list
                        $sql = "SELECT destination_id, destination_name
                                FROM destination ORDER BY destination_name";
                        $result = $conn->query($sql);
<<<<<<< HEAD
                        var_dump($result);

                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['destination_id'] . "'>" . $row['destination_name'] . "</option>";
=======
                        while($row = $result->fetch_assoc()) {   
                            echo "<option value='" . $row['destination_id'] . "'>" . $row['destination_name'] . "</option>\n";
>>>>>>> origin/main
                        }
                    ?>
                </select> 

                &nbsp;&nbsp;<a href="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">New</a>
                <br />

            </form>

            
            <br /><br />
            <h2>Update Information</h2>


        </div>
    </body>
</html>