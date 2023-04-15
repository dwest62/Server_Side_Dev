<?php

use dbFactory\DBFactory;

class SunRunDBFactory extends DBFactory
{
    public static function addTables(mysqli $conn): bool
    {
        return false;
    }
}