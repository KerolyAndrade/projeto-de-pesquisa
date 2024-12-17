import axios from 'axios';
import $ from 'jquery';
import './bootstrap.js';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
