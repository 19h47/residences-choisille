// https://medium.com/@wesharehoodies/simple-beginner-guide-for-webpack-2-0-from-scratch-part-v-495dba627718

// webpack itself
const webpack = require('webpack');

// nodejs dependency when dealing with paths
const path = require('path');

// extract css into a dedicated file
const ExtractTextWebpackPlugin = require('extract-text-webpack-plugin');

// "uglify" our output js code
const UglifyJs = require('uglifyjs-webpack-plugin');

const Manifest = require('webpack-manifest-plugin');
const Clean = require('clean-webpack-plugin');
const Html = require('html-webpack-plugin');
const SVGSpritemapPlugin = require('svg-spritemap-webpack-plugin');


const production = process.env.NODE_ENV === 'production';


// config object
let config = {
	
	 // entry file
	entry: ['./src/index.js', './src/assets/stylesheets/styles.scss'],
	
	output: {

		// output path
		path: path.resolve(__dirname, 'public'),

		 // output filename
		filename: production ? 'bundle.[chunkhash:8].js' : 'bundle.js'
	},

	// These options change how modules are resolved
	resolve: {

		// Automatically resolve certain extensions
		extensions: ['.js', '.jsx', '.json', '.scss', '.css', '.jpeg', '.jpg', '.gif', '.png'],
		
		// Create aliases
		alias: { 

			// src/assets/images alias
	      		images: path.resolve(__dirname, 'src/assets/img/')
	    	}
	},
	module: {
	    rules: [
	    	{
	    		enforce: 'pre',

		    	// files ending with .js
		      	test: /\.js$/,

		      	 // exclude the node_modules directory
		      	exclude: /node_modules/,
		      	
		      	use: ['eslint-loader']
	    	},
	    	{
		    	// files ending with .js
		      	test: /\.js$/,

		      	 // exclude the node_modules directory
		      	exclude: /node_modules/,
		      	
		      	 // use this (babel-core) loader
		      	use: ['babel-loader']
	    	},
	    	{ 
	    	    test: /\.svg$/, 
	    	    loader: 'file-loader' 
	 	 	},
	    	{
		    	// files ending with .scss
		    	test: /\.scss$/, 

		    	 // call our plugin with extract method
		    	use: ExtractTextWebpackPlugin.extract({

		    		// use these loader, order is important, from right to left
		    		use: ['css-loader', 'postcss-loader', 'sass-loader'],

		    		// fallback for any CSS not extracted
		    		fallback: 'style-loader'

		    	})
	    	},
          	{
		        test: /\.(woff2?|eot|ttf|otf|woff)?$/,
		        loader: 'file-loader'
          	},
          	{	
          		// all files ending with .jsx
          		test: /\.jsx$/,

          		// use the babel-loader for all .jsx files
          		loader: 'babel-loader',

          		// exclude searching for files in the node_modules directory
          		exclude: /node_modules/
          	}
		]
  	},

  	// Plugins
  	plugins: [

  		// call the ExtractTextWebpackPlugin constructor and name our css file
  		new ExtractTextWebpackPlugin({
  			filename: production ? 'global.[chunkhash:8].css' : 'global.css'
  		}),

		// new Html()
		new SVGSpritemapPlugin({
		   src: path.resolve(__dirname, 'src/assets/img/svg/icons/*.svg' ),
		   filename : 'icons.svg',
		   prefix : '',
		   svgo : { removeTitle : true }
		   // path: './resources/assets/svg/**/*.svg'
		})
  	],

  	// devServer: {

  	// 	// A directory or URL to serve HTML content from
  	// 	contentBase: path.resolve(__dirname, 'public'),

  	// 	// fallback to /index.html for single Page Application
  	// 	historyApiFallback: true,

  	// 	// inline mode (set to false to disable including client scripts) (like livereload)
  	// 	inline: true,

  	// 	// open default browser while launching
  	// 	open: false,

  	// 	overlay: true
  	// },

  	// enable devtool for better debugging experience
  	devtool: 'eval-source-map'
}


module.exports = config;


if (production) {

	module.exports.plugins.push(			
		new UglifyJs()
	);

	module.exports.plugins.push(
		new Manifest()
	);

	module.exports.plugins.push(
		new Clean(
			['public'], {
				root: path.resolve('./public '),
				dry: false
			}
		)
	);
}
