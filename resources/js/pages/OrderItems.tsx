import React from "react";
import { AllCommunityModule, ModuleRegistry } from "ag-grid-community";
import { AgGridReact } from "ag-grid-react";
import { Head, Link, usePage } from '@inertiajs/react';
import { PageProps } from "@inertiajs/inertia";
// Register AG Grid modules
ModuleRegistry.registerModules([AllCommunityModule]);

interface orderItems {
  order_id: number;
  product_name: string;
  quantity: number;
  price: string;
  total_price: string;
  total_discount: string;
  taxable: boolean;
  total_tax: string;
  tax_rate: string;
  tax_rate_percentage: string;
  tax_source: string;
  sku: string;
  vendor: string;
  variant_title: string;
  require_shipping: boolean;
}

interface Props extends PageProps {
  orderItems: orderItems[];
}

const OrderItemsGrid: React.FC<Props> = ({ orderItems}) => {
  const colDefs: { field: keyof orderItems}[] = [
    { field: "order_id"},
    { field: "product_name"},
    { field: "quantity"},
    { field: "price" },
    { field: "total_price"},
    { field: "total_discount"},
    { field: "taxable"},
    { field: "total_tax" },
    { field: "tax_rate"},
    { field: "tax_rate_percentage"},
    { field: "tax_source"},
    { field: "sku"},
    { field: "vendor"},
    { field: "variant_title"},
    { field: "require_shipping"},
  ];

  return (
    <>
      <div className="m-5">
        <Link
          href="/"
          className="inline-block mb-4 px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700 transition"
        >
          &larr; Back to Home
        </Link>
      </div>
      <div className="ml-5 text-xl font-semibold mb-4">Order Items</div>
      <div
        className="ag-theme-alpine mx-5 my-5"
        style={{ height: 600, width: "calc(100% - 40px)" }}
      >
        <AgGridReact<orderItems>
          rowData={orderItems}
          columnDefs={colDefs}
          defaultColDef={{
            sortable: true,
            filter: true,
            resizable: true,
            width: 120,
            cellStyle: { borderRight: "1px solid #ccc", borderBottom: "1px solid #ccc" },
          }}
        />
      </div>
    </>
  );
};

export default OrderItemsGrid;
