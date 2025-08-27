<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class DatabaseHelper
{
    /**
     * Get all columns for the given tables.
     */
    public static function getTableColumns(array $tables): array
    {
        $columns = [];

        foreach ($tables as $table) {
            $tableCols = DB::select("
                SELECT COLUMN_NAME
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?
            ", [$table]);

            foreach ($tableCols as $col) {
                $columns[$table][] = $col->COLUMN_NAME;
            }
        }

        return $columns;
    }
}
