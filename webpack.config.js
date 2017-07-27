const webpack = require('webpack');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const path = require('path');

const config = {
    context: path.resolve(__dirname, 'src/Assets'),
    entry: ['./js/main.js', './sass/main.scss'],
    output: {
        path: path.resolve(__dirname, 'public/assets/js/'),
        filename: 'scripts.min.js'
    },
    module: {
        rules: [{
            test: /\.js$/,
            include: path.resolve(__dirname, 'src/js'),
            use: [{
                loader: 'babel-loader',
            }]
        }, {
            test: /\.scss$/,
            loader: ExtractTextPlugin.extract(['css-loader', 'sass-loader']),
        },
        ]
    },
    plugins: [
        new ExtractTextPlugin("../css/styles.min.css"),
        new webpack.ProvidePlugin({
            $: "jquery",
            jQuery: "jquery"
        })
    ]
};

module.exports = config;