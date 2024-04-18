import Vue from 'vue';

const componentFiles = import.meta.glob(
    './components/**/*.vue',
    {
        eager: true,
        import: 'default',
    },
);

Object.entries(componentFiles).forEach((componentFile) => {
    const [path, module] = componentFile;
    Vue.component(
        path
            .replace('./components/', '')
            .replaceAll('/', '')
            .split('.vue')[0],
        module,
    );
});

// eslint-disable-next-line no-unused-vars
const app = new Vue({
    el: '#app',
});
