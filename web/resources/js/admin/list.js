const Vue = require('vue');

Vue.component('list-component', require('./components/List').default);

const app = new Vue({
    el: '#list'
})
