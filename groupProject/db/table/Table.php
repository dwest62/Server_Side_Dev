<?php

namespace dbfTable;

use mysqli;

interface Table
{
    public static function addTable(mysqli $conn): bool|\mysqli_result;
}