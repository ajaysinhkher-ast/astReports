<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
     protected $fillable = [
        'shopify_order_id',
        'customer_id',
        'shipping_address_id',
        'billing_address_id',
        'phone',
        'email',
        'custom_attributes',
        'tags',
        'note',
    ];

     protected $casts = [
        'custom_attributes' => 'array',
        'tags' => 'array',
    ];
}
