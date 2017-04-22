/**
 * Webpack configuration
 *
 * @author Khaydarov Murod <murod.haydarov@gmail.com>
 * @copyright Votepad Team 2017
 */
'use strict';

/** Globar configurations */
var path = require('path');
var configurationPath = __dirname + '/assets/frontend/config/';
var main = configurationPath + '/main.js';

var mainConfiguration = require(main);

/** Export configurations to bundler */
module.exports = [
        mainConfiguration
    ];