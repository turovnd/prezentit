/**
 * Webpack configuration
 *
 * @author Turov Nikolay
 * @copyright Prezentit Team 2017
 */
'use strict';

/**
 * Plugins for bundle
 * @type {webpack}
 */
var webpack                     = require('webpack');

/** Environment requirements */
const NODE_ENV = process.env.NODE_ENV || 'development';

var path = require('path');

var modulePath = path.resolve(__dirname, "../modules/");
var bundlePath = path.resolve(__dirname, "../bundles/");
var entryFile  = path.resolve(__dirname, "../prezentit.js");

var config = {

    entry: {
        "prezentit" : entryFile
    },

    output: {

        /** Public output path */
        path : bundlePath,

        /** bundle name */
        filename: "[name].bundle.js",

        /** Lib name */
        library: "pit"
    },

    watch: false,

    watchOptions: {
        aggregateTimeOut: 50
    },

    devtool: NODE_ENV == 'development' ? "source-map" : null,

    module : {

        // rules for modules
        rules : [
            {
                test: /\.js?$/,
                loader: 'eslint-loader',
                exclude: /node_modules/,
                options : {
                    fix:true
                }
            }

            // {
            //     test : /\.js$/,
            //     include: [
            //         modulePath
            //     ],
            //     loader: "babel",
            //     options: {
            //         presets: ['node_modules', __dirname + 'node_modules/babel-preset-es2015', nodeModules + "/babel-preset-es2015", 'babili']
            //     }
            //
            // }
        ]

    },

    resolve : {

        modules : ["node_modules", "*-loader", "*"],
        extensions : [".js"]

    },

    resolveLoader : {

        modules: ["web_loaders", "web_modules", "node_loaders", "node_modules"],
        moduleExtensions: ['*-loader']

    },

    plugins : [
        new webpack.optimize.UglifyJsPlugin({
            compress: {
                warnings: false,
                drop_console: false
            }
        })
    ]

};

module.exports = config;
