import { router } from "@inertiajs/react";

export default function Welcome() {
  const links = [
    { href: "orders", label: "Order Details", method: "get" },
    { href: "orders?financial_status=PAID", label: "Paid Orders", method: "get" },
    { href: "orders?fulfillment_status=UNFULFILLED", label: "Pending Orders", method: "get" },
    { href: "orders?subtotal_price=300", label: "Orders ≥ 300", method: "get" },
    { href: "orders/items", label: "Order Items", method: "get" },
    {href:"/reports/custom",label:"Custom Reports",method:"get"},
    // { href: "reports/custom", label: "Custom Reports", method: "post" },
    {href:"/reports/orders",label:"Orders",method:"get"},
  ];

  const handleClick = (href: string, method: string) => {
    if (method === "post") {
      router.post(href, {}, { preserveScroll: true });
    } else {
      router.visit(href);
    }
  };

  return (
    <div className="min-h-screen flex items-center justify-center bg-gray-50 px-6">
      <div className="w-full max-w-2xl">
        <h1 className="text-2xl font-semibold text-gray-800 mb-6 text-center">
          Welcome to Your Orders Dashboard
        </h1>

        <div className="grid gap-4 sm:grid-cols-2">
          {links.map((link, index) => (
            <button
              key={index}
              onClick={() => handleClick(link.href, link.method)}
              className="rounded-xl border border-gray-200 bg-white p-6 text-center shadow-sm transition hover:shadow-md hover:border-gray-300"
            >
              <span className="text-base font-medium text-gray-700">
                {link.label}
              </span>
            </button>
          ))}
        </div>
      </div>
    </div>
  );
}
