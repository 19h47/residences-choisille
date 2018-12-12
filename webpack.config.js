const path = require('path');

const CleanWebpackPlugin = require('clean-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const ManifestPlugin = require('webpack-manifest-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const Manifest = require('webpack-manifest-plugin');
const SpriteLoaderPlugin = require('svg-sprite-loader/plugin');
const WebpackNotifier = require('webpack-notifier');

const production = process.env.NODE_ENV === 'production';

module.exports = {
	watch: production ? false : true,
	output: {
		filename: production ? '[name].[chunkhash:8].js' : '[name].js',
	},
	resolve: {
		alias: {
			'@': path.resolve(__dirname),
			src: path.resolve(__dirname, 'src'),
			Blocks: path.resolve(__dirname, 'src/blocks'),
			Common: path.resolve(__dirname, 'src/common'),
			Datas: path.resolve(__dirname, 'src/js/datas'),
			Pages: path.resolve(__dirname, 'src/js/pages'),
			Transitions: path.resolve(__dirname, 'src/js/transitions'),
			Utils: path.resolve(__dirname, 'src/js/utils'),
			png: path.resolve(__dirname, 'src/img/png'),
			jpg: path.resolve(__dirname, 'src/img/jpg'),
			svg: path.resolve(__dirname, 'src/img/svg'),
			videos: path.resolve(__dirname, 'src/videos'),
			icons: path.resolve(__dirname, 'src/icons'),
			js: path.resolve(__dirname, 'src/js'),
			stylesheets: path.resolve(__dirname, 'src/stylesheets'),
		}
	},
	module: {
		rules: [{
			enforce: 'pre',
			test: /\.js$/,
			exclude: /node_modules/,
			use: ['eslint-loader']
		},
		{
			test: /\.js$/,
			exclude: /node_modules/,
			use: ['babel-loader']
		},
		{
			test: /\.scss$/,
			exclude: /node_modules/,
			use: [
				MiniCssExtractPlugin.loader,
				{
					loader: 'css-loader',
					options: {
						sourceMap: production ? false : true
					}
				},
				{
					loader: 'postcss-loader',
					options: {
						sourceMap: production ? false : true
					}
				},
				{
					loader: 'sass-loader',
					options: {
						sourceMap: production ? false : true
					}
				}
			]
		},
		{
			test: /\.(woff2?|eot|ttf|otf|woff|svg)?$/,
			exclude: [/img/, /icons/],
			use: [{
				loader: 'file-loader',
				options: {
					name: '[name].[ext]',
					outputPath: 'fonts'
				},

			}]
		},
		{
			test: /\.svg$/,
			exclude: [/img/, /fonts/],
			use: [{
				loader: 'svg-sprite-loader',
				options: {
					spriteFilename: 'icons.svg',
					extract: true
				}
			},
			'svg-transform-loader',
			'svgo-loader'
		]},
		{
			test: /\.svg$/,
			exclude: [/fonts/, /icons/],
			use: [{
				loader: 'file-loader',
				options: {
					outputPath: 'img/svg'
				}
			},
			{
				loader: 'svgo-loader',
				options: {
					plugins: [{
						removeTitle: true
					},
					{
						convertColors: {
							shorthex: false
						}
					},
					{
						convertPathData: false
					}]
				}
			}]
		},
		{
			test: /\.(gif|png|jpe?g)$/i,
			use: [{
				loader: 'file-loader',
				options: {
					outputPath: 'img/',
					name: '[ext]/[hash].[ext]'
				}
			},
			{
				loader: 'image-webpack-loader',
				options: {
					mozjpeg: {
						progressive: true,
						quality: 65
					},
					optipng: {
						enabled: false
					},
					pngquant: {
						quality: '65-90',
						speed: 4
					},
					gifsicle: {
						interlaced: false
					}
				}
			}]
		},
		{
			test: /\.(mp4|webm|ogg|mp3|wav|flac|aac|ogv)(\?.*)?$/,
			use: [{
				loader: 'url-loader',
				options: {
					limit: 100000,
					name: '[name].[ext]',
					outputPath: 'videos/',
				}
			}]
		}
	]},
	plugins: [
		new MiniCssExtractPlugin({
			filename: production ? 'main.[chunkhash:8].css' : 'main.css'
		}),
		new CleanWebpackPlugin(['dist']),
		new CopyWebpackPlugin([
			{
				from: 'src/favicons',
				to: 'favicons'
			}
		]),
		new ManifestPlugin(),
		new SpriteLoaderPlugin({ plainSprite: true }),
		new WebpackNotifier(),
	],
	devtool: production ? false : 'source-map',
}
