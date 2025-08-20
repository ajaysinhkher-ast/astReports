<?php
namespace App\Services;
use App\Services\ShopifyOrderMapper;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShopifyService {

   public function fetchOrder($shop,$accessToken){
    $apiVersion = '2025-04';
    //prepare the endpoint  (buildEndPoint method)
    $endPoint=$this->buildEndPoint($shop,$apiVersion);
     //prepare build Graphql query  (buildQuery method )
    $query=$this->buildQuery();
    //start bulk opration   (startBulkOpration method)
    $operationId=$this->startBulkOperation($endPoint,$query,$accessToken);
    if($operationId){
        //start Polling for bulk Opration   (pollBulkOperation method)
        $url = $this->pollBulkOperation($endPoint, $accessToken);
        if ($url === 1) {
            // Handle the error condition here
            Log::error('Polling bulk operation failed or returned no URL.');
        } else {
             //start readtheurl (realFile method)
            $status=$this->readUrl($url);
             if($status==false){
                Log::error('file url not open');
             }else{
                 Log::info("this is count of order $status");
             }
        }


    }


      //insert object into db
   }

   public function buildEndPoint($shop,$apiVersion){
        return "https://{$shop}/admin/api/{$apiVersion}/graphql.json";
   }
   public function buildQuery(){
        return <<<'GRAPHQL'
        mutation {
          bulkOperationRunQuery(
            query: """
            {
              orders {
                edges {
                  node {
                    id
                    paymentGatewayNames
                    email
                    poNumber
                    presentmentCurrencyCode
                    customer {
                      id
                      amountSpent { amount currencyCode }
                      addresses {
                        address1 address2 city company country countryCodeV2
                        firstName lastName latitude longitude name  province provinceCode zip
                      }
                      displayName
                      numberOfOrders
                      defaultEmailAddress { emailAddress }
                      defaultPhoneNumber { phoneNumber }
                      lifetimeDuration
                      note
                      state
                      tags
                      createdAt
                      updatedAt
                      verifiedEmail
                    }
                    name
                    note
                    customAttributes { key value }
                    customerJourneySummary {
                      lastVisit {
                        referrerUrl landingPage landingPageHtml
                        referralCode source sourceDescription sourceType
                        utmParameters { campaign content medium source term }
                      }
                    }
                    billingAddress {
                      address1 address2 city company country countryCodeV2
                      firstName lastName phone province provinceCode timeZone zip
                    }
                    clientIp
                    customerAcceptsMarketing
                    cancelReason
                    currencyCode
                    discountCode
                    discountCodes
                    displayFinancialStatus
                    displayFulfillmentStatus
                    cancelledAt
                    shippingLine {
                      id title code
                      currentDiscountedPriceSet { presentmentMoney { amount currencyCode } shopMoney { amount currencyCode } }
                      discountedPriceSet { presentmentMoney { amount currencyCode } shopMoney { amount currencyCode } }
                      originalPriceSet { presentmentMoney { amount currencyCode } shopMoney { amount currencyCode } }
                      source shippingRateHandle
                    }
                    tags
                    taxLines {
                      channelLiable
                      priceSet { presentmentMoney { amount currencyCode } shopMoney { amount currencyCode } }
                      rate ratePercentage source title
                    }
                    taxesIncluded
                    totalWeight
                    subtotalLineItemsQuantity
                    currentSubtotalLineItemsQuantity
                    processedAt
                    closedAt
                    closed
                    subtotalPriceSet { presentmentMoney { amount currencyCode } shopMoney { amount currencyCode } }
                    totalPriceSet { presentmentMoney { amount currencyCode } shopMoney { amount currencyCode } }
                    totalDiscountsSet { presentmentMoney { amount currencyCode } shopMoney { amount currencyCode } }
                    totalTaxSet { presentmentMoney { amount currencyCode } shopMoney { amount currencyCode } }
                    totalShippingPriceSet { presentmentMoney { amount currencyCode } shopMoney { amount currencyCode } }
                    totalTipReceivedSet { presentmentMoney { amount currencyCode } shopMoney { amount currencyCode } }
                    paymentTerms {
                      dueInDays overdue paymentTermsName paymentTermsType translatedName
                    }
                    updatedAt
                    currentSubtotalPriceSet { presentmentMoney { amount currencyCode } shopMoney { amount currencyCode } }
                    currentTaxLines {
                      channelLiable
                      priceSet { presentmentMoney { amount currencyCode } shopMoney { amount currencyCode } }
                      rate ratePercentage source title
                    }
                    currentTotalDiscountsSet { presentmentMoney { amount currencyCode } shopMoney { amount currencyCode } }
                    currentTotalPriceSet { presentmentMoney { amount currencyCode } shopMoney { amount currencyCode } }
                    currentTotalTaxSet { presentmentMoney { amount currencyCode } shopMoney { amount currencyCode } }
                    currentTotalWeight
                    netPaymentSet { presentmentMoney { amount currencyCode } shopMoney { amount currencyCode } }
                    sourceIdentifier
                    sourceName
                    fulfillments {
                      id name status totalQuantity
                      trackingInfo { company number url }
                      createdAt deliveredAt updatedAt
                    }
                    lineItems {
                      edges {
                        node {
                          name
                          originalTotalSet{
                           presentmentMoney {
                              amount
                              currencyCode
                            }
                          }
                          originalUnitPriceSet{
                            presentmentMoney {
                              amount
                              currencyCode
                            }
                          }
                          quantity
                          requiresShipping
                          sku
                          taxable
                          taxLines{
                            priceSet{
                               presentmentMoney{
                                amount
                                 currencyCode
                               }
                            }
                            rate
                            ratePercentage
                            source
                            title
                          }
                          title
                          totalDiscountSet {
                            presentmentMoney {
                              amount
                              currencyCode
                            }
                          }
                          variantTitle
                          vendor
                        }
                      }
                    }
                  }
                }
              }
            }
            """
          ) {
            bulkOperation {
              id
              status
            }
            userErrors {
              field
              message
            }
          }
        }
        GRAPHQL;
   }
   public function startBulkOperation($endPoint,$query,$accessToken){
        $response = Http::withHeaders([
            'X-Shopify-Access-Token' => $accessToken,
            'Content-Type' => 'application/json',
        ])->withOptions([
            'verify' => false,
        ])->post($endPoint, ['query' => $query]);
        if ($response->failed()) {
            Log::info('Failed to start bulk operation: ' . $response->body());
            return 1;
        }
        $result = $response->json();

        if (isset($result['data']['bulkOperationRunQuery']['userErrors']) && !empty($result['data']['bulkOperationRunQuery']['userErrors'])) {
            Log::info('Bulk operation query errors: ' . json_encode($result['data']['bulkOperationRunQuery']['userErrors']));
            return 1;
        }
        $operationId = $result['data']['bulkOperationRunQuery']['bulkOperation']['id'] ?? null;
        return $operationId;
   }
   public function pollBulkOperation($endPoint,$accessToken){
        $statusQuery = <<<'GRAPHQL'
        query {
            currentBulkOperation {
                id
                type
                status
                url
                createdAt
                completedAt
                errorCode
                objectCount
                fileSize
                partialDataUrl
            }
        }
        GRAPHQL;
        while (true) {
            sleep(10);
            $statusResponse = Http::withHeaders([
                'X-Shopify-Access-Token' => $accessToken,
                'Content-Type' => 'application/json',
            ])->withOptions([
                'verify' => false,
            ])->post($endPoint, ['query' => $statusQuery]);
            if ($statusResponse->failed()) {
                Log::info('Failed to check operation status: ' . $statusResponse->body());
                return 1;
            }
            $statusResult = $statusResponse->json();
            $status = $statusResult['data']['currentBulkOperation']['status'] ?? 'RUNNINGNEW';
            $url = $statusResult['data']['currentBulkOperation']['url'] ?? null;
            $errorCode = $statusResult['data']['currentBulkOperation']['errorCode'] ?? null;
            Log::info("Current status: {$status}");
            if ($status === 'COMPLETED') {
                Log::info("Bulk operation completed. Processing directly from URL: {$url}");
                break;
            }
            if (in_array($status, ['FAILED', 'CANCELED', 'EXPIRED'])) {
                Log::info("Bulk operation failed with status: {$status}");
                if ($errorCode) {
                    Log::info("Error Code: {$errorCode}");
                }
                if (isset($statusResult['errors'])) {
                    Log::info('Errors: ' . json_encode($statusResult['errors']));
                }
                return 1;
            }
        }
        if (!$url){
            Log::info('No URL for bulk operation result.');
            return 1;
        }
        return $url;
   }
   public function readUrl($url){
        $handle = @fopen($url, 'r');
        if ($handle === false) {
            return false;
        }
        $currentOrderId = null;
        $orderObject = null;
        $orderCount = 0;
        while (!feof($handle)) {
            $line = fgets($handle);
            if ($line === false || trim($line) === '') {
                continue;
            }
            $obj = json_decode($line, true);
            $orderId = $obj['id'] ?? null;
            $parentId = $obj['__parentId'] ?? null;
            if (!$parentId) {
                if ($currentOrderId !== null && $orderObject !== null) {
                    $this->insertOrderObjectIntoDB($orderObject);
                    $orderCount++;
                }
                // Start a new order
                $currentOrderId = $orderId;
                $orderObject = $obj;
                $orderObject['line_items'] = [];
            } else {
                // Add line item to the current order
                if ($parentId === $currentOrderId && $orderObject !== null) {
                    $orderObject['line_items'][] = $obj;
                }
            }
        }
        if ($orderObject !== null) {
            $this->insertOrderObjectIntoDB($orderObject);
            $orderCount++;
        }
        fclose($handle);

        return  $orderCount;
   }
   protected function insertOrderObjectIntoDB($shopifyOrder): void{
        $store_id = Auth::id();
        DB::transaction(function () use ($shopifyOrder, $store_id) {
            $orderData = ShopifyOrderMapper::mapOrder($shopifyOrder, $store_id);
            $order = Order::create($orderData);
            $orderItems = ShopifyOrderMapper::mapOrderItems($shopifyOrder['line_items'] ?? [], $order->id);
            OrderItem::insert($orderItems);
        });
    }


}