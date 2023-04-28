<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--
        priceEdit.php - Contains forms enabling the editing of product data for classic programming books.
        James West - westj4@csp.edu
        Written: 04/24/2023
    -->
    <title>Classic Programming Books</title>
    <!-- Begin Javascript -->
    <script>
        const FILE_NAME = "priceData.json";
        // Display function fetches JSON data from file. On success, it populates the form and user view.
        const display = () => {
            // Open new get request of content-type json
            let thisRequest = new XMLHttpRequest();
            thisRequest.open("GET", FILE_NAME, true);
            thisRequest.setRequestHeader("Content-type", "application/json");

            // Set function to be run when request state is changed
            thisRequest.onreadystatechange = () => {
                // If request is successful, update DOM
                if (thisRequest.readyState === 4 && thisRequest.status === 200) {
                    console.log("h");
                    let res = thisRequest.responseText;
                    updateBooks(JSON.parse(res));
                    updateForm(JSON.parse(res));
                }
            }
            // Send request
            thisRequest.send(null);
        }

        // Loops through the book data JSON object and populates the user view.
        const updateBooks = (data) => {
            document.getElementById("books").innerHTML = data.map(book =>
                `<div class='book'>
                    <h2>${book.title}</h2>
                    <p>${book.authors}</p>
                    <blockquote>"${book.quote}"</blockquote>
                    <p>$${book.price.toFixed(2)}</p>
                    <p>${book.stock} in stock</p>
                </div>`
            ).join('');
        }

        // Loops through the book data JSON object and populates the form table.
        const updateForm = (data) => {
            document.getElementById("frmBooksEdit").innerHTML =
                `<form action="priceEdit.php" method="POST">
                    <table>
                        <caption>Edit Books Form</caption>
                        <tr><th>Title</th><th>Author</th><th>Quote</th><th>Price</th><th>Stock</th>
                        ${data.map((book, i) =>
                            `<tr>
                                <td><input type="text" name="txtTitle${i}" value="${book.title}"</td>
                                <td><input type="text" name="txtAuthors${i}" value="${book.authors}"</td>
                                <td><input type="text" name="txtQuote${i}" value="${book.quote}"</td>
                                <td><input type="text" name="txtPrice${i}" value="${book.price}"</td>
                                <td><input type="text" name="txtStock${i}" value="${book.stock}"</td>
                            </tr>
                            `
                        ).join('')}
                    </table>
                    <input type='hidden' name='isReturning' value='returning' />
                    <input type='submit' value='submit' />
                </form>`;
        }
    </script>

    <?PHP
    // Name of json file
    const FILE_NAME = "priceData.json";

    // If isReturning, process form updates
    if(array_key_exists('isReturning',$_POST)) {
        // Get JSON data from file
        $thisData = read(FILE_NAME);

        // Loop through JSON data and set each entry to match corresponding values from POST
        for($i=0; $i<count($thisData); $i++) {
            $thisData[$i]['title'] = $_POST["txtTitle$i"];
            $thisData[$i]['author'] = $_POST["txtAuthors$i"];
            $thisData[$i]['quote'] = $_POST["txtQuote$i"];
            $thisData[$i]['price'] = (float) $_POST["txtPrice$i"];
            $thisData[$i]['stock'] = (int) $_POST["txtStock$i"];
        }

        // Update the JSON file with new values
        write(FILE_NAME, $thisData);

    }


    /**
     * Attempts to read JSON data from file
     * @param string $fileName - the JSON file path
     * @return array - decoded array containing JSON contents
     */
    function read(string $fileName): array
    {
        try {
            return json_decode(file_get_contents($fileName), true);
        } catch (Exception $e) {
            echo "Caught exception: {$e->getMessage()}\n";
            return [];
        }
    }


    /**
     * Attempts to convert data to JSON and write data to file
     * @param string $fileName - JSON file which will be populated with parsed array data
     * @param array $data
     * @return void
     */
    function write(string $fileName, array $data): void
    {
        try {
            if (file_put_contents($fileName, json_encode($data), JSON_PRETTY_PRINT)) {
//                echo "Update successful<br/>";
            } else {
                echo "There was an error writing to the file: $fileName";
            }
        } catch (Exception $e) {
            echo "Caught exception: {$e->getMessage()}\n";
        }
    }

    ?>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<header><h1>Classic Programming Books</h1></header>
<main>
    <div id="frmBooksEdit"></div>
    <h1>User View</h1>
    <div id="books"></div>
    <h1>AJAX</h1>
    <h3>What is AJAX? What does it do? What are its advantages?</h3>
    <p>
        AJAX is shorthand for Asynchronous JavaScript and XML, however, it is better described as a set of web
        development techniques implemented on the client-side to send and fetch data asynchronously. By using AJAX, a
        programmer can build highly responsive applications to scale as communication with the server occurs in the
        background. Rather than the entire page needing to be reloaded with each POST, Asynchronous Javascript can be
        used as an intermediary, enabling separation the presentation layer from the data transfer layer.
    </p>
    <h3>How can PHP be used to create JSON data from a database?</h3>
    <p>
        First, the needed data would be fetched from the database and stored in an array. The JSON format meshes well with
        PHP arrays, whether associative, index, or multidimensional. Once the data from the database is fetched and processed
        into an array, it can be encoded in JSON format to be used.
    </p>
    <img src="graphic/ajaxFlowChart.jpg" />
</main>
<script>
    display();
</script>
</body>
</html>