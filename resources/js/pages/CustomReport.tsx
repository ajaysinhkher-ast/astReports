// resources/js/Pages/CustomReport.tsx
import React, { useEffect, useState } from "react";
import { Head } from "@inertiajs/react";
import {Link} from '@inertiajs/react';
import {
  AllCommunityModule,
  ColDef,
  ModuleRegistry,
  PaginationModule,
} from "ag-grid-community";
import { AgGridReact } from "ag-grid-react";
import { router } from '@inertiajs/react';


// Import AG Grid styles
// import "ag-grid-community/styles/ag-grid.css";
// import "ag-grid-community/styles/ag-theme-alpine.css";

// Register AG Grid modules
ModuleRegistry.registerModules([AllCommunityModule, PaginationModule]);

// expecting a object here key->value pair of table->columns[]
interface Props {
  allColumns: {
    [table: string]: string[];
  };
  data?: any[]; // row data from backend
  selectedColumns?: string[]; // selected columns from backend
}



const CustomReport: React.FC<Props> = ({ allColumns, data = [] , selectedColumns=[]}) => {
  const [selectedCols, setSelectedCols] = useState<string[]>(selectedColumns);


  // update the state
  useEffect(() => {
    setSelectedCols(selectedColumns);
  }, [selectedColumns]);

  console.log("data passed ",data);
  // Build colDefs dynamically from selectedCols
  const colDefs: ColDef[] = selectedCols.map((fullName) => {
    const [table, col] = fullName.split(".");
    // need to change this name
    return {
      field: col,
      headerName: `${table}.${col}`,
      filter: "agTextColumnFilter",
      sortable: true,
      resizable: true,
    };
  });

 const handleToggle = (table: string, col: string) => {
  const fullName = `${table}.${col}`;

  const newSelected = selectedCols.includes(fullName)
    ? selectedCols.filter((c) => c !== fullName)
    : [...selectedCols, fullName];

  // Now newSelected has the value after toggle
  router.post('/reports/custom', {
    allColumns,
    allselectedColumns: newSelected,
  });

};

  return (
    <>
    <div>
    <Link href="/" className="text-blue-500 underline">Back to Home</Link>
    </div>
      <Head title="Custom Report" />
      <div className="flex h-screen">
        {/* Left - Grid */}
        <div className="flex-1 p-4 border-r">
          <div className="flex items-center justify-between mb-4">
            <div className="text-lg font-semibold">Custom Report</div>
            <div className="space-x-2">
              <button className="px-3 py-1 bg-gray-100 rounded">Filters</button>
              <button className="px-3 py-1 bg-gray-100 rounded">Sort</button>
              <button className="px-3 py-1 bg-gray-100 rounded">Export</button>
              <button className="px-3 py-1 bg-gray-100 rounded">Save</button>
            </div>
          </div>

          <div className="ag-theme-alpine" style={{ height: "85%", width: "100%" }}>
            <AgGridReact
              rowData={data}
              columnDefs={colDefs}
              defaultColDef={{
                sortable: true,
                filter: true,
                floatingFilter: true,
                resizable: true,
                width: 140,
                cellStyle: { borderRight: '1px solid #ccc', borderBottom: '1px solid #ccc' },
              }}
              pagination={true}
              paginationPageSize={10}
            />
          </div>
        </div>

        {/* Right - Column Selector */}
        <div className="w-80 p-4 overflow-y-auto">
          <div className="text-lg font-semibold mb-3">Available Fields</div>
          {Object.entries(allColumns).map(([table, cols]) => (
            <div key={table} className="mb-4">
              <div className="font-medium text-gray-600 mb-2">{table}</div>
              <div className="space-y-1">
                {cols.map((col) => {
                    const colName = col.includes('.') ? col.split('.')[1] : col;
                    // console.log(colName);
                    const fullName = `${table}.${colName}`;
                  return (
                    <label
                      key={col}
                      className="flex items-center space-x-2 text-sm"
                    >
                      <input
                        type="checkbox"
                        checked={selectedCols.includes(fullName)}
                        onChange={() => handleToggle(table, colName)}
                      />
                      <span>{col}</span>
                    </label>
                  );
                })}
              </div>
            </div>
          ))}
        </div>
      </div>
    </>
  );
};

export default CustomReport;
