import axios from 'axios';

import router from '../router'

const $http = axios.create({
    baseURL: '/storagemanager/api/',
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
})

export default {
    getFiles({state, commit}) {
        let $router = router.app.$router;
        let $route = router.app.$route;

        let request = {}

        if($route.name !== 'root') {
            request = {params: {directory: $route.path}}
        }

        state.isLoading = true;

        $http.get('path/get', request).then(response => {

            commit('setDirectories', response.data.directories)
            commit('setFiles', response.data.files)

            let paths = [];
            response.data.directories.forEach((dir) => {
                paths.push({
                    path: dir.path
                })
            })

            router.addRoutes(paths);
 
            state.isLoading = false;

        })
    },

    changeDirectory({state, dispatch, commit}, dir) {
        let $router = router.app.$router;
        
        $router.push(dir)
        dispatch('getFiles');
    },

    refreshDirectory({state, dispatch}) {
        dispatch('getFiles');
    },

    changeView({state}, view) {
        state.view = view
    }
}
