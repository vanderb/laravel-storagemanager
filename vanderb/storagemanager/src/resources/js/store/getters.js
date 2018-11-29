import router from '../router'

export default {
    directories: state => state.directories,
    selected: state => state.selected,
    allSelected: state => state.selected.length == state.directories.length + state.files.length,
    files: state => state.files,
    isLoading: state => state.isLoading,
    lastRoute: state => state.lastRoute,
    currentRoute: state => state.currentRoute,
    prevRoute: state => state.currentRoute.path.substring(0, state.currentRoute.path.lastIndexOf("/")),
    getView: state => state.view 
}
