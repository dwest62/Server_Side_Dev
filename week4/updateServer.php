<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tourism Site</title>
    <link rel="stylesheet" type="text/css" href="style.css">

	<!--
		File: updateServer.php - Pulls master branch from github and merges changes made to production branch
		Contributors: James West - westj4@csp.edu
		Course: CSC235 Server-Side Development
		Assignment: Individual Project - Week 4
		Date: 4/10/23
	-->

	<?php
		function deployChangesToProductionServer()
		{
			// Change directory to git directory
			chdir('../groupProject');
			
			// Checkout master branch
			runShellCommand('Switching to master', 'git checkout master 2>&1');

			// Pull updates from remote source (github)
			runShellCommand('Updating local master branch', 'git pull 2>&1');

			// Switch back to prod branch
			runShellCommand('Switching back to prod branch', 'git checkout prod 2>&1');

			// Merge change updates from master to prod
			$date = date();
			runShellCommand('Merging changes from master to prod', 'git merge master -m' . '"Push to prod -' . $date . '"');

			// Push updates to remote (github)
			runShellCommand('Updating remote prod branch', 'git push 2>&1');
		}

		function runShellCommand($msg, $commandString)
		{
			echo "<p>" . $msg . "<br/>";
			echo "<pre>" . shell_exec($commandString) . "</pre>";
			echo "</p>";
		}
	?>
</head>

<body>
	<h1>
		CSC 235 Group Project Management Admin
	</h1>
	<button onclick=">Deploy Git Chages to Production</button>
	<div>
	</div>
</body>
</html>
