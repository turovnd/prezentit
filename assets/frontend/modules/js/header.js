var header = (function(header) {

    header.types = [];

    var type_ = null, // current type of header
        pathname_ = null,
        headerBlock_ = null,
        headerMenuIcon_ = null,
        asside_ = null,
        backdrop_ = null;


    /**
     * Prepare types for using
     * @private
     */
    var prepare_ = function () {
        pathname_ = window.location.pathname;
        headerBlock_ = document.getElementsByClassName('header')[0];

        headerMenuIcon_ = document.getElementById('openAsside');
        headerMenuIcon_.addEventListener('click', openMobileMenu, false);

        asside_ = document.getElementsByClassName('asside')[0];

        backdrop_ = document.getElementsByClassName('backdrop')[0];
        backdrop_.addEventListener('click', closeMobileMenu, false);

    };


    /**
     * Init header by type
     * @param type = welcome || app
     */
    header.init = function (type) {
        prepare_();
        type_ = type;
        changeHeaderBlockClass();
    };
    



    /**
     * Window On Resize Function
     */
    window.onresize = function(event) {
        if ( window.innerWidth > 768 ) {
            closeMobileMenu();
        }
    };


    /**
     * Window On Scroll Function
     */
    window.onscroll = function () {
        if (type_ !== "app" && pathname_ !== '/login' && pathname_ !== '/signup') {
            changeHeaderBlockClass();
        }
    };

    /**
     * 
     */
    var changeHeaderBlockClass = function () {
        if (type_ !== "app" && pathname_ !== '/login' && pathname_ !== '/signup') {
            if ( window.scrollY > 5 ) {
                headerBlock_.classList.add('header--fixed');
                headerBlock_.classList.remove('header--default');
            } else {
                headerBlock_.classList.remove('header--fixed');
                headerBlock_.classList.add('header--default');
            }
        } else {
            headerBlock_.classList.add('header--fixed');
        }
    };


    /**
     * openMobileMenu - open mobile menu on click
     */
    var openMobileMenu = function () {
        if ( ! headerMenuIcon_.classList.contains('asside__open-btn--opened')) {
            headerMenuIcon_.classList.add('asside__open-btn--opened');
            asside_.classList.add('asside--opened');
            backdrop_.classList.remove('hide');
            document.body.classList.add('overflow--hidden');
        } else {
            closeMobileMenu();
        }
    };


    /**
     * closeMobileMenu - close mobile menu on click
     */
    var closeMobileMenu = function() {
        headerMenuIcon_.classList.remove('asside__open-btn--opened');
        asside_.classList.remove('asside--opened');
        backdrop_.classList.add('hide');
        document.body.classList.remove('overflow--hidden');
    };



    return header;


})({});