/**
 * Entry point of Prezentit scripts
 *
 * @description Contains of separate modules
 *
 * @author Turov Nikolay
 * @copyright Prezentit Team 2017
 */

require('./modules/css/main');

module.exports = ( function (prezentit) {

    prezentit.ajax        = require('./modules/js/ajax');
    prezentit.aside       = require('./modules/js/aside');
    prezentit.parallax    = require('./modules/js/parallax');
    prezentit.header      = require('./modules/js/header');
    prezentit.collapse    = require('./modules/js/collapse');
    prezentit.cookies     = require('./modules/js/cookies');
    prezentit.tabs        = require('./modules/js/tabs');

    return prezentit;

})({});