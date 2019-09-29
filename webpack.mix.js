let mix  = require('laravel-mix');
let path = require('path');

yaml = require('js-yaml');
fs   = require('fs');

let config = {};
try {
    //读取配置文件
    config = yaml.safeLoad(fs.readFileSync(path.resolve(__dirname, '.config.yml'), 'utf8'));
} catch (e) {
    config = {admin: {cdn: {enable: false}}};
}


if (config.admin.cdn.enable === true) {
    //开启CDN时打包忽略
    mix.webpackConfig({
        externals: {
            vue         : 'Vue',
            'element-ui': 'ELEMENT'
        }
    });
}

//生产环境开启版本控制
if (mix.inProduction()) {
    mix.version();
}

//非生产环境禁用懒加载
if (!mix.inProduction()) {
    mix.babelConfig({
        plugins: ['dynamic-import-node'],
    })
}
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/admin/app.js', 'public/js/admin')
    .sass('resources/sass/app.scss', 'public/css/admin', {implementation: require('node-sass')})
    .webpackConfig({
        resolve: {
            extensions: ['.js', '.vue', '.json'],
            alias     : {
                '@': path.resolve(__dirname, 'resources/assets/admin')
            }
        },
        output : {
            // 未被列在 entry 且需要被打包出来的文件
            chunkFilename: 'js/admin/[id].[hash].js'
        }
    })
    .options({
        uglify: {
            uglifyOptions: {
                sourceMap: false,
                compress : {
                    warnings    : false,
                    drop_console: true
                },
                output   : {
                    beautify: false
                }
            }
        }
    });
