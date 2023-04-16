<?php

interface DBHandler
{
    function getQueryResultString(mysqli_result $result, ?string $msg);
}