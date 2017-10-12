/**
 * @author Turov Nikolay
 * @copyright Prezentit
 */

require('./modules/css/presentation');

module.exports = ( function (present) {

    present.plagin      = require('./modules/js/presentation');

    return present;

})({});
