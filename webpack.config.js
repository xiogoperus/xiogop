﻿
var path = require('path');
const ExtractTextPlugin = require("extract-text-webpack-plugin");

module.exports = {
    entry: "./less/main.less",
    node: {
        fs: 'empty',
        net: 'empty'
    },
    output: {
        path: __dirname + "/public",
        filename: "bundle.js"
    },
    module: {
        rules: [{
                test: /\.less$/,
                use: ExtractTextPlugin.extract({
                    fallback: "style-loader",
                    use: ["css-loader", "less-loader"]
                })
            },
            {
                test: /\.(png|jpg|jpeg|svg|gif)$/,
                include: [
                    path.resolve(__dirname, './img/')
                ],
                use: [{
                    loader: 'file-loader',
                    options: {
                        name: './public/img/[hash].[ext]',
                    }
                }]
            },
            {
                test: /\.(ttf|eot|woff|woff2|png|jpg|jpeg|svg|gif)$/,
                loader: 'url-loader'
            },
        ]
    },
    plugins: [
        new ExtractTextPlugin({
            filename: './css/main.css'
        })
    ]
};