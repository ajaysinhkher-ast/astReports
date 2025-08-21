<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use App\Services\ShopifyOrderMapper;
use Illuminate\Support\Facades\Auth;

class FetchOrders extends Command
{
    protected $signature = 'shopify:fetch-orders {shop} {accessToken}';
    protected $description = 'Fetch all orders from Shopify using GraphQL Admin API bulk operation';
    public function handle()
    {
      $apiVersion = '2025-04';
      $shop  = $this->argument('shop');
      $accessToken = $this->argument('accessToken');
    //   $storeId = $this->argument('storeId');
        $storeId = DB::connection('singlestore')
        ->table('users')
        ->where('name', $shop)
        ->value('id');

        // dd($storeId);
        if (!$storeId) {
        $this->error("No store found for domain: {$shopDomain}");
        return 1;
        }

      $endpoint = "https://{$shop}/admin/api/{$apiVersion}/graphql.json";
      $query = <<<'GRAPHQL'
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
      $response = Http::withHeaders([
          'X-Shopify-Access-Token' => $accessToken,
          'Content-Type' => 'application/json',
      ])->withOptions([
          'verify' => false,
      ])->post($endpoint, ['query' => $query]);
    //   dd($response->json());
      if ($response->failed()) {
          $this->error('Failed to start bulk operation: ' . $response->body());
          return 1;
      }

      $result = $response->json();
      if (isset($result['data']['bulkOperationRunQuery']['userErrors']) && !empty($result['data']['bulkOperationRunQuery']['userErrors'])) {
          $this->error('Bulk operation query errors: ' . json_encode($result['data']['bulkOperationRunQuery']['userErrors']));
          return 1;
      }
      $operationId = $result['data']['bulkOperationRunQuery']['bulkOperation']['id'] ?? null;
      if (!$operationId) {
          $this->error('Failed to retrieve operation ID.');
          return 1;
      }
      $this->info("Bulk operation started: {$operationId}");
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
          ])->post($endpoint, ['query' => $statusQuery]);

        //   dd($statusResponse);
          if ($statusResponse->failed()) {
              $this->error('Failed to check operation status: ' . $statusResponse->body());
              return 1;
          }
          $statusResult = $statusResponse->json();
        //   dd($statusResult);
          $status = $statusResult['data']['currentBulkOperation']['status'] ?? 'RUNNINGNEW';

          $url = $statusResult['data']['currentBulkOperation']['url'] ?? null;
          $errorCode = $statusResult['data']['currentBulkOperation']['errorCode'] ?? null;
          $this->info("Current status: {$status}");
          if ($status === 'COMPLETED') {
              $this->info("Bulk operation completed. Processing directly from URL: {$url}");
              break;
          }
          if (in_array($status, ['FAILED', 'CANCELED', 'EXPIRED'])) {
              $this->error("Bulk operation failed with status: {$status}");
              if ($errorCode) {
                  $this->error("Error Code: {$errorCode}");
              }
              if (isset($statusResult['errors'])) {
                  $this->error('Errors: ' . json_encode($statusResult['errors']));
              }
              return 1;
          }
      }
      if (!$url){
          $this->error('No URL for bulk operation result.');
          return 1;
      }

        $handle = @fopen($url, 'r');
        if ($handle === false) {
            $error = error_get_last();
            throw new \Exception('Failed to open file: ' . $error['message']);
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
                    $this->insertOrderObjectIntoDB($orderObject,$storeId);
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
            $this->insertOrderObjectIntoDB($orderObject,$storeId);
            $orderCount++;
        }
        fclose($handle);
        Log::info("Processed $orderCount orders.");
        return 0;
}



   protected function insertOrderObjectIntoDB($shopifyOrder,$storeId): void
    {
      Log::info(json_encode($shopifyOrder, JSON_PRETTY_PRINT));//array to json convert

      $order = new Order();
      $order->user_id = $storeId ?? null;
      $order->email = $shopifyOrder['email']?? null;
      $order->fulfillment_status = $shopifyOrder['displayFulfillmentStatus']?? null;
      $order->financial_status = $shopifyOrder['displayFinancialStatus']?? null;
      $order->subtotal_price = $shopifyOrder['subtotalPriceSet']['presentmentMoney']['amount']?? null;
      $order->total_price = $shopifyOrder['totalPriceSet']['presentmentMoney']['amount']?? null;
      $order->total_taxes = $shopifyOrder['totalTaxSet']['presentmentMoney']['amount']?? null;
      $order->total_weight = $shopifyOrder['totalWeight']?? null;
      $order->total_shipping_price = $shopifyOrder['totalShippingPriceSet']['presentmentMoney']['amount']?? null;
      $order->total_discount = $shopifyOrder['line_items']['totalDiscountSet']['presentmentMoney']['amount']??0;
      $order->cancelled_at = $shopifyOrder['cancelledAt']?? null;
      $order->cancel_reason = $shopifyOrder['cancelReason']?? null;
      $order->currency = $shopifyOrder['presentmentCurrencyCode']?? null;
      $order->payment_method = $shopifyOrder['paymentGatewayNames'][0]?? null;


      $order->save();
    //   dd($order);
    }


}
