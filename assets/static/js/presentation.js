let present = function (present) {

    let instruction     = null,
        fullScreenEl    = null,
        slides          = null,
        slidesHash      = null,
        curSlide        = null,
        nextSlideBtn    = null,
        prevSlideBtn    = null;


    let prepare_ = function () {
        instruction     = document.getElementById('toggleInstruction');
        fullScreenEl    = document.getElementsByClassName('presentation')[0];
        slides          = document.getElementsByClassName('presentation__slide');
        slidesHash      = location.pathname;
        nextSlideBtn    = document.getElementsByClassName('presentation__navigation-btn--right')[0];
        prevSlideBtn    = document.getElementsByClassName('presentation__navigation-btn--left')[0];

        if (nextSlideBtn) {
            nextSlideBtn.addEventListener('click', toNextSlide);
        }
        if (prevSlideBtn) {
            prevSlideBtn.addEventListener('click', toPrevSlide);
        }
        prepareSlides_(slides);

        document.addEventListener("keydown", keyDownFunction, false);

    };


    /**
     * Prepare Slides
     * - select current slide from Cookie if exist
     * @param slides
     * @private
     */
    let prepareSlides_ = function (slides) {
        if (pit.cookies.get('cur_slide') && pit.cookies.get('cur_slide').match(new RegExp(slidesHash))) {
            curSlide = parseInt(pit.cookies.get('cur_slide').replace(location.pathname, ''));
        } else {
            curSlide = 0;
        }

        switchSlides()
    };

    /**
     * Switch to Next Slide
     * @private
     */
    let toNextSlide = function () {
        if (curSlide < slides.length - 1) {
            curSlide++;
            switchSlides()
        }
    };

    /**
     * Switch to Previous Slide
     * @private
     */
    let toPrevSlide = function () {
        if (curSlide > 0) {
            curSlide--;
            switchSlides()
        }
    };


    /**
     * Switch slides
     * - include updating current slide in Cookie
     * @private
     */
    let switchSlides = function () {

        pit.cookies.set({
            name: 'cur_slide',
            value: location.pathname + "~" + location.pathname + curSlide,
            expires: 21600,
            path: '/'
        });

        for (let i = 0; i < slides.length; i++) {
            if (i < curSlide) {
                slides[i].classList.remove('presentation__slide--active', 'presentation__slide--after');
                slides[i].classList.add('presentation__slide--before');
                continue;
            }
            if (i > curSlide) {
                slides[i].classList.remove('presentation__slide--active', 'presentation__slide--before');
                slides[i].classList.add('presentation__slide--after');
            }
        }

        slides[curSlide].classList.remove('presentation__slide--after', 'presentation__slide--before');
        slides[curSlide].classList.add('presentation__slide--active');
    };


    /**
     * Full Screen
     */
    present.toggleFullScreen = function () {
        if (fullScreenEl) {
            if (fullScreenEl.dataset.fullscreen === "true") {
                fullScreenEl.dataset.fullscreen = false;
                cancelFullScreen()
            } else {
                fullScreenEl.dataset.fullscreen = true;
                launchFullScreen(fullScreenEl)
            }
        } else {
            console.log("Error: full screen button doesn't exist");
        }
    };

    /**
     * Launch Full Screen On Click
     * @param element
     * @private
     */
    let launchFullScreen = function (element) {
        if (element.requestFullScreen) {
            element.requestFullScreen();
        } else if (element.mozRequestFullScreen) {
            element.mozRequestFullScreen();
        } else if (element.webkitRequestFullScreen) {
            element.webkitRequestFullScreen();
        }
    };

    /**
     * Close Full Screen On Click
     * @private
     */
    let cancelFullScreen = function () {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    };


    /**
     * Toggle Instruction on Page
     */
    present.toggleInstruction = function () {
        if (instruction) {

            if (instruction.dataset.opened === "false") {
                instruction.classList.toggle('hide');

                if (!instruction.classList.contains('hide')) {
                    instruction.children[1].removeAttribute('data-height');
                    instruction.click();
                }

            } else {
                instruction.click();
            }

        } else {
            console.log("Error: instruction doesn't exist");
        }
    };

    /**
     * Key Down Navigation
     * @param e
     */
    let keyDownFunction = function (e) {
        let keyCode = e.keyCode;

        if (keyCode === 39 || keyCode === 32) {
            toNextSlide();
            return;
        }
        if (keyCode === 37) {
            toPrevSlide();
            return;
        }
        if (keyCode === 81) {
            /**
             * TODO: hide||show Keyboard shortcuts
             */
            return;
        }
        if (keyCode === 73) {
            present.toggleInstruction();
            return;
        }
        if (keyCode === 72) {
            /**
             * TODO: hide||show results
             */
            return;
        }
        if (keyCode === 70) {
            present.toggleFullScreen();
            return;
        }
        if (keyCode === 67) {
            /**
             * TODO: open||close voting
             */
        }
    };


    present.init = function () {
        prepare_();
    };

    return present;

}({});