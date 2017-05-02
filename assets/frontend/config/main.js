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
const libJS         = "prezentit.bundle.js";
const libCSS        = "prezentit.bundle.css";

const modulePath    = path.resolve(__dirname, "../modules/");
const bundlePath    = path.resolve(__dirname, "../bundles/");
const entryFile     = path.resolve(__dirname, "../prezentit.js");


module.exports = {

    entry: {
        "prezentit" : entryFile
    },

    output: {

        /** Public output path */
        path : bundlePath,

        /** bundle name */
        filename: libJS,

        /** Lib name */
        library: "pit"
    },

    watch: true,

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
                //drop_console: true
            }
        }),

        /** Вырезает CSS из JS сборки в отдельный файл */
        new ExtractTextPlugin(libCSS),

        /** Минифицируем CSS */
        new OptimizeCssPlugin({
            assetNameRegExp: libCSS,
            cssProcessor: require('cssnano'),
            cssProcessorOptions: {
                discardComments: {
                    removeAll: true
                }
            }
        })

    ]

};
