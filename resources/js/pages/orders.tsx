// import React from "react";
// import { AllCommunityModule, ModuleRegistry } from "ag-grid-community";
// import { AgGridReact } from "ag-grid-react";

// // Register AG Grid modules
// ModuleRegistry.registerModules([AllCommunityModule]);

// const OrdersGrid = ({ orders }) => {
//     // Column Definitions: Defines the columns to be displayed.
//     const colDefs = [
//         { field: "id" },
//         { field: "user_id" },
//         { field: "email" },
//         { field: "customer_id" },
//         { field: "fulfillment_status" },
//         { field: "financial_status" },
//         { field: "subtotal_price" },
//         { field: "total_price" },
//         { field: "total_taxes" },
//         { field: "total_weight" },
//         { field: "total_shipping_price" },
//         { field: "total_discount" },
//         { field: "cancelled_at" },
//         { field: "cancel_reason" },
//         { field: "currency" },
//         { field: "payment_method" },
//         { field: "created_at" },
//         { field: "updated_at" },
//         { field: "deleted_at" },
//     ];

//     console.log("Orders Data:");
//     return (
//         <div className="ag-theme-alpine" style={{ height: 600, width: "100%" }}>
//             <AgGridReact
//                 rowData={orders}
//                 columnDefs={colDefs}
//                 defaultColDef={{
//                 sortable: true,
//                 filter: true,
//                 resizable: true,
//                 }}
//             />
//         </div>
//     );
// };

// export default OrdersGrid;



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

const OrdersGrid: React.FC<Props> = ({ orders }) => {

  const colDefs: { field: keyof Order }[] = [
    { field: "id" },
    { field: "user_id" },
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
    { field: "created_at" },
    { field: "updated_at" },
    { field: "deleted_at" },
  ];

  return (
    <div className="ag-theme-alpine" style={{ height: 600, width: "100%" }}>
      <AgGridReact<Order>
        rowData={orders}
        columnDefs={colDefs}
        defaultColDef={{
          sortable: true,
          filter: true,
          resizable: true,


        }}
      />
    </div>
  );
};

export default OrdersGrid;






