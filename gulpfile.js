const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir.config.css.folder = '/';
elixir.config.js.folder = '/';
elixir.config.sourcemaps = false;


elixir(function (mix) {
    mix.styles([
        'bs3/css/bootstrap.min.css',
        'css/bootstrap-reset.css',
        'font-awesome/css/font-awesome.css',
        'css/style.css',
        'css/style-responsive.css',
        'js/ie8-responsive-file-warning.js'
    ], 'public/css/app.css');

    mix.webpack('js/autosize.js');
    mix.scripts([
        'js/jquery.js',
        'bs3/js/bootstrap.min.js',
        'js/jquery.dcjqaccordion.2.7.js',
        'js/jquery.scrollTo.min.js',
        'js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js',
        'js/jquery.nicescroll.js',
        'js/easypiechart/jquery.easypiechart.js',
        'js/sparkline/jquery.sparkline.js',
        'js/scripts.js'
    ], 'public/js/app.js');

    //DataTable
    mix.styles([
        'js/advanced-datatable/css/demo_page.css',
        'js/advanced-datatable/css/demo_table.css',
        'js/data-tables/DT_bootstrap.css'
    ],'public/css/dataTable.css');
    mix.scripts([
        'js/advanced-datatable/js/jquery.dataTables.js',
        'js/data-tables/DT_bootstrap.js'
    ],'public/js/dataTable.js');
    mix.copy('resources/assets/font-awesome/fonts', 'public/fonts');
    mix.copy('resources/assets/bs3/fonts', 'public/css/fonts');
    mix.copy('resources/assets/bucket-ico-fonts', 'public/fonts');
    mix.copy('resources/images', 'public/images');
});