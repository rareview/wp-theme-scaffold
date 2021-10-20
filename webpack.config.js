const path = require( 'path' );
const { CleanWebpackPlugin } = require( 'clean-webpack-plugin' );
const CopyWebpackPlugin = require( 'copy-webpack-plugin' );
const ExtractCSS = require( 'mini-css-extract-plugin' );
const OptimizeCSS = require( 'csso-webpack-plugin' ).default;
const OptimizeJS = require( 'terser-webpack-plugin' );
const RemoveStyleJS = require( 'webpack-remove-empty-scripts' );

const devMode = process.env.BUILD_MODEL !== 'release';

const theme = {
	// Tells webpack to use its built-in optimizations accordingly.
	mode         : devMode ? 'development' : 'production',
	// Cache the generated webpack modules and chunks to improve build speed.
	cache        : devMode,
	// This option controls if and how source maps are generated.
	devtool      : devMode ? 'source-map' : false,
	// Lets you precisely control what bundle information gets displayed.
	stats        : devMode ? 'normal' : 'minimal',
	// Finer control over webpack's built in optimizations based on chosen mode.
	optimization : {
		minimize  : ! devMode,
		minimizer : [
			new OptimizeJS(
				{
					extractComments : true,
				},
			),
			new OptimizeCSS(),
		],
	},

	plugins : [
		new RemoveStyleJS(),
		new CleanWebpackPlugin( {
			cleanStaleWebpackAssets : false,
		} ),
		new ExtractCSS( {
			filename : `[name].css`,
		} ),
		new CopyWebpackPlugin( {
			patterns : [
				{
					from    : '**/*.{jpg,jpeg,png,gif,svg,eot,ttf,woff,woff2}',
					to      : '[path][name][ext]',
					context : path.resolve( __dirname, 'src' ),
				},
			],
		} ),
	],

	module : {
		rules : [
			{
				test    : /\.js$/,
				exclude : /node_modules/,
				use     : {
					loader  : 'babel-loader',
					options : {
						presets : [
							'@wordpress/default',
						],
					},
				},
			},

			{
				test : /\.css$/i,
				use  : [
					ExtractCSS.loader,
					{
						loader  : 'css-loader',
						options : {
							sourceMap : true,
							url       : false,
						},
					},
					{
						loader : 'postcss-loader',
					},
				],
			},
		],
	},

	entry : {
		'frontend-css' : path.resolve( __dirname, 'src/css/frontend/frontend.css' ),
		'frontend-js'  : path.resolve( __dirname, 'src/js/frontend/index.js' ),
		'debug-css'    : path.resolve( __dirname, 'src/css/debug/debug.css' ),
	},

	output : {
		path       : path.resolve( __dirname, 'dist' ),
		publicPath : 'dist/',
	},
};

module.exports = [ theme ];
