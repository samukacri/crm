import Chart from "./chart.js";

export default {
    install(app) {
        // Make Chart.js available globally
        window.Chart = Chart;
        
        // Also make it available on the Vue app for consistency
        app.config.globalProperties.$chart = Chart;
    }
};