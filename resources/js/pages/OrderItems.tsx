import { PageProps } from '@inertiajs/inertia';
import { AllCommunityModule, ModuleRegistry } from 'ag-grid-community';
import { AgGridReact } from 'ag-grid-react';
import React from 'react';

// Register AG Grid modules
ModuleRegistry.registerModules([AllCommunityModule]);

// Define your Order interface
interface OrderItems {
    id: number;
    order_id: number;
    product_name: string;
    price: number;
    total_price: number;
    total_discount: number;
    taxable: boolean;
    total_tax: number;
    tax_rate: number;
    tax_rate_percentage: number;
    tax_source: string | null;
    sku: string | null;
    vendor: string | null;
    variant_title: string | null;
    require_shipping: boolean;
    created_at: string;
    updated_at: string;
    deleted_at: string | null;
}

interface Props extends PageProps {
    orderItems: OrderItems[];
}

const OrdersItemsGrid: React.FC<Props> = ({ orderItems }) => {
    console.log('Incoming orders:', orderItems);

    const colDefs: { field: keyof OrderItems; headerName?: string }[] = [
        { field: 'id',headerName: 'ID' },
        { field: 'order_id', headerName: 'Order ID' },
        { field: 'product_name', headerName: 'Product Name' },
        { field: 'price', headerName: 'Price' },
        { field: 'total_price', headerName: 'Total Price' },
        { field: 'total_discount', headerName: 'Total Discount' },
        { field: 'taxable', headerName: 'Taxable' },
        { field: 'total_tax', headerName: 'Total Tax' },
        { field: 'tax_rate', headerName: 'Tax Rate' },
        { field: 'tax_rate_percentage', headerName: 'Tax Rate Percentage' },
        { field: 'tax_source', headerName: 'Tax Source' },
        { field: 'sku', headerName: 'SKU' },
        { field: 'vendor' , headerName: 'Vendor' },
        { field: 'variant_title', headerName: 'Variant Title' },
        { field: 'require_shipping', headerName: 'Require Shipping' },
        { field: 'created_at', headerName: 'Created At' },
        { field: 'updated_at', headerName: 'Updated At' },
        { field: 'deleted_at', headerName: 'Deleted At' },

    ];

    return (
        <>
            <div style={{padding:'20px'}}>OrderItem details</div>
            <div
                className="ag-theme-alpine"
                style={{ height: 600, width: '100%', padding: '20px'}}
            >
                <AgGridReact<OrderItems>
                    rowData={orderItems}
                    columnDefs={colDefs}
                    defaultColDef={{
                        sortable: true,
                        filter: true,
                        resizable: true,
                        width: 100,
                        cellStyle: { borderRight: '1px solid #ccc', borderBottom: '1px solid #ccc' },
                    }}
                />
            </div>
        </>
    );
};

export default OrdersItemsGrid;
