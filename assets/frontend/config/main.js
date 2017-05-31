/**
 * Webpack configuration
 *
 * @author Turov Nikolay
 * @copyright Prezentit Team 2017
 */
'use strict';

/**
 * Plugins for bundle
 */
const webpack             = require('webpack');
const ExtractTextPlugin   = require("extract-text-webpack-plugin");
const OptimizeCssPlugin   = require('optimize-css-assets-webpack-plugin');

const path          = require('path');
const libJS         = "[name].min.css";
const libCSS        = "[name].min.css";

const modulePath    = path.resolve(__dirname, "../modules/");
const bundlePath    = path.resolve(__dirname, "../bundles/");

module.exports = {

    entry: {
        "pit"           : path.resolve(__dirname, "../pit.js"),
        "present"       : path.resolve(__dirname, "../present.js"),
        "edit-present"  : path.resolve(__dirname, "../edit-present.js"),
    },

    output: {
        path : bundlePath,
        filename: libJS,
        library: "pit"
    },

    watch: false,

    watchOptions: {
        aggregateTimeOut: 50
    },

    module : {

        // rules for modules
        rules : [
            {
                test: /\.js?$/,
                loader: 'eslint-loader',
                include: modulePath,
                exclude: /node_modules/,
                options : {
                    fix: true
                }
            },
            {
                test: /\.css$/,
                use: ExtractTextPlugin.extract({
                    fallback: "style-loader",
                    use: [ "css-loader" ]
                }),
                include: modulePath,
                exclude: /node_modules/
            }
        ]

    },

    resolve : {
        modules : ["node_modules", "*-loader", "*"],
        extensions : [".js", ".css"]
    },

    plugins : [
        /** Минифицируем JS */
        new webpack.optimize.UglifyJsPlugin({
            compress: {
                warnings: false,
                drop_console: true
            }
        }),

        /** Вырезает CSS из JS сборки в отдельный файл */
        new ExtractTextPlugin(libCSS),

        /** Минифицируем CSS */
        new OptimizeCssPlugin({
            cssProcessor: require('cssnano'),
            cssProcessorOptions: {
                discardComments: {
                    removeAll: true
                }
            }
        })

    ]

};
