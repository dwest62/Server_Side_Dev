<?php
interface Table
{
    public static function addTableToDatabase(mysqli $conn): bool;
}
