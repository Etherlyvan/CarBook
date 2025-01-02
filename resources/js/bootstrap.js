import axios from 'axios';
window.axios = axios;
import { Inertia } from '@inertiajs/inertia';

// Pengaturan untuk Inertia
window.Inertia = Inertia;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
