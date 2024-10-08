import './bootstrap';
import '../scss/config/corporate/app.scss';
import '@vueform/slider/themes/default.css';
import '../scss/mermaid.min.css';

import { createApp, h } from 'vue';
import { createInertiaApp, Link } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import BootstrapVueNext from 'bootstrap-vue-next';
// import vClickOutside from "click-outside-vue3";
// import VueApexCharts from "vue3-apexcharts";
// import VueFeather from 'vue-feather';
// import VueTheMask from 'vue-the-mask';

import alertify from 'alertifyjs';
import 'alertifyjs/build/css/alertify.css'

import AOS from 'aos';
import 'aos/dist/aos.css';

import store from "./state/store";
import i18n from './i18n'

AOS.init({
    easing: 'ease-out-back',
    duration: 1000
});

import moment from "moment";

createInertiaApp({
    title: title => title ? `${title} - HCMS PT SIER` : 'HCMS - PT. SIER',
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .component("Link", Link)
            .use(plugin)
            .use(store)
            .use(i18n)
            .use(ZiggyVue)
            .use(BootstrapVueNext)
            .use(alertify)

        app.config.globalProperties.moment = moment
        return app.mount(el);
    },
    progress: {
        color: '#0089F7',
        delay: 100,
    },
});
