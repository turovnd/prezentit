/**
 * @author Turov Nikolay
 * @copyright Prezentit
 */

require('./modules/css/main');

module.exports = ( function (pit) {

    pit.core         = require('./modules/core');
    pit.draw         = require('./modules/draw');
    pit.transport    = require('./modules/transport');
    pit.ajax         = require('./modules/js/ajax');
    pit.cookies      = require('./modules/js/cookies');
    pit.modal        = require('./modules/js/modal');
    pit.form         = require('./modules/js/form');
    pit.notification = require('./modules/js/notification');

    var aside        = require('./modules/js/aside'),
        parallax     = require('./modules/js/parallax'),
        header       = require('./modules/js/header'),
        collapse     = require('./modules/js/collapse');

    var init_ = function () {
        header.init('app');
        aside.init();
        collapse.init();
        parallax.init();
        pit.modal.init();
        pit.notification.createHolder();
    };

    document.addEventListener("DOMContentLoaded", init_);

    return pit;

})({});
