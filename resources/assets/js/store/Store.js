export default {
  state: {
    aggregrations: [],
    results: [],
    foundResults: 0,
    totalResults: 0,
  },

  actions: {
    search(context, searchCriteria) {
      axios.post('/api/search', searchCriteria).then(response => context.commit('UPDATE_RESULTS', response.data));
    },
  },

  getters: {
    aggregrations(state) {
      return state.aggregrations;
    },

    results(state) {
      return state.results;
    },

    foundResults(state) {
      return state.foundResults;
    },

    totalResults(state) {
      return state.totalResults;
    },
  },

  mutations: {
    UPDATE_RESULTS(state, value) {
      state.foundResults = value.meta.total_hits;
      state.totalResults = value.meta.total_all;
      state.results = value.data;
      state.aggregrations = value.facets;
    },
  },
}
