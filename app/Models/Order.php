<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Table name (optional if following Laravel convention)
    protected $table = 'orders';

    // All fillable fields for mass assignment
    protected $fillable = [
        'store_id',
        'customer_id',
        'name',
        'fulfillment_status',
        'financial_status',
        'subtotal_price',
        'total_price',
        'total_taxes',
        'total_weight',
        'total_shipping_price',
        'email',
        'currency',
        'payment_method',
        'cancle_at',
        'cancel_reason',
        'phone_number',
    ];


    // Cast 'is_cancelled' to boolean and decimals properly
    protected $casts = [
        // 'is_cancelled' => 'boolean',
        // 'subtotal' => 'decimal:2',
        // 'total' => 'decimal:2',
        // 'taxes' => 'decimal:2',
        // 'weight' => 'decimal:3',
    ];

    // (Optional) Define relationship with order_items
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
}
