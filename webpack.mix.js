let mix = require('laravel-mix');

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

mix.js(['resources/assets/js/app.js',
	"resources/assets/js/popper.min.js",
	"resources/assets/js/hammer.min.js",
    "resources/assets/js/webslidemenu.js",
    "resources/assets/js/fresco.js",
    "resources/assets/js/lightbox-plus-jquery.min.js",
    "resources/assets/js/owl.carousel.min.js",
	"resources/assets/js/typeahead.jquery.min.js",
    "resources/assets/js/bootstrap-select.js"], 'js/app.js')
   .styles(["resources/assets/css/font-awesome.min.css",
		"resources/assets/css/bootstrap.min.css",
		"resources/assets/css/demo.css",
		"resources/assets/css/webslidemenu.css",
		"resources/assets/css/owl.carousel.min.css",
		"resources/assets/css/owl.theme.default.min.css",
		"resources/assets/css/typeaheadjs.css",
		"resources/assets/css/lightbox.css",
		"resources/assets/css/fresco.css",
		"resources/assets/css/bootstrap-select.css",
		"resources/assets/css/style.css"], 'html/css/app.css')
   .setPublicPath('html');