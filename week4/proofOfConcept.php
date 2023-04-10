<?php
	/**
     *  File: proofOfConcept.php - Provides proof of concept for updating production code from url request using php and git
     *  Contributors: James West - westj4@csp.edu
     *  Course: CSC235 Server-Side Development
     *  Assignment: Individual Project - Week 4
     *  Date: 4/10/23
    */

    // Change directory
    chdir('../groupProject');
    /**
     * Note: shell_exec has standard output and standard err. 2>&1 pipes standard err to standard output if it occurs. 
     * Source: https://stackoverflow.com/questions/31268096/what-does-21-do-in-this-php-snippet
    */
    $output = shell_exec('git checkout master 2>&1');
    echo "$output<br/>";
    $output = shell_exec('git pull 2>&1');
    echo "$output<br/>";
    $output = shell_exec('git checkout prod 2>&1');
    echo "$output<br/>";
    $output = shell_exec('git merge master -m "merged" 2>&1');
    echo "$output<br/>";
    $output = shell_exec('git push 2>&1');
    echo "$output<br/>";
?>