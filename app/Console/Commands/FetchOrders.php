<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
class FetchOrders extends Command
{
    protected $signature = 'shopify:fetch-orders {shop} {accessToken}';
    protected $description = 'Fetch all orders from Shopify using GraphQL Admin API bulk operation';
    public function handle()
    {

      $apiVersion = '2025-04';


      $shop  = $this->argument('shop');
      $accessToken = $this->argument('accessToken');

     //   dd($shop,$accessToken, config('shopify-app.api_scopes'));

      $endpoint = "https://{$shop}/admin/api/{$apiVersion}/graphql.json";
    //   dd($endpoint);
      $query = <<<'GRAPHQL'
      mutation {
        bulkOperationRunQuery(
          query: """
          {
            orders {
              edges {
                node {
                  id
                  email
                  phone
                  paymentGatewayNames
                  poNumber
                  presentmentCurrencyCode
                  name
                  note
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
    //   dd($result);
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
          if ($status === 'COMPLETED' && $url) {
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
            //   if($partialDataUrl){
            //      $this->info("partialDataUrl:$partialDataUrl");
            //   }
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
              throw new Exception('Failed to open file: ' . $error['message']);
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

        // dd($order);
        fclose($handle);

        // if($orderObject['name']=='#1002')
        // {

        //     dd($orderObject);
        // }

        Log::info("Processed $orderCount orders.");
        return 0;
}


// helper function to get numeric id from the id string :
protected function extractShopifyId($gid)
{
    if (!$gid) return null;

    // Updated regex to match ID before optional query string
    if (preg_match('/\/(\d+)(?:\?|$)/', $gid, $matches)) {
        return (int) $matches[1];
    }

    return null;
}

protected function insertOrderObjectIntoDB($order): void
    {
        // Example: Save order to database or process it
        // Log::info("Processing order: " . json_encode($order));

        // $order = Order::create([
        // 'customer_id' => $this->extractShopifyId($order['customer']['id'] ?? null),
        // 'shipping_address_id' => $this->extractShopifyId($order['shippingAddress']['id'] ?? null),
        // 'billing_address_id' => $this->extractShopifyId($order['billingAddress']['id'] ?? null),
        // 'phone'                => $order['phone'] ?? '',
        // 'email'                => $order['email'] ?? '',
        // 'custom_attributes'    => $order['customAttributes'] ?? [],
        // 'tags'                 => $order['tags'] ?? [],
        // 'note'                 => $order['note'] ?? null,
        // ]);

        // $this->info("order placed in db !");
        // Log::info("order added:", $order->toArray());
    }


}

// $order = Order::where('customer_id', 11607517626735)->first();
// dd($order);

