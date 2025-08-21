import '../css/app.css';
import { createInertiaApp, router } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';
import { initializeTheme } from './hooks/use-appearance';
import createApp from "@shopify/app-bridge";
import { getSessionToken } from "@shopify/app-bridge/utilities";

const apiKey = "9f58da97fffaf002d0c9eaa1f81d0564";
console.log("Shopify API Key:", apiKey);

const host = new URLSearchParams(window.location.search).get('host') as string
console.log("Shopify Host:", host);

const appBridge = createApp({ apiKey, host })

console.log("App Bridge instance:", appBridge);

router.on("before", (event) => {
    const visit = event.detail.visit;
    console.log("Visit details:", visit);
    // Prevent infinite loops
    if (visit.headers?.["X-Token-Injected"]) return;
    (async () => {
      const sessionToken = await getSessionToken(appBridge);
      router.visit(visit.url, {
        ...visit,
        headers: {
          ...(visit.headers || {}),
          Authorization: `Bearer ${sessionToken}`,
          "X-Token-Injected": "1", // flag to prevent recursion
        },
      });
    })();
    // Cancel the original visit
    return false;
  });


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
createInertiaApp({
    title: (title) => title ? `${title} - ${appName}` : appName,
    resolve: (name) => resolvePageComponent(`./pages/${name}.tsx`, import.meta.glob('./pages/**/*.tsx')),
    setup({ el, App, props }) {
        const root = createRoot(el);
        root.render(<><App {...props} /></>);
    },
    progress: {
        color: '#4B5563',
    },
});
// This will set light / dark mode on load...
initializeTheme();
