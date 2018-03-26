require('./bootstrap');
window.Vue = require('vue');

Vue.filter('facetTitle', function(value) {
    if (value == 'typeRouter') {return 'Type router';}
    if (value == 'brand') { return 'Merk'; }
    if (value == 'coolbluesChoice') {return 'CoolBlue\'s Keuze';}
    if (value == 'administratorOptions') {return 'Beheerdersopties';}
    return value;
});

Vue.component('search-aggregations', require('./components/SearchAggregrations.vue'));
Vue.component('search-bar', require('./components/SearchBar.vue'));
Vue.component('search-results', require('./components/SearchResults.vue'));

import Vuex from 'vuex';
Vue.use(Vuex);

import Store from './store/Store';
const store = new Vuex.Store(Store);

const app = new Vue({
    el: '#app',
    store: store,

    data: {
        searchCriteria: {
            size: 12,
            from: 0,
            search_text: null,
            typeRouter: [],
            brand: [],
            coolbluesChoice: [],
            administratorOptions: [],
        }
    },

    watch: {
        searchCriteria: {
            handler: function (val, oldVal) {
                this.$store.dispatch('search', this.searchCriteria)
            },
            deep: true // Needed for the array listeners.
        }
    },

    mounted() {
        this.$store.dispatch('search', this.searchCriteria)
    }
});
