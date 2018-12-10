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
                <div id="storage-manager" v-pre></div>
            </div>
        </div>
    </div>

    <script src="{{ url('vendor/laravel-storagemanager/storage-manager.js') }}"></script>

</body>

</html>
