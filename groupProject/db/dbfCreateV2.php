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
        use dbFactory\DBFactory;
        use dbfTable\DestinationTable;
        use dbfTable\TagTypeTable;
        use dbfTable\TagTable;
        use dbfTable\DestinationTagTable;

    const DB_NAME = "travelMinnesota";

        $factory = DBFactory::createConnection();
    ?>
</head>
<body>
    <h1>Travel Minnesota: Create Database</h1>
    <?PHP if($factory->databaseExists(DB_NAME)): ?>
    <p>
        Dropping database: <?=DB_NAME?> - <?=$factory->displayQueryResult($factory->dropDatabase(DB_NAME))?>
    </p>
    <?PHP endif;?>
    <p>
        Creating database: <?=DB_NAME?> - <?=$factory->displayQueryResult($factory->createDatabase(DB_NAME))?>
    </p>
    <p>
        Creating tables
    </p>
    <ul>
        <?PHP foreach([DestinationTable::class, TagTypeTable::class, TagTable::class, DestinationTagTable::class] as $table): ?>
        <li>
            <?=$table?> - <?=$factory->displayQueryResult([$table, "addTable"]($factory->getMysqli()))?>
        </li>
        <?PHP endforeach; ?>
    </ul>
</body>
</html>