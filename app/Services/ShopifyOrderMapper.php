<?php
namespace App\Services;
use Illuminate\Support\Facades\Log;
class ShopifyOrderMapper
{

    public static function mapOrder(array $shopifyOrder,int $store_id): array
    {
        return [
            'store_id'=>$store_id,
            'customer_id'=>0,
            'name'=>$shopifyOrder['name'] ?? 'order name is not available',
            'fulfillment_status' => $shopifyOrder['displayFulfillmentStatus'] ?? null,
            'financial_status' => $shopifyOrder['displayFinancialStatus'] ?? null,
            'subtotal_price' => $shopifyOrder['subtotalPriceSet']['presentmentMoney']['amount'] ?? null,
            'total_price' => $shopifyOrder['totalPriceSet']['presentmentMoney']['amount'] ?? null,
            'total_taxes' => $shopifyOrder['totalTaxSet']['presentmentMoney']['amount'] ?? null,
            'total_weight' => $shopifyOrder['totalWeight'] ?? null,
            'total_shipping_price'=> $shopifyOrder['totalShippingPriceSet']['presentmentMoney']['amount'] ?? null,
            'email' => $shopifyOrder['email'] ?? null,
            'currency' => $shopifyOrder['presentmentCurrencyCode'] ?? null,
            'payment_method' => $shopifyOrder['paymentGatewayNames'][0] ?? null,
            'cancle_at'=>$shopifyOrder['cancelledAt']??null,
            'cancel_reason'=>$shopifyOrder['cancelReason']??null,
            'email'=>$shopifyOrder['email']??null,
            'phone_number'=>$shopifyOrder['phone']??null,
        ];
    }
    public static function mapOrderItems(array $shopifyOrderItems,int $order_id):array
    {

        $orderItems=[];

        foreach ($shopifyOrderItems as $orderItem){
          $taxLine = $orderItem['taxLines'][0] ?? [];
          $item=[
             'order_id'=>$order_id ?? null,
              'product_name'=>$orderItem['name']??null,
              'quantity'=>$orderItem['quantity']??0,
              'price'=>$orderItem['originalUnitPriceSet']['presentmentMoney']['amount']??0,
              'total_price'=>$orderItem['originalTotalSet']['presentmentMoney']['amount']??0,
              'total_discount'=>$orderItem['totalDiscountSet']['presentmentMoney']['amount']??0,
              'taxable'=>$orderItem['taxable']??'false',
              'total_tax'=>$orderItem['taxLines'][0]['priceSet']['presentmentMoney']['amount']??0,
              'tax_rate'=>$orderItem['taxLines'][0]['rate']??0,
              'tax_rate_percentage'=>$orderItem['taxLines'][0]['ratePercentage']??0,
              'tax_source'=>$orderItem['taxLines'][0]['source']??null,
               'sku'=>$orderItem['sku']??null,
               'vendor'=>$orderItem['vendor']??null,
               'variant_title'=>$orderItem['variantTitle']??null,
               'require_shipping'=>$orderItem['requiresShipping']??null,

          ];
           $orderItems[]=$item;
        }
        return $orderItems;
    }

}
