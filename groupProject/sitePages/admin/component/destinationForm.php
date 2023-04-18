<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Administration Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">

    <?PHP
    // Global connection object
    $dbh = new DBHandler(SERVER, USER, PASSWORD, DB_NAME);
    $conn = $dbh->getConn();

    $destinationTable = new DestinationTable();

    $destination = (isset($_POST['lstDestination']) && !$_POST['lstDestination'] == "0")
        ? $destinationTable->getById($conn, (int) $_POST['lstDestination'])
        : new Destination();

    print_r($_POST);
    $feedback = "";
    if (isset($_POST['frmDestination']['btnSubmit'])) {
        $destination = new Destination(
            (int)$_POST['txtID'],
            $_POST['txtName'],
            $_POST['txtDescription'],
            $_POST['txtZip'],
            $_POST['txtLineOne'],
            $_POST['txtLineTwo'],
            $_POST['txtCity'],
            $_POST['txtImg'],
            $_POST['txtWebsite']
        );
        switch ($_POST['frmDestination']['btnSubmit']) {
            case "add":
                $feedback = $destinationTable->add($conn, $destination)
                    ? "<p class='success'>Successfully added new destination: {$_POST['txtName']} </p>"
                    : "<p class='failed'>{$destinationTable->getErrMsg($conn, $destination->getName())}</p>";
                break;
            case "update":
                $feedback = $destinationTable->update($conn, $destination)
                    ? "<p class='success'>Successfully updated destination: {$_POST['txtName']}</p>"
                    : "<p class='failed'>{$destinationTable->getErrMsg($conn, $destination->getName())}</p>";
                break;
            case "delete":
                $feedback = $destinationTable->delete($conn, $destination)
                    ? "<p class='success'>Successfully deleted destination: {$_POST['txtName']}"
                    : "<p class='failed'>{$destinationTable->getErrMsg($conn, $destination->getName())}</p>";
        }
    }

    $options = $destinationTable->getOptions($conn);

    ?>
</head>
<body>
<main>
    <?=$feedback?>
    <div id="frame">
        <form action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" name="tblEdit" id="tblEdit">
            <label for="lstDestination"><strong>Select Destination</strong></label>
            <select name="lstDestination" id="lstDestination" onChange="this.form.submit()">
                <option id="destination-0" value="0" >Select a name</option>
                <?PHP
                foreach ($options as $option)
                {
                    $selected = $destination->getId() == (int) $option['destination_id'] ? 'selected="true"' : '';
                    echo <<<EOF
                            <option value="{$option['destination_id']}" $selected >
                                {$option['destination_name']}
                            </option>
                        EOF;
                }
                ?>
            </select>
            <a href="<?=htmlentities($_SERVER['PHP_SELF'])?>" onclick="document.getElementById('destination-0').selected = true;">
                New Record
            </a>
            <fieldset>
                <legend>Destination Information</legend>
                <div class="topLabel">
                    <label for="txtName">Name</label>
                    <input type="text" name="txtName" id="txtName" value="<?= $destination->getName() ?>" />
                </div>

                <div class="topLabel">
                    <label for="txtImg">Image URL</label>
                    <input type="text" name="txtImg"   id="txtImg" value="<?= $destination->getImageUrl() ?>" />
                </div>

                <div class="topLabel">
                    <label for="txtWebsite">Website</label>
                    <input type="text" name="txtWebsite"   id="txtWebsite" value="<?= $destination->getWebsite() ?>" />
                </div>

                <div class="topLabel">
                    <label for="txtLineOne">Address Line 1</label>
                    <input type="text" name="txtLineOne"   id="txtLineOne" value="<?= $destination->getLine1() ?>" />
                </div>

                <div class="topLabel">
                    <label for="txtLineTwo">Address Line 2</label>
                    <input type="text" name="txtLineTwo"   id="txtLineTwo" value="<?= $destination->getLine2() ?>" />
                </div>

                <div class="topLabel">
                    <label for="txtCity">City</label>
                    <input type="text" name="txtCity"   id="txtCity" value="<?= $destination->getCity() ?>" />
                </div>

                <div class="topLabel">
                    <label for="txtZip">Zip Code</label>
                    <input type="text" name="txtZip"   id="txtZip" value="<?= $destination->getZip() ?>" />
                </div>

                <div class="topLabel">
                    <label for="txtDescription">Description</label>
                    <input type="text" name="txtDescription"   id="txtDescription"
                           value="<?= $destination->getDescription()?>" size="<?= $destination->getLen()?>"
                           maxlength="5000" />
                </div>
                <input type="hidden" name="txtID" id="txtID" value="<?= $destination->getId()?>">
            </fieldset>
            <button name="frmDestination[btnSubmit]"
                    value="delete"
                    style="float:left;"
                    onclick="this.form.submit();">
                Delete Record
            </button>

            <button name="frmDestination[btnSubmit]"
                    value="add"
                    style="float:right;"
                    onclick="this.form.submit();">
                Add New Destination
            </button>

            <button name="frmDestination[btnSubmit]"
                    value="update"
                    style="float:right;"
                    onclick="this.form.submit();">
                Update
            </button>
        </form>
    </div>
</main>
</body>
</html>