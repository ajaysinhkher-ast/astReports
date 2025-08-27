<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Insert sample reports
        $reports = [
            [
                'id' => 1,
                'user_id' => 1,
                'name' => 'Sales Report',
                'category' => 'Sales',
                'view_count' => 10,
                'last_viewed_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'name' => 'Customer Report',
                'category' => 'Customers',
                'view_count' => 5,
                'last_viewed_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'user_id' => 2,
                'name' => 'Order Report',
                'category' => 'Orders',
                'view_count' => 0,
                'last_viewed_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('reports')->insert($reports);

        // Insert corresponding report settings
        $settings = [
            [
                'report_id' => 1,
                'selected_columns' => json_encode(['orders.id', 'orders.total_amount', 'orders.created_at']),
                'filters' => json_encode([
                    ['field' => 'orders.status', 'operator' => '=', 'value' => 'completed']
                ]),
                'sort' => json_encode([
                    ['field' => 'orders.created_at', 'direction' => 'desc']
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'report_id' => 2,
                'selected_columns' => json_encode(['customers.id', 'customers.name', 'customers.email']),
                'filters' => json_encode([
                    ['field' => 'customers.active', 'operator' => '=', 'value' => true]
                ]),
                'sort' => json_encode([
                    ['field' => 'customers.name', 'direction' => 'asc']
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'report_id' => 3,
                'selected_columns' => json_encode(['order_items.id', 'order_items.product_name', 'order_items.quantity']),
                'filters' => json_encode([]),
                'sort' => json_encode([]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('report_settings')->insert($settings);
    }
}
