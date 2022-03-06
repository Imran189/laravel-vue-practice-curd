require('./bootstrap');

import 'bootstrap/scss/bootstrap.scss';
import 'bootstrap/dist/js/bootstrap.js';
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.css';

window.Swal = Swal;
const toast = Swal.mixin({
 toast:true,
 position:'top-end',
 timer:3000,
 timeProgressBar:true
});
window.toast = toast;


import { createApp } from 'vue';
import App from "./components/App.vue";
import router from './router';

createApp(App).use(router).mount("#app");
