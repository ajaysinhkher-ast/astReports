<?php

namespace App\Http\Controllers;
use App\Helpers\DatabaseHelper;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\ReportTable;

class CustomReportController extends Controller
{
    public function index()
    {

        $allColumns = DatabaseHelper::getTableColumns(['orders', 'order_items','users']);
        // dd($allColumns);

        // $data = Order::all();
        // dd($ordercolumns);
        // dd($allColumns);

        return Inertia::render('CustomReport', [
           'allColumns' => $allColumns,
        //    'data'=>$data,
        ]);
    }

    public function customReports(Request $request)
    {
        // Columns sent from frontend
        $allColumns = $request->input('allColumns');
        $selected = $request->input('allselectedColumns');

        // dd($allColumns);
        // dd($selected);


        $flatallColumns = [];
        foreach ($allColumns as $table => $cols) {
            foreach ($cols as $col) {
                $flatallColumns[] = $table . '.' . $col;
            }
        }
        // dd($flatallColumns);

        // $allowed = array_merge($orderColumns, $orderItemColumns);

        // Keep only safe columns
        $selectedColumns = array_intersect($selected, $flatallColumns);
        // dd($selectedColumns);

        // Fallback to at least one column
        if (empty($selectedColumns)) {
            $selectedColumns = ['orders.id'];
        }


        $query = DB::table('users')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->select($selectedColumns)
            ->limit(20);

        $data = $query->get();
        // dd($data);

        return Inertia::render('CustomReport', [
            'data' => $data,
            'selectedColumns' => $selectedColumns,
            'allColumns' => $allColumns,
        ]);
    }

    public function orderReports()
    {
        // get the table data from report_tables
        $reportTable = DB::table('report_tables')
            ->where('table_name', 'orders')
            ->first();
        // dd($reportTable);


        // get the columns reletd to the table fetched
        $columns  = DB::table('report_table_columns')
            ->where('report_table_id', $reportTable->id)
            ->get();

        // dd($columns);

        // get the row data from the table
         $data = DB::table('orders')
            ->select(array_column($columns->toArray(), 'column_name'))
            ->limit(20)
            ->get();


        $allColumns = ReportTable::with('columns')->get();
        // foreach ($allColumns as $table) {
        //         dump("Table: " . $table->name);

        //     foreach ($table->columns as $col) {
        //             dump(" - " . $col->name);
        //     }
        // }

        return Inertia::render('Orders', [
            'columns'=>$columns,
            'data' => $data,
        ]);
    }

}



// array:3 [▼ // app\Http\Controllers\CustomReportController.php:37
//   0 => "orders.user_id"
//   1 => "orders.customer_id"
//   2 => "order_items.total_discount"
// ]
