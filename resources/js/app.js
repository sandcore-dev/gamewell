import Vue from 'vue';

const files = require.context('./', true, /\.vue$/i);
files.keys().map((key) => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// eslint-disable-next-line no-unused-vars
const app = new Vue({
    el: '#app',
});
