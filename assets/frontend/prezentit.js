/**
 * Entry point of Prezentit scripts
 *
 * @description Contains of separate modules
 *
 * @author Turov Nikolay
 * @copyright Prezentit Team 2017
 */

require('./modules/css/main');

module.exports = ( function (pit) {

    pit.core         = require('./modules/core');
    pit.draw         = require('./modules/draw');
    pit.transport    = require('./modules/transport');
    pit.ajax         = require('./modules/js/ajax');
    pit.aside        = require('./modules/js/aside');
    pit.parallax     = require('./modules/js/parallax');
    pit.header       = require('./modules/js/header');
    pit.collapse     = require('./modules/js/collapse');
    pit.cookies      = require('./modules/js/cookies');
    pit.tabs         = require('./modules/js/tabs');
    pit.form         = require('./modules/js/form');
    pit.notification = require('./modules/js/notification');

    return pit;

})({});
