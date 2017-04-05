var aside = (function(aside) {

    aside.types = [];

    var asideMenuIcon_ = null,
        aside_ = null,
        backdrop_ = null;


    /**
     * Prepare aside
     * @private
     */
    var prepare_ = function () {
        
        asideMenuIcon_ = document.getElementById('openAside');
        asideMenuIcon_.addEventListener('click', openMobileMenu, false);

        aside_ = document.getElementsByClassName('aside')[0];

        backdrop_ = document.getElementsByClassName('backdrop')[0];
        backdrop_.addEventListener('click', closeMobileMenu, false);

    };


    /**
     * Initialize aside
     */
    aside.init = function () {

        prepare_();

        /**
         * Window On Resize Function
         */
        window.onresize = function(event) {
            if ( window.innerWidth > 768 ) {
                closeMobileMenu();
            }
        };

    };



    /**
     * openMobileMenu - open mobile menu on click
     */
    var openMobileMenu = function () {
        if ( ! asideMenuIcon_.classList.contains('aside__open-btn--opened')) {
            asideMenuIcon_.classList.add('aside__open-btn--opened');
            aside_.classList.add('aside--opened');
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
        asideMenuIcon_.classList.remove('aside__open-btn--opened');
        aside_.classList.remove('aside--opened');
        backdrop_.classList.add('hide');
        document.body.classList.remove('overflow--hidden');
    };



    return aside;


})({});