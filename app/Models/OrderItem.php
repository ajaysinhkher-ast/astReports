<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $fillable = [
        'order_id',
        'product_name',
        'quantity',
        'price',
        'total_price',
        'total_discount',
        'taxable',
        'total_tax',
        'tax_rate',
        'tax_rate_percentage',
        'tax_source',
        'sku',
        'vendor',
        'variant_title',
        'require_shipping',
    ];

}
