/**
 * @author Turov Nikolay
 * @copyright Prezentit
 */

require('./modules/css/main');
require('./modules/css/presentation');

module.exports = ( function (pit) {

    pit.core         = require('./modules/core');
    pit.cookies      = require('./modules/js/cookies');
    pit.notification = require('./modules/js/notification');
    pit.collapse     = require('./modules/js/collapse');
    pit.present      = require('./modules/js/presentation');

    return pit;

})({});
