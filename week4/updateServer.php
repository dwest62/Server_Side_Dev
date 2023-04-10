<?php
	/**
     *  File: proofOfConcept.php - Updates production code from master to prod using git. Echos result.
     *  Contributors: James West - westj4@csp.edu
     *  Course: CSC235 Server-Side Development
     *  Assignment: Individual Project - Week 4
     *  Date: 4/10/23
    */

	$postData = file_get_contents("php://input");
	echo "t";

	// if($postData == false) 
	// {
	// 	echo "There was an error with this request";
	// } 
	// else 
	// {
	// 	$postData = json_decode($postData);
	// 	deploy($postData['msg']);
	// }

	// function deploy($msg)
	// {
	// 	chdir('../groupProject');
	// 	$result = "";
		
	// 	// Checkout master branch
	// 	$result .= runShellCommand('Switching to master', 'git checkout master 2>&1');

	// 	// Pull updates from remote source (github)
	// 	$result .= runShellCommand('Updating local master branch', 'git pull 2>&1');

	// 	// Switch back to prod branch
	// 	$result .= runShellCommand('Switching back to prod branch', 'git checkout prod 2>&1');

	// 	// Merge change updates from master to prod
	// 	$result .= runShellCommand('Merging changes from master to prod', 'git merge master -m Merged');

	// 	// Push updates to remote (github)
	// 	$result .= runShellCommand('Updating remote prod branch', 'git push 2>&1');

	// 	function runShellCommand($msg, $commandString)
	// 	{
	// 		return "<p>" . $msg . "<br/><pre>" . shell_exec($commandString) . "</pre></p>";
	// 	}

	// 	echo $result;
	// }
?>
