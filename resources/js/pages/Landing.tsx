import { useState } from "react";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { Link } from "@inertiajs/react";
import {
  BarChart3,
  TrendingUp,
  Filter,
  Download,
  MessageSquare,
  Zap,
  Shield,
  Users,
  Check,
  ArrowRight
} from "lucide-react";

const Landing = () => {
  const [selectedPlan, setSelectedPlan] = useState("pro");

  const features = [
    {
      icon: BarChart3,
      title: "Predefined Reports",
      description: "8-10 comprehensive sales reports ready to use out of the box"
    },
    {
      icon: Filter,
      title: "Advanced Filtering",
      description: "Filter data by date range, products, customers, and more"
    },
    {
      icon: Download,
      title: "Export Options",
      description: "Export reports in PDF, CSV, and Excel formats"
    },
    {
      icon: MessageSquare,
      title: "Natural Language Queries",
      description: "Ask questions in plain English to generate custom reports"
    },
    {
      icon: TrendingUp,
      title: "Real-time Analytics",
      description: "Live data sync with your Shopify store"
    },
    {
      icon: Shield,
      title: "Secure & Compliant",
      description: "Enterprise-grade security for your sales data"
    }
  ];

  const plans = [
    {
      name: "Basic",
      price: "$29",
      period: "/month",
      description: "Perfect for small stores",
      features: [
        "5 predefined reports",
        "Basic filtering",
        "CSV export",
        "Email support"
      ],
      popular: false
    },
    {
      name: "Pro",
      price: "$79",
      period: "/month",
      description: "Most popular for growing businesses",
      features: [
        "10 predefined reports",
        "Advanced filtering",
        "All export formats",
        "NLP queries (100/month)",
        "Priority support",
        "Custom dashboards"
      ],
      popular: true
    },
    {
      name: "Enterprise",
      price: "$199",
      period: "/month",
      description: "For large-scale operations",
      features: [
        "Unlimited reports",
        "Advanced analytics",
        "White-label options",
        "Unlimited NLP queries",
        "24/7 phone support",
        "Custom integrations",
        "Dedicated account manager"
      ],
      popular: false
    }
  ];

  return (
    <div className="min-h-screen bg-background">
      {/* Navigation */}
      <nav className="border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60 sticky top-0 z-50 shadow-sm">
        <div className="container mx-auto px-6 h-16 flex items-center justify-between">
          <div className="flex items-center space-x-3">
            <BarChart3 className="h-7 w-7 text-primary" />
            <span className="font-extrabold text-xl tracking-wide">ReportPro</span>
          </div>
          <div className="flex items-center space-x-5 text-base font-medium">
                <Link
                    href="reports"
                    className="block w-full rounded-md border border-gray-500 bg-gray-200 py-1 text-center text-sm text-black font-medium transition hover:bg-gray-300"
                >
                    Reports
                </Link>
            <Button variant="ghost" size="sm" className="hover:text-primary transition-colors">
              Pricing
            </Button>
            <Button variant="outline" size="sm" className="font-semibold">
              Sign In
            </Button>
            <Button
              size="sm"
              className="font-semibold"
              onClick={() => window.location.href = '/dashboard'}
            >
              View Dashboard
            </Button>
          </div>
        </div>
      </nav>

      {/* Hero Section */}
      <section className="py-24 px-6 bg-gradient-to-br from-primary/10 via-transparent to-primary/5">
        <div className="container mx-auto max-w-7xl">
          <div className="grid lg:grid-cols-2 gap-16 items-center">
            <div className="space-y-8 animate-fade-in max-w-xl">
              <Badge className="inline-flex items-center bg-primary-light text-primary border border-primary/30 rounded-full px-3 py-1 text-xs font-semibold tracking-wide shadow-sm">
                <Zap className="h-4 w-4 mr-1" />
                AI-Powered Analytics
              </Badge>
              <h1 className="text-4xl md:text-6xl font-extrabold leading-tight tracking-tight">
                Transform Your{" "}
                <span className="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">
                  Shopify Sales
                </span>{" "}
                Into Insights
              </h1>
              <p className="text-lg text-muted-foreground leading-relaxed max-w-xl">
                Get powerful, AI-driven sales reports for your Shopify store.
                Ask questions in natural language and get instant answers with
                beautiful visualizations.
              </p>
              <div className="flex flex-col sm:flex-row gap-5">
                <Button
                  size="lg"
                  className="group w-full sm:w-auto bg-primary hover:bg-primary-dark border-0 shadow-md hover:shadow-lg transition"
                  onClick={() => window.location.href = '/dashboard'}
                >
                  Start Your Free Trial
                  <ArrowRight className="ml-3 h-5 w-5 group-hover:translate-x-1 transition-transform" />
                </Button>
                <Button
                  variant="outline"
                  size="lg"
                  className="w-full sm:w-auto border-primary text-primary font-semibold hover:bg-primary/10"
                >
                  Watch Demo
                </Button>
              </div>
              <div className="flex flex-wrap gap-8 text-sm text-muted-foreground mt-6">
                <div className="flex items-center gap-2">
                  <Check className="h-5 w-5 text-primary" />
                  14-day free trial
                </div>
                <div className="flex items-center gap-2">
                  <Check className="h-5 w-5 text-primary" />
                  No credit card required
                </div>
              </div>
            </div>
            <div className="relative animate-slide-up w-full max-w-lg mx-auto aspect-[16/9] rounded-3xl shadow-2xl border border-primary/10 overflow-hidden bg-gradient-to-br from-primary/20 to-transparent">
              {/* Put your dashboard image below */}
              <img
                src="https://via.placeholder.com/640x360.png?text=Sales+Dashboard+Preview" // Placeholder image. Replace it.
                alt="Sales Dashboard Preview"
                className="w-full h-full object-cover"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-black/25 rounded-3xl pointer-events-none"></div>
            </div>
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section className="py-24 px-6 bg-muted/30">
        <div className="container mx-auto max-w-7xl">
          <div className="text-center space-y-5 mb-20">
            <Badge className="inline-flex items-center justify-center mx-auto bg-accent-light text-accent border-accent/20 rounded-full px-3 py-1 text-xs font-semibold shadow-sm">
              <Users className="h-4 w-4 mr-1" />
              Trusted by 1000+ Stores
            </Badge>
            <h2 className="text-4xl font-extrabold tracking-tight">
              Everything You Need for Sales Analytics
            </h2>
            <p className="text-lg text-muted-foreground max-w-3xl mx-auto">
              Comprehensive reporting tools designed specifically for Shopify merchants
            </p>
          </div>

          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
            {features.map((feature, index) => (
              <Card
                key={index}
                className="bg-gradient-card border-0 shadow-md hover:shadow-xl transition-shadow duration-300 rounded-2xl p-6"
              >
                <CardHeader className="pb-4">
                  <div className="h-14 w-14 rounded-lg bg-primary-light flex items-center justify-center mb-5 transition-transform group-hover:scale-105">
                    <feature.icon className="h-7 w-7 text-primary" />
                  </div>
                  <CardTitle className="text-2xl font-semibold">{feature.title}</CardTitle>
                </CardHeader>
                <CardContent>
                  <CardDescription className="text-base text-muted-foreground leading-relaxed">
                    {feature.description}
                  </CardDescription>
                </CardContent>
              </Card>
            ))}
          </div>
        </div>
      </section>

      {/* Pricing Section */}
      <section className="py-24 px-6" id="pricing">
        <div className="container mx-auto max-w-7xl">
          <div className="text-center space-y-5 mb-20 max-w-3xl mx-auto">
            <h2 className="text-4xl font-extrabold tracking-wide">
              Choose Your Plan
            </h2>
            <p className="text-lg text-muted-foreground">
              Start free, then scale as you grow
            </p>
          </div>

          <div className="grid md:grid-cols-3 gap-10">
            {plans.map((plan, index) => (
              <Card
                key={index}
                className={`relative rounded-3xl border border-transparent transition-transform duration-300 ease-in-out ${
                  plan.popular
                    ? "ring-2 ring-primary shadow-glow scale-105 z-10"
                    : "hover:-translate-y-3 hover:shadow-xl"
                }`}
              >
                {plan.popular && (
                  <Badge className="absolute -top-4 left-1/2 -translate-x-1/2 bg-gradient-primary text-primary-foreground rounded-full px-4 py-1 shadow-lg text-sm font-semibold">
                    Most Popular
                  </Badge>
                )}
                <CardHeader className="text-center pb-4 pt-8">
                  <CardTitle className="text-3xl font-extrabold tracking-tight">{plan.name}</CardTitle>
                  <div className="flex items-baseline justify-center space-x-1 mt-4">
                    <span className="text-5xl font-extrabold">{plan.price}</span>
                    <span className="text-muted-foreground text-lg font-semibold">{plan.period}</span>
                  </div>
                  <CardDescription className="text-md text-muted-foreground mt-3 max-w-xs mx-auto">
                    {plan.description}
                  </CardDescription>
                </CardHeader>
                <CardContent className="space-y-6 px-8 pb-10 pt-4">
                  <Button
                    className="w-full font-semibold text-lg rounded-lg py-4 shadow-md transition hover:shadow-lg"
                    onClick={() => {
                      setSelectedPlan(plan.name.toLowerCase());
                      window.location.href = '/dashboard';
                    }}
                  >
                    {plan.popular ? "Start Free Trial" : "Get Started"}
                  </Button>
                  <div className="space-y-3">
                    {plan.features.map((feature, featureIndex) => (
                      <div key={featureIndex} className="flex items-center text-sm text-muted-foreground">
                        <Check className="h-5 w-5 text-primary mr-4 flex-shrink-0" />
                        <span>{feature}</span>
                      </div>
                    ))}
                  </div>
                </CardContent>
              </Card>
            ))}
          </div>
        </div>
      </section>

      {/* Footer */}
      <footer className="border-t border-muted-foreground/20 py-12 px-6 bg-background">
        <div className="container mx-auto max-w-7xl">
          <div className="flex flex-col md:flex-row justify-between items-center">
            <div className="flex items-center space-x-3 mb-6 md:mb-0">
              <BarChart3 className="h-6 w-6 text-primary" />
              <span className="font-semibold text-lg">ReportPro</span>
            </div>
            <p className="text-muted-foreground text-sm select-none">
              © 2024 ReportPro. All rights reserved.
            </p>
          </div>
        </div>
      </footer>
    </div>
  );
};

export default Landing;
