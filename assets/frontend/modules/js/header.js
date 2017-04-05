var header = (function(header) {

    header.types = [];

    var headerBlock_ = null,
        pathname_ = null,
        pathneme_headerFeixed = ['/login', '/signup'];


    /**
     * Init header by type
     * @param type = welcome || app
     */
    header.init = function (type) {

        headerBlock_ = document.getElementsByClassName('header')[0];
        pathname_ = window.location.pathname;

        if (type === "welcome" && pathneme_headerFeixed.indexOf(pathname_) === -1) {

            window.onscroll = function () {
                changeHeaderBlockClass();
            };

        } else {

            headerBlock_.classList.remove('header--default');
            headerBlock_.classList.add('header--fixed');

        }

    };



    /**
     * chane header class in Welcome module
     */
    var changeHeaderBlockClass = function () {
        if ( window.scrollY > 5 ) {
            headerBlock_.classList.add('header--fixed');
            headerBlock_.classList.remove('header--default');
        } else {
            headerBlock_.classList.remove('header--fixed');
            headerBlock_.classList.add('header--default');
        }
    };


    return header;


})({});