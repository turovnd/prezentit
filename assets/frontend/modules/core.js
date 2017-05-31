module.exports = (function (core) {

    /**
     * Logging method
     * @param msg   - string
     * @param type  - ['log', 'info', 'warn']
     * @param prefix
     * @param arg
     */

    core.log = function (msg, type, prefix, arg) {

        var staticLength = 25;

        prefix = prefix === undefined ? '[prezentit]:' : '[' + prefix + ']:';

        prefix = prefix.length < staticLength ? prefix : prefix.substr( 0, staticLength - 3 );

        while (prefix.length < staticLength - 1) {

            prefix += ' ';

        }

        type = type || 'log';

        if (!arg) {

            arg  = msg || 'undefined';
            msg = prefix + '%o';

        } else {

            msg = prefix + msg;

        }


        try{

            if ( 'console' in window && window.console[ type ] ) {

                if ( arg ) window.console[ type ]( msg, arg );
                else window.console[ type ]( msg );

            }

        }catch(e) {}

    };


    /**
     * Helper for insert one element before another
     * @param target
     * @param element
     */
    core.insertBefore = function (target, element) {

        target.parentNode.insertBefore(element, target);

    };



    /**
     * Helper for insert one element after another
     * @param target
     * @param element
     */
    core.insertAfter = function (target, element) {

        target.parentNode.insertBefore(element, target.nextSibling);

    };


    /**
     * Replaces node with
     * @param {Element} nodeToReplace
     * @param {Element} replaceWith
     */
    core.replace = function (nodeToReplace, replaceWith) {

        return nodeToReplace.parentNode.replaceChild(replaceWith, nodeToReplace);

    };


    /**
     * @const
     * Readable keys map
     */
    core.keys = { BACKSPACE: 8, TAB: 9, ENTER: 13, SHIFT: 16, CTRL: 17, ALT: 18, ESC: 27, SPACE: 32,
        LEFT: 37, UP: 38, DOWN: 40, RIGHT: 39, DELETE: 46, META: 91, Q: 81, I: 73, H: 72, F: 70, C: 67, E: 69, P: 80 };



    return core;


})({});