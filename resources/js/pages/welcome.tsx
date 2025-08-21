import { Head, Link, usePage } from '@inertiajs/react';

export default function Welcome() {

  return (
    <>
   <div className="min-h-screen flex flex-col items-center justify-center bg-gray-100 p-6 gap-4">

      <input
        type="text"
        placeholder="Search..."
        className="w-7/10 max-w-xl px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 mb-4"
      />

    <Link
      href="order"
      className="w-7/10 max-w-xl bg-gray-400 text-black font-semibold text-center py-3 rounded-md hover:bg-gray-300 transition"
    >
      Order Details
    </Link>

    <Link
      href="order"
      className="w-7/10 max-w-xl bg-gray-400 text-black font-semibold text-center py-3 rounded-md hover:bg-gray-300 transition"
    >
      Order Items
    </Link>

    <Link
      href="order"
      className="w-7/10 max-w-xl bg-gray-400 text-black font-semibold text-center py-3 rounded-md hover:bg-gray-300 transition"
    >
      Paid Orders
    </Link>

    <Link
      href="order"
      className="w-7/10 max-w-xl bg-gray-400 text-black font-semibold text-center py-3 rounded-md hover:bg-gray-300 transition"
    >
      Order With Amount Greater Than 1000
    </Link>

    <Link
      href="order"
      className="w-7/10 max-w-xl bg-gray-400 text-black font-semibold text-center py-3 rounded-md hover:bg-gray-300 transition"
    >
       Pending Orders
    </Link>





    </div>
    </>
  );
}
