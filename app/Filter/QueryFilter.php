<?php

namespace App\Filter;
use Illuminate\Http\Request;
class QueryFilter
{
   public static function apply($query,Request $request){
        if($request->filled('financial_status')){
            $query->where('financial_status',$request->input('financial_status'));
        }
        if($request->filled('min_amount')){
            $query->where('total_price','>=',$request->input('min_amount'));
        }
        return $query;
   }
}
