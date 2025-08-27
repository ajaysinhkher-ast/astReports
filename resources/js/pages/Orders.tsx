import React, { useState } from "react";
import { Link, router } from "@inertiajs/react";
import { AgGridReact } from "ag-grid-react";
import {
  QueryBuilder,
  formatQuery,
  type Field,
  type RuleGroupType,
} from "react-querybuilder";
import "react-querybuilder/dist/query-builder.css";

import { AllCommunityModule, PaginationModule, ModuleRegistry, ColDef } from "ag-grid-community";
ModuleRegistry.registerModules([AllCommunityModule, PaginationModule]);

interface Order {
  id: number;
  user_id: number;
  name: string;
  email: string;
  customer_id: number;
  fulfillment_status: string;
  financial_status: string;
  subtotal_price: string;
  total_price: string;
  created_at: string;
}

interface Props {
  orders: Order[];
}

const fields: Field[] = [
  { name: "financial_status", label: "Financial Status" },
  { name: "fulfillment_status", label: "Fulfillment Status" },
  { name: "subtotal_price", label: "Subtotal Price" },
  { name: "total_price", label: "Total Price" },
  { name: "created_at", label: "Created At", type: "date" },
  { name: "customer_id", label: "Customer ID", type: "number" },
  { name: "email", label: "Email", type: "string" },
  { name: "name", label: "Name", type: "string" },
  { name: "user_id", label: "User ID", type: "number" },
  { name: "id", label: "Order ID", type: "number" },

];

const initialQuery: RuleGroupType = {
  combinator: "and",
  rules: [],
};

const Orders: React.FC<Props> = ({ orders }) => {
  const [query, setQuery] = useState(initialQuery);

  const runReport = () => {
  router.get("/orders/filter", { query: JSON.stringify(query) });
  };

  const colDefs: ColDef<Order>[] = [
    { field: "id" },
    { field: "user_id", headerName: "User ID" },
    { field: "name" },
    { field: "email" },
    { field: "customer_id", headerName: "Customer ID" },
    { field: "fulfillment_status" },
    { field: "financial_status" },
    { field: "subtotal_price" },
    { field: "total_price" },
    { field: "created_at" },
  ];

  return (
    <>
      <div>
        <Link href="/">Go back</Link>
      </div>

      <h2>Order Report</h2>

      {/* QueryBuilder UI */}
      <QueryBuilder fields={fields} query={query} onQueryChange={setQuery}
       controlClassnames={{
        addRule: "px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-200",
        addGroup: "px-2 py-1 bg-green-500 text-white rounded hover:bg-green-200",
        removeGroup: "px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600",
      }}/>

      <button onClick={runReport} className="btn btn-primary">
        Apply Filters
      </button>

      {/* Grid */}
      <div className="ag-theme-alpine" style={{ height: 500, width: "100%", marginTop: "20px" }}>
        <AgGridReact<Order>
          rowData={orders}
          columnDefs={colDefs}
          defaultColDef={{
            sortable: true,
            filter: true,
            floatingFilter: true,
            resizable: true,
            width: 140,
          }}
          pagination={true}
          paginationPageSize={10}
        />
      </div>
    </>
  );
};

export default Orders;
