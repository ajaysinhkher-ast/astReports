import React from "react";
import { AllCommunityModule, ModuleRegistry } from "ag-grid-community";
import { AgGridReact } from "ag-grid-react";
import { PageProps } from "@inertiajs/inertia";
import { Head, Link, usePage } from '@inertiajs/react';
// Register AG Grid modules
ModuleRegistry.registerModules([AllCommunityModule]);
// Define your Order interface
interface Order {
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
}
interface Props extends PageProps {
  orders: Order[];
}
const OrdersGrid: React.FC<Props> = ({ orders }) => {
      console.log("Incoming orders:", orders);
  const colDefs: { field: keyof Order }[] = [
    { field: "email" },
    { field: "customer_id" },
    { field: "fulfillment_status" },
    { field: "financial_status" },
    { field: "subtotal_price" },
    { field: "total_price" },
    { field: "total_taxes" },
    { field: "total_weight" },
    { field: "total_shipping_price" },
    { field: "total_discount" },
    { field: "cancelled_at" },
    { field: "cancel_reason" },
    { field: "currency" },
    { field: "payment_method" },
  ];
  return (
    <>
    <div style={{padding:'20px'}}>Order details</div>
    <Link
    href="/"
    className="inline-block mb-4 px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700 transition"
    >
    &larr; Back to Home
    </Link>
    <div className="ag-theme-alpine" style={{ height: 600, width: "100%" ,marginLeft: '20px', marginRight: '20px', marginTop: '20px', marginBottom: '20px'}}>
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
export default OrdersGrid;