import Vue from 'vue'

import StorageManagerApp from './StorageManager'

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.csrf_token = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

const storageManager = new Vue({
    el: '#storage-manager',
    render: h => h(StorageManagerApp),
    data() {
        return {
            router: 'BLUBB'
        }
    }
});
