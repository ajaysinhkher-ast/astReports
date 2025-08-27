<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ReportTable;

class ReportTableColumn extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_table_id',
        'column_name',
        'data_type',
    ];

    /**
     * Each column belongs to one ReportTable.
     */
    public function table()
    {
        return $this->belongsTo(ReportTable::class, 'report_table_id');
    }
}
