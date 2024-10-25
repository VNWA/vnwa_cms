import './bootstrap';
import '../css/app.css';
import '../css/setting.css';

import { createApp, h, Transition, TransitionGroup } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
window.toast = toast;
import axios from 'axios';
window.axios = axios;
import Vue3EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { far } from '@fortawesome/free-regular-svg-icons'
import { fab } from '@fortawesome/free-brands-svg-icons'
library.add(fas)
library.add(fab)
library.add(far)

import { createPinia } from 'pinia';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';

import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';
import CKEditor from '@ckeditor/ckeditor5-vue';

const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);

export default pinia;

const appName = import.meta.env.VITE_APP_NAME || 'GPL';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(PrimeVue, {
                theme: {
                    preset: Aura
                }
            })
            .component('transition', Transition)
            .use(CKEditor)
            .component('DataTable', Vue3EasyDataTable)
            .use(ZiggyVue)
            .use(pinia)
            .component('icon', FontAwesomeIcon)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
