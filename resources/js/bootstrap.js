import axios from 'axios';
window.axios = axios;
import { router } from '@inertiajs/react';

// Pengaturan untuk Inertia
window.Inertia = router;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
