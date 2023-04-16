<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tourism Site</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- dbfCreate.php - Creates new web tourism database and populates with data displaying log of the results.
        Note: Drops existing database if exists.
        Contributors:
            James West - westj4@csp.edu
            Dylan Johnson - johnsond47@csp.edu
        Course: CSC235 Server-Side Development
        Assignment: Group Project
        Date: 4/1/2023
        Last modified: 4/7/2023
    -->

    <?PHP
        include_once "dbFactory/DBFactory.php";
        include_once "dbTable/DestinationTable.php";
        include_once "dbTable/DestinationTagTable.php";
        include_once "dbTable/Table.php";
        include_once "dbTable/TagTable.php";
        include_once "dbTable/TagTypeTable.php";
        include_once "../../params.php";

        const DB_NAME = "travelMinnesota";
        $startData = json_decode(file_get_contents("starterData.json", true), true);
        $factory = DBFactory::createConnection(SERVER, USER, PASSWORD, NULL);
        $tables = [new DestinationTable(), new TagTypeTable(), new TagTable(), new DestinationTagTable()];
    ?>
</head>
<body>
    <h1>Travel Minnesota: Create Database</h1>
    <?PHP if($factory->databaseExists(DB_NAME)): ?>
    <p>
        Dropping database: <?=DB_NAME?> - <?= $factory->displayQuerySuccess($factory->dropDatabase(DB_NAME))?>
    </p>
    <?PHP endif;?>
    <p>
        Creating database: <?=DB_NAME?> - <?= $factory->displayQuerySuccess($factory->createDatabase(DB_NAME))?>
    </p>
    <?PHP $factory->getMysqli()->select_db(DB_NAME);?>
    <p>
        Creating tables:
    </p>
    <ul>
        <?PHP foreach($tables as $table): ?>
        <li>
            <?=$table->getName()?> - <?=$factory->displayQuerySuccess($table->addTable($factory->getMysqli()))?>
        </li>
        <?PHP endforeach; ?>
    </ul>
    <ul>
        <?PHP foreach($tables as $table): ?>
        <li>
            <?= $factory->displayQuerySuccess(Table::addEntries($factory->getMysqli(), $startData, $table))?>
        </li>
        <?PHP endforeach; ?>
        <?PHP $factory->getMysqli()->close(); ?>
    </ul>
</body>
</html>