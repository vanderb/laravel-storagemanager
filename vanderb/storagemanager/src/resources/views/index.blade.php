<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} Storagemanager</title>

    <style>
        [v-cloak] {
            display: none;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <div class="row">
            <div class="col-sm-12">    
                <div id="storagemanager" v-cloak>

                    <h2>Medienmanager</h2>

                    <div class="row">

                        <div class="col-sm-12 col-md-6 d-flex align-items-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item" :class="{active: !routes.length}">
                                        <font-awesome-icon icon="home"></font-awesome-icon>
                                    </li>
                                    <li  class="breadcrumb-item" v-for="(dir, key) in paths" :key="key" :class="{active: dir.path == $route.path}">
                                        <a :href="dir.path" v-if="dir.path !== $route.path">@{{ dir.name }}</a>
                                        <span v-else>@{{ dir.name }}</span>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-secondary">
                                    <font-awesome-icon icon="file-upload"></font-awesome-icon>
                                    Datei hochladen
                                </button>
                            </div>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-secondary">
                                    <font-awesome-icon :icon="['far', 'check-square']"></font-awesome-icon>
                                    Alle auswählen
                                </button>
                            </div>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-secondary view-btn" :class="{current: view == 'grid'}" @click.prevent="changeView('grid')">
                                    <font-awesome-icon icon="th-large"></font-awesome-icon>
                                </button>
                                <button type="button" class="btn btn-secondary view-btn" :class="{current: view == 'list'}" @click.prevent="changeView('list')">
                                    <font-awesome-icon icon="th-list"></font-awesome-icon>
                                </button>
                            </div>
                        </div>

                    </div>

                    <div class="row no-gutters">
                        <div class="col-sm-12">
                            <div class="filebrowser">
                                
                                <table class="table files-table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="col-check" colspan="2"></th>
                                            <th class="col-name">Name</th>
                                            <th class="col-modified">Zuletzt bearbeitet</th>
                                            <th class="col-actions"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="dir-up">
                                            <td class="col-check" colspan="2">
                                                <span>
                                                    <font-awesome-icon icon="folder-open"></font-awesome-icon> ...
                                                </span>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr v-for="(dir, key) in directories" :key="'dir-'+key" :class="{selected: isSelected(dir)}">
                                            <td class="col-check">
                                                <font-awesome-icon :icon="['far', 'check-square']" key="unchecked" @click.prevent="$store.commit('selectFile', dir)" v-if="!isSelected(dir)"></font-awesome-icon>
                                                <font-awesome-icon :icon="['fas', 'check-square']" key="checked" @click.prevent="$store.commit('unselectFile', dir)" v-else></font-awesome-icon>
                                            </td>
                                            <td class="col-icon">
                                                <i class="glyphicon glyphicon-folder-open"></i> 
                                            </td>
                                            <td class="col-name" @click="changeDirectory(dir.path)">
                                                <div class="file">
                                                    <span class="file-name">@{{ dir.name }}</span>
                                                    <span class="badge badge-secondary" v-if="dir.file_count">@{{ dir.file_count }}</span>
                                                </div>
                                            </td>
                                            <td class="col-modified">
                                                <div class="last-modified">
                                                  @{{ dir.last_modified }}
                                                </div>
                                            </td>
                                            <td class="col-actions">
 
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="{{ url('vendor/laravel-storagemanager/storagemanager.js') }}"></script>

</body>

</html>
