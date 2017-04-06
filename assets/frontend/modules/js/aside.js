var aside = (function(aside) {

    aside.types = [];

    var asideMenuIcon_      = null,
        aside_              = null,
        backdrop_           = null,
        asideLinks          = null,
        asideCollapseLinks  = null,
        address = window.location.pathname.split('/'),
        address2 = '/' + address[1] + '/' + address[2],
        btnHref, i;


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

        asideLinks = document.getElementsByClassName('aside__link');
        asideCollapseLinks = document.getElementsByClassName('aside__collapse-link');

        setActiveLink();

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


    /**
     * Set active class to aside link
     */
    var setActiveLink = function () {
        
        for (i = 0; i < asideLinks.length; i++) {
            if (asideLinks[i].href) {
                btnHref = asideLinks[i].getAttribute('href').split('/');
                btnHref = new RegExp(btnHref[1] + '/' + btnHref[2]);
                if (btnHref.test(address2)) {
                    asideLinks[i].parentNode.classList.add('aside__item--active');
                    asideLinks[i].classList.add('aside__link--active');
                }
            }
        }

        for (i = 0; i < asideCollapseLinks.length; i++) {
            if (asideCollapseLinks[i].href) {
                btnHref = asideCollapseLinks[i].getAttribute('href').split('/');
                btnHref = new RegExp(btnHref[1] + '/' + btnHref[2]);
                if (btnHref.test(address2)) {
                    asideCollapseLinks[i].parentNode.parentNode.parentNode.classList.add('aside__item--active--active');
                    asideCollapseLinks[i].classList.add('aside__collapse-link--active');
                }
            }
        }
        
    };



    return aside;


})({});