
<?php
    chdir('groupProject');
    
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
