/**
 * @author Turov Nikolay
 * @copyright Prezentit
 */

require('./modules/css/edit-presentation.css');

module.exports = ( function (editPresent) {

    editPresent.plagin = require('./modules/js/edit-presentation');

    return editPresent;

})({});
