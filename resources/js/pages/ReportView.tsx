import React, { useState } from "react";
import { Inertia } from "@inertiajs/inertia";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Badge } from "@/components/ui/badge";
import { Search, Filter, Star, X } from "lucide-react";
import { router } from "@inertiajs/react";

interface Report {
  id: string;
  name: string;
  category: string;
  lastViewed: string;
  views: number;
  isFavorite: boolean;
}

const ReportView: React.FC = () => {
  const [searchQuery, setSearchQuery] = useState("");
  const [activeFilters, setActiveFilters] = useState<string[]>(["Orders"]);
  const [activeTab, setActiveTab] = useState("all");

  const removeFilter = (filterToRemove: string) => {
    setActiveFilters(activeFilters.filter((filter) => filter !== filterToRemove));
  };



  return (
    <div className="min-h-screen bg-background p-6">
      <div className="max-w-7xl mx-auto space-y-8">
        {/* Header */}
        <header className="flex items-center justify-between">
          <h1 className="text-3xl font-extrabold text-foreground">Reports</h1>
          <div className="flex gap-3">
            <Button variant="outline" onClick={() => Inertia.visit(route("reports.requestCustom"))}>
              Request custom report
            </Button>
            <Button className="bg-primary text-primary-foreground hover:bg-primary/90" onClick={() => Inertia.visit(route("reports.create"))}>
              Create report
            </Button>
          </div>
        </header>

        {/* Simple Tabs */}
        <div className="flex gap-4 border-b border-muted pb-3">
          {["all", "custom", "favorites"].map((tab) => (
            <button
              key={tab}
              onClick={() => setActiveTab(tab)}
              className={`px-4 py-2 font-semibold rounded-t-md ${
                activeTab === tab ? "border-b-2 border-primary text-primary" : "text-muted-foreground"
              }`}
            >
              {tab === "all" ? "All reports" : tab === "custom" ? "Custom reports" : "My favorites"}
            </button>
          ))}
        </div>

        {/* Search and Filters */}
        <div className="mt-6 max-w-md space-y-5">
          <div className="relative">
            <Search className="absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground w-5 h-5" />
            <Input
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
              placeholder="Search across reports..."
              className="pl-12 rounded-lg"
            />
            
          </div>


        </div>

        {/* Reports Table using HTML */}
        <section className="bg-card border border-border rounded-lg shadow-sm overflow-x-auto mt-8">
          <table className="min-w-full divide-y divide-border">
            <thead className="bg-muted">
              <tr>
                <th className="px-4 py-2 w-10"></th>
                <th className="px-4 py-2 text-left text-muted-foreground font-semibold">Name</th>
                <th className="px-4 py-2 text-left text-muted-foreground font-semibold">Category</th>
                <th className="px-4 py-2 text-left text-muted-foreground font-semibold">Last viewed</th>
                <th className="px-4 py-2 text-right text-muted-foreground font-semibold">Views</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-border">
                <tr
                  className="hover:bg-muted/40 cursor-pointer"
                  onClick={()=>router.visit('/?title=Orders Details')}
                >
                  <td colSpan={5} className="px-4 py-3 text-center text-sm text-black font-medium bg-gray-200 rounded-md border border-gray-500" >
                    Order Details
                  </td>
                </tr>
                <tr
                  className="hover:bg-muted/40 cursor-pointer"
                  onClick={() => router.visit('orders?financial_status=PAID&title=Paid Orders')}
                >
                  <td colSpan={5} className="px-4 py-3 text-center text-sm text-black font-medium bg-gray-200 rounded-md border border-gray-500">
                    Paid Orders
                  </td>
                </tr>
                <tr
                  className="hover:bg-muted/40 cursor-pointer"
                  onClick={() => router.visit('orders?financial_status=PENDING&title=Pending Orders')}
                >
                  <td colSpan={5} className="px-4 py-3 text-center text-sm text-black font-medium bg-gray-200 rounded-md border border-gray-500">
                    Pending Orders
                  </td>
                </tr>
                <tr
                  className="hover:bg-muted/40 cursor-pointer"
                  onClick={() => router.visit('orders?min_amount=1000&title=Order Greater than 1000')}
                >
                  <td colSpan={5} className="px-4 py-3 text-center text-sm text-black font-medium bg-gray-200 rounded-md border border-gray-500">
                    Orders With Amount Greater Than 1000
                  </td>
                </tr>
                <tr
                  className="hover:bg-muted/40 cursor-pointer"
                  onClick={() => router.visit('orders/items')}
                >
                  <td colSpan={5} className="px-4 py-3 text-center text-sm text-black font-medium bg-gray-200 rounded-md border border-gray-500"
                  >
                    Order Items
                  </td>
                </tr>
            </tbody>

          </table>
        </section>
      </div>
    </div>
  );
};

export default ReportView;
