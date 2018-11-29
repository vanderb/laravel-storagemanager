import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import getters from './getters'
import mutations from './mutations'
import actions from './actions'

export const store = new Vuex.Store({
    state: {
        directories: [],
        files: [],
        selected: [],
        isLoading: true,
        lastRoute: {},
        currentRoute: {},
        view: 'grid'
    },
    getters,
    mutations,
    actions
})
