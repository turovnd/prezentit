module.exports = (function (parallax) {


    var parallaxArray_ = null;


    parallax.init = function () {

        parallaxArray_ = document.querySelectorAll('[data-toggle="parallax"]');

        if (parallaxArray_.length > 0) {

            for (var i =0; i < parallaxArray_.length; i++) {

                new parallaxFun(parallaxArray_[i]);

            }

        }

    };


    /**
     * Create parallax
     * @param el
     */
    var parallaxFun = function (el) {

        this.el = el;
        this.img = el.getElementsByClassName('parallax__img')[0];

        // element options
        this.elTop = 0;
        this.elBottom = 0;
        this.elHeight = 0;
        this.imgHeight = 0;
        this.scrollDist = 0;
        this.scrollPercent = 0;
        this.positionY = 0;

        // Callbacks
        this.action = this.action.bind(this);
        this.action = this.action.bind(this);

        // Initialise
        this.initialise();

    };


    /** window */
    parallaxFun.prototype.winWidth = null;
    parallaxFun.prototype.winHeight = null;
    parallaxFun.prototype.winTop = null;
    parallaxFun.prototype.winBottom = null;


    parallaxFun.prototype.initialise = function () {

        this.img.classList.add('show');
        this.updateDimensions();
        this.updateBounds();

        window.addEventListener('scroll', this.action);
        window.addEventListener('resize', this.action);

    };


    parallaxFun.prototype.action = function () {

        this.updateDimensions();
        this.updateBounds();

    };


    parallaxFun.prototype.updateDimensions = function () {

        this.winWidth = window.innerWidth;
        this.winHeight = window.innerHeight;
        this.winTop = window.scrollY;
        this.winBottom = this.winTop + this.winHeight;

    };


    parallaxFun.prototype.updateBounds = function () {

        this.elHeight = this.el.clientHeight;
        this.imgHeight = this.img.clientHeight;

        if ( this.winWidth < 768) {

            this.elHeight = (this.elHeight > 0) ? this.elHeight : this.imgHeight;

        } else {

            this.elHeight  = (this.elHeight > 0) ? this.elHeight : 500;

        }

        this.elTop = this.el.offsetTop;
        this.elBottom = this.elTop + this.elHeight;


        this.scrollDist = this.imgHeight - this.elHeight;
        this.scrollPercent = (this.winBottom - this.elTop) / (this.elHeight + this.winHeight);
        this.positionY = Math.round((this.scrollDist * this.scrollPercent));

        this.setPosition(this.positionY);

    };


    parallaxFun.prototype.setPosition = function (posY) {

        this.img.style = 'transform: translate3d(-50%,' + posY + 'px ,0)';

    };


    return parallax;


})({});