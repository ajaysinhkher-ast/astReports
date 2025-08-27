<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ReportTableColumn;

class ReportTable extends Model
{
    protected $fillable = [
        'name',
        'table_name',
    ];

    public function columns()
    {
        return $this->hasMany(ReportTableColumn::class);
    }
}
