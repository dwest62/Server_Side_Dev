<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Sun Run Create</title>

    <?PHP
    /**
     * sunRunCreate.php - Create Sun Run Registration Database. Modeled after code written by Peter K. Johnson for The Learning House.
     * Author: James West - westj4@csp.edu
     * Class: CSC 235 Server Side Development
     * Assignment: Project 4
     * Date: 4/12/2023
     */

    use sunRunTable\RunnerTable;
    use sunRunTable\RaceTable;
    use sunRunTable\SponsorTable;
    use sunRunTable\RunnerRaceTable;

    // Name of database to create
    const DB_NAME = "sunrun";

    // Establish database connection. Use php ini arguments unless otherwise specified.
    $conn = DBFactory::connect();

    // Drop DB if exists and create new database
    if (!DBFactory::databaseExists(DB_NAME, $conn)): DBFactory::dropDatabase(DB_NAME, $conn); endif;
    DBFactory::createDatabase(DB_NAME, $conn);

    RunnerTable::addTableToDatabase($conn);
    RaceTable::addTableToDatabase($conn);
    SponsorTable::addTableToDatabase($conn);
    RunnerRaceTable::addTableToDatabase($conn);

    ?>
</head>
<body>
   <main>
       <?php if(!DBFactory::databaseExists(DB_NAME, $conn)): ?>
       <p><?= DB_NAME?> exists.</p>
       <?php endif ?>

       <p>
           Dropping database -
                <?= DBFactory::dropDatabase(DB_NAME, $conn) ? "Success" : "Failed with error: $conn->error"?>
       </p>


   </main>
</body>
</html>