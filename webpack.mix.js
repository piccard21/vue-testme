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

const WebpackShellPlugin = require('webpack-shell-plugin');

mix.js('resources/assets/js/app.js', 'public/js')
	.sass('resources/assets/sass/app.scss', 'public/css')
	.copy('resources/assets/img', 'public/img')


	// Add shell command plugin configured to create JavaScript language file
	.webpackConfig({
		plugins:
			[
				new WebpackShellPlugin({
					onBuildStart: ['php artisan lang:js public/lang/messages.js -c --quiet'],
					onBuildEnd: []
				})
			]
	});
