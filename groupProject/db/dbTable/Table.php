<?php
abstract class Table
{
    abstract public static function addTable(mysqli $conn): bool;
    abstract public function getName(): string;
    public static function addEntry(mysqli $conn, array $entry, Table $table): bool
    {
        $cols = join(", ", array_keys($entry));

        foreach ($entry as $key => $value)
        {
            if(gettype($value) == "string") {
                $entry[$key] = "'$value'";
            }
        }
        $values = join(",", array_values($entry));
        $sql = <<<SQL
            INSERT INTO {$table->getName()}($cols) VALUES ($values)
        SQL;

        return $conn->query($sql);
    }
    public static function addEntries(mysqli $conn, array $entries, Table $table): bool
    {
        $tableEntries = $entries[$table->getName()];
        foreach ($tableEntries as $entry)
        {
            $result = Table::addEntry($conn, $entry, $table);
            if(!$result) { return false; }
        }
        return true;
    }
}
