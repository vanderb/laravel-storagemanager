import {reject, dropRight} from 'lodash'

import router from '../router'

export default {
    setDirectories(state, directories) { state.directories = directories },
    setFiles(state, files) { state.files = files },

    selectFile(state, file) { state.selected.push(file) },
    unselectFile(state, file) {
        state.selected = reject(state.selected, (item) => {
            return item == file
        });
    },

    selectAll(state) {
        state.selected = [];
        state.directories.forEach((dir) => {
            state.selected.push(dir)
        })
        state.files.forEach((file) => {
            state.selected.push(file)
        })
    }, 
    unselectAll(state) {
        state.selected = [];
    },
    directoryUp(state) {
        //@ts-ignore
        let { routes } = router.options

        if(routes && routes.length) {
            let newRoute = ''
        }

    },
    directoryRoot(state) {
        //@ts-ignore
        router.push({path: '/'})
    },

    updateRoutes(state, routes) {
        state.lastRoute = routes.last
        state.currentRoute = routes.current
    },

    changeView(state, view) {
        state.view = view
    }
}
