import Vue from 'vue'

import { store } from './store'

import router from './router'
router.beforeEach((to, from, next) => {
    store.commit('updateRoutes', {current: to, last: from})
    next();
})

import {mapGetters, mapActions} from 'vuex'

import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { far } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import "../scss/storagemanager.scss"

library.add(fas, far)

Vue.component('font-awesome-icon', FontAwesomeIcon)

const app = new Vue({
    el: '#storagemanager',
    store,
    router,
    beforeMount() {
        this.getFiles()
    },
    methods: {
        ...mapActions([
            'getFiles',
            'changeDirectory',
            'refreshDirectory',
            'changeView'
        ]),
        isSelected(file) {
            return find(this.selected, (item) => {
              return item == file;
            })
        }
    },
    computed: {
        ...mapGetters({
            directories: 'directories',
            files: 'files',
            selected: 'selected',
            isLoading: 'isLoading',
            lastRoute: 'lastRoute',
            currentRoute: 'currentRoute',
            prevRoute: 'prevRoute',
            view: 'getView'
        }),
        routes() {
            return this.$router.options.routes
        },
        paths() {
            let lastPath = ''
            
            let paths = []
        
            this.$route.path.split('/').forEach(path => {
              if(path) {
                paths.push({
                  name: path,
                  path: '/' + (lastPath + path)
                })
                lastPath = path + '/';
              }
            })
        
            return paths;
        }
    }
});
