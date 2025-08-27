<?php

namespace App\Filter;
use Illuminate\Http\Request;
class QueryFilter
{
   public static function apply($query,Request $request){
        if($request->filled('financial_status')){
            $query->where('financial_status',$request->input('financial_status'));
        }

        if($request->filled('fulfillment_status')){
            $query->where('fulfillment_status',$request->input('fulfillment_status'));
        }

        if($request->filled('subtotal_price')){

            $query->where('subtotal_price','>=',$request->input('subtotal_price'));
        }

        return $query;
   }
}

