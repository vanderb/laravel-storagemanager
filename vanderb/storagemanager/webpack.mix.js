let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */


let chunkFilename = 'js/chunks/[name].js';

mix.options({ processCssUrls: false });
mix.js('src/resources/js/storage-manager.js', 'dist/')
if(mix.inProduction()) {
    mix.version();
}
mix.webpackConfig({
    output: {
        publicPath: '/',
        chunkFilename: chunkFilename
    },

    module: {
        rules: [
            // We're registering the TypeScript loader here. It should only
            // apply when we're dealing with a `.ts` or `.tsx` file.
            {
                test: /\.tsx?$/,
                loader: 'ts-loader',
                options: { appendTsSuffixTo: [/\.vue$/] },
                exclude: /node_modules/
            },
            {
                test: /.js$/,
                exclude: /(node_modules)/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: [
                            ['env', {
                                "targets": {
                                    "browserslist": ["> 1%", "last 2 versions"]
                                }
                            }
                            ]
                        ]
                    }
                },
            },
        ]
    },
    resolve:
    {
        // We need to register the `.ts` extension so Webpack can resolve
        // TypeScript modules without explicitly providing an extension.
        // The other extensions in this list are identical to the Mix
        // defaults.
        extensions: ['*', '.js', '.jsx', '.vue', '.ts', '.tsx'],

        alias:
        {
            'scss':
                path.resolve(__dirname, './resources/assets/sass/frontend'),
            'vendor':
                path.resolve(__dirname, './node_modules/'),
            'TweenLite':
                path.resolve('node_modules', 'gsap/src/minified/TweenLite.min.js'),
            'TweenMax':
                path.resolve('node_modules', 'gsap/src/minified/TweenMax.min.js'),
            'TimelineLite':
                path.resolve('node_modules', 'gsap/src/minified/TimelineLite.min.js'),
            'TimelineMax':
                path.resolve('node_modules', 'gsap/src/minified/TimelineMax.min.js'),
            'ScrollMagic':
                path.resolve('node_modules', 'scrollmagic/scrollmagic/minified/ScrollMagic.min.js'),
            'animation.gsap':
                path.resolve('node_modules', 'scrollmagic/scrollmagic/minified/plugins/animation.gsap.min.js'),
            'debug.addIndicators':
                path.resolve('node_modules', 'scrollmagic/scrollmagic/minified/plugins/debug.addIndicators.min.js')
        }
    }
    ,

})
    ;