/**
 * @author Turov Nikolay
 * @copyright Prezentit
 */

require('./modules/css/main');
require('./modules/css/edit-presentation.css');
require('./modules/css/presentation.css');

module.exports = ( function (pit) {

    pit.core         = require('./modules/core');
    pit.draw         = require('./modules/draw');
    pit.transport    = require('./modules/transport');
    pit.ajax         = require('./modules/js/ajax');
    pit.aside        = require('./modules/js/aside');
    pit.collapse     = require('./modules/js/collapse');
    pit.cookies      = require('./modules/js/cookies');
    pit.tabs         = require('./modules/js/tabs');
    pit.form         = require('./modules/js/form');
    pit.notification = require('./modules/js/notification');
    pit.present      = require('./modules/js/presentation');
    pit.editPresent  = require('./modules/js/edit-presentation');

    return pit;

})({});
