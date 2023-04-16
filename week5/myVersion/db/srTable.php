<?php
interface srTable
{
    public static function addTableToDatabase(mysqli $conn): bool;
}
