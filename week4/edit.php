<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="style.css">

	<!--
		File: edit.php - Presentation page
		Contributors: James West - westj4@csp.edu
		Course: CSC235 Server-Side Development
		Assignment: Individual Project - Week 4
		Date: 4/10/23
	-->
</head>

<body>
    <h1>CSC 235 Group Project Admin</h1>
    <button onClick="deploy()">Deploy Changes to Server</button>
    <p id="results"></p>
</body>

<script>
    async function deploy() {
        const response = await fetch("/updateServer.php");
        document.getElementById("results").innerHTML = response.text();
        console.log(response);
    }
</script>

</html>