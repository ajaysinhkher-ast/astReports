import { Link } from '@inertiajs/react';

export default function Welcome() {
    return (
        <>
            <div className="mx-auto flex min-h-screen w-full flex-col items-center justify-center space-y-4 bg-gray-100 p-6">
                <input
                    type="text"
                    placeholder="Search..."
                    className="w-full rounded-md border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                />

                <div className="w-full">
                    <Link
                        href="orders"
                        className="block w-full rounded-md border border-gray-500 bg-gray-200 py-1 text-center text-sm text-black font-medium transition hover:bg-gray-300"
                    >
                        Order Details
                    </Link>
                </div>

                <Link
                    href="orders/items"
                    className="block w-full rounded-md border border-gray-500 bg-gray-200 py-1 text-center text-sm text-black font-medium transition hover:bg-gray-300"
                >
                    Order Items
                </Link>

                <Link href="order"
                  className="block w-full rounded-md border border-gray-500 bg-gray-200 py-1 text-center text-sm text-black font-medium transition hover:bg-gray-300">
                    Paid Orders
                </Link>

                <Link href="order"  className="block w-full rounded-md border border-gray-500 bg-gray-200 py-1 text-center text-sm text-black font-medium transition hover:bg-gray-300">
                    Orders With Amount Greater Than 1000
                </Link>

                <Link href="order" className="w-full rounded-md bg-gray-400 py-3 text-center font-semibold text-black transition hover:bg-gray-300">
                    Pending Orders
                </Link>
            </div>
        </>
    );
}
