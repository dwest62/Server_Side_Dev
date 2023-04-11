<?php
	/**
     *  File: updateServer.php - Updates production code from master to prod using git. Echos result.
     *  Contributors: James West - westj4@csp.edu
     *  Course: CSC235 Server-Side Development
     *  Assignment: Individual Project - Week 4
     *  Date: 4/10/23 
    */


	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	// Get post input
	$postData = file_get_contents("php://input");

	// If no post data, redirect to home page.
	if(!$postData)
	{
		header("Location: http://34.233.186.220/serverSideDev/week4/index.php");
	}
	else 
	{
		$postData = json_decode($postData);
		deploy($postData->msg);
	}

	// Deploy to prod branch on server
	function deploy($commitMsg)
	{
		chdir('../groupProject');
		$result = "";
		
		// Checkout master branch
		$result .= runShellCommand('Switching to master', 'git checkout master 2>&1');

		// Pull updates from remote source (GitHub)
		$result .= runShellCommand('Updating local master branch', 'git pull 2>&1');

		// Switch back to prod branch
		$result .= runShellCommand('Switching back to prod branch', 'git checkout prod 2>&1');

		// Merge change updates from master to prod
		$result .= runShellCommand('Merging changes from master to prod', 'git merge master -X theirs -m "' . $commitMsg . '" 2>&1');

		// Push updates to remote (GitHub)
		$result .= runShellCommand('Updating remote prod branch', 'sudo git push 2>&1');

		echo $result;
	}

	// Run command and return resulting message
	function runShellCommand($message, $commandString): string
	{
		return "<p>" . $message . "<br/><pre>" . shell_exec($commandString) . "</pre></p>";
	}

