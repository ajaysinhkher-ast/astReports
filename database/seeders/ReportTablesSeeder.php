<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportTablesSeeder extends Seeder
{
    public function run(): void
    {
        // Insert base tables
        $tables = [
            ['name' => 'Orders', 'table_name' => 'orders'],
            ['name' => 'Order Items', 'table_name' => 'order_items'],
        ];

        DB::table('report_tables')->insert($tables);

        // Fetch inserted tables with IDs
        $reportTables = DB::table('report_tables')->pluck('id', 'table_name');

        // Insert columns for each table
        $columns = [
            // Orders
            [
                'report_table_id' => $reportTables['orders'],
                'table_name'=>'orders',
                'name' => 'Order ID',

            ],
            [
                'report_table_id' => $reportTables['orders'],
                'table_name'=>'orders',
                'name' => 'Order Date',

            ],
            [
                'report_table_id' => $reportTables['orders'],
                'table_name'=>'orders',
                'name' => 'Total Price',

            ],

            // Order Items
            [
                'report_table_id' => $reportTables['order_items'],
                'table_name'=>'order_items',
                'name' => 'Item ID',

            ],
            [
                'report_table_id' => $reportTables['order_items'],
                'table_name'=>'order_items',
                'name' => 'Order ID',

            ],
            [
                'report_table_id' => $reportTables['order_items'],
                'table_name'=>'order_items',
                'name' => 'Quantity',
         
            ],

        ];

        DB::table('report_table_columns')->insert($columns);
    }
}
