<?php
	/**
     *  File: proofOfConcept.php - Updates production code from master to prod using git. Echos result.
     *  Contributors: James West - westj4@csp.edu
     *  Course: CSC235 Server-Side Development
     *  Assignment: Individual Project - Week 4
     *  Date: 4/10/23
    */

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

	function runShellCommand($msg, $commandString)
	{
		echo "<p>" . $msg . "<br/>";
		echo "<pre>" . shell_exec($commandString) . "</pre>";
		echo "</p>";
	}
?>
