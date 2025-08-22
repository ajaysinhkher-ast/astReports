import React from "react";
import { AllCommunityModule, ModuleRegistry } from "ag-grid-community";
import { AgGridReact } from "ag-grid-react";
import { PageProps } from "@inertiajs/inertia";

// Register AG Grid modules
ModuleRegistry.registerModules([AllCommunityModule]);

// Define your Order interface
interface Order {
  id: number;
  user_id: number;
  name:string;
  email: string;
  customer_id: number;
  fulfillment_status: string;
  financial_status: string;
  subtotal_price: string;
  total_price: string;
  total_taxes: string;
  total_weight: string;
  total_shipping_price: string;
  total_discount: string;
  cancelled_at: string | null;
  cancel_reason: string | null;
  currency: string;
  payment_method: string;
  created_at: string;
  updated_at: string;
  deleted_at: string | null;
}

interface Props extends PageProps {
  orders: Order[];
}

const Orders: React.FC<Props> = ({ orders }) => {

      console.log("Incoming orders:", orders);
      console.log(Array.isArray(orders), orders);

  const colDefs: { field: keyof Order; headerName?: string }[] = [
    { field: "id" },
    { field: "user_id", headerName: "User ID" },
    { field: "name", headerName: "Name" },
    { field: "email" , headerName: "Email" },
    { field: "customer_id", headerName: "Customer ID" },
    { field: "fulfillment_status" , headerName: "Fulfillment Status" },
    { field: "financial_status" , headerName: "Financial Status" },
    { field: "subtotal_price", headerName: "Subtotal Price" },
    { field: "total_price", headerName: "Total Price" },
    { field: "total_taxes", headerName: "Total Taxes" },
    { field: "total_weight", headerName: "Total Weight" },
    { field: "total_shipping_price", headerName: "Total Shipping Price" },
    { field: "total_discount", headerName: "Total Discount" },
    { field: "cancelled_at", headerName: "Cancelled At" },
    { field: "cancel_reason", headerName: "Cancel Reason" },
    { field: "currency", headerName: "Currency" },
    { field: "payment_method", headerName: "Payment Method" },
    { field: "created_at", headerName: "Created At" },
    { field: "updated_at", headerName: "Updated At" },
    { field: "deleted_at", headerName: "Deleted At"},
  ];

  return (
    <>
    <div style={{padding:'20px'}}>Order details</div>
    <div className="ag-theme-alpine" style={{ height: 600, width: '100%', padding: '20px'}}>
      <AgGridReact<Order>
        rowData={orders}
        columnDefs={colDefs}
        defaultColDef={{
          sortable: true,
          filter: true,
          resizable: true,
          width:100,
          cellStyle: { borderRight: "1px solid #ccc", borderBottom: "1px solid #ccc" }
        }}
      />
    </div>
    </>
  );
};

export default Orders;
