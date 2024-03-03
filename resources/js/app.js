import './bootstrap';
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import icons from './icons';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { router } from '@inertiajs/vue3'
import { useLoading } from 'vue-loading-overlay'

// Route in Vue
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

// Toast
import Notifications from '@kyvg/vue3-notification';
import Vue3Toasity from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';


// Loader
import { LoadingPlugin } from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';

// Sweet Alert
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';


// Date Picker
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

const $loading = useLoading({
    loader: 'bars',
    width: 130,
    height: 50,
    color: "#7367f0"
});

let loader = null;

router.on('before', (event) => {
    loader = $loading.show();
});

router.on('finish', (event) => {
    setTimeout(() => {
        loader.hide()
    }, 500)
});

createInertiaApp({
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(VueSweetalert2)
            .use(Notifications)
            .use(LoadingPlugin)
            .use(VueDatePicker)
            .use(Vue3Toasity, { autoClose: 3000 })
            .component("font-awesome-icon", FontAwesomeIcon)
            .mount(el);
    },
    progress: false
    // progress: {
    //     color: '#4B5563',
    // },
});
