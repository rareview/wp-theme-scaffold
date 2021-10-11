const path          = require( 'path' );
const ExtractCSS    = require( 'mini-css-extract-plugin' );
const OptimizeCSS   = require( 'csso-webpack-plugin' ).default;
const OptimizeJS    = require( 'terser-webpack-plugin' );
const RemoveStyleJS = require( 'webpack-remove-empty-scripts' );

const devMode = process.env.BUILD_MODEL !== 'release';
const suffix  = devMode ? 'dev' : 'min';

const theme = {
	// Tells webpack to use its built-in optimizations accordingly.
	mode: devMode ? "development" : "production",
	// Cache the generated webpack modules and chunks to improve build speed.
	cache: devMode,
	// This option controls if and how source maps are generated.
	devtool: devMode ? "source-map" : false,
	// Lets you precisely control what bundle information gets displayed.
	stats: devMode ? "normal" : "minimal",
	// Finer control over webpack's built in optimizations based on chosen mode.
	optimization: {
		minimize: !devMode,
		minimizer: [
			new OptimizeJS(
				{ 
					extractComments: true
				}
			),
			new OptimizeCSS(),
		],
	},

	plugins : [
		new RemoveStyleJS(),
		new ExtractCSS( {
			filename : `[name].css`,
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
		'frontend-css'  : path.resolve( __dirname, 'src/css/frontend/frontend.css' ),
	},

	output : {
		path       : path.resolve( __dirname, 'dist' ),
		publicPath : 'dist/',
	},
};

module.exports = [ theme ];