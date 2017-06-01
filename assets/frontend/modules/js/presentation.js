module.exports = function (present) {

    var asideBtn            = null,
        instruction         = null,
        fullScreenEl        = null,
        slides              = null,
        slidesHash          = null,
        curSlide            = null,
        nextSlideBtn        = null,
        prevSlideBtn        = null,
        progressBar         = null,
        slidesOrder         = null,
        choicesSlides       = null;


    function prepare_(options) {

        asideBtn         = document.getElementsByClassName('presentation__aside-open')[0];
        instruction      = document.getElementById('toggleInstruction');
        fullScreenEl     = document.getElementsByClassName('presentation')[0];
        slides           = document.getElementsByClassName('presentation__slide');
        slidesHash       = window.location.pathname.split('/')[3];
        nextSlideBtn     = document.getElementsByClassName('presentation__navigation-btn--right')[0];
        prevSlideBtn     = document.getElementsByClassName('presentation__navigation-btn--left')[0];
        progressBar      = document.getElementsByClassName('presentation__progress-bar')[0];
        slidesOrder      = JSON.parse(document.getElementById('slides_order').value);

        if (asideBtn && ! options.aside) {

            asideBtn.remove();
            document.getElementsByClassName('presentation__aside')[0].remove();

        } else {

            asideBtn.addEventListener('click', openAsideMenu_);

            var asideAdditionMenu = document.getElementsByClassName('presentation__aside-link');

            for (var i = 0; i < asideAdditionMenu.length; i++) {

                asideAdditionMenu[i].addEventListener('click', toggleAdditionAsideMenu_);

            }

            document.getElementsByClassName('presentation__slides')[0].addEventListener('click', closeAsideMenu_);

        }

        if (nextSlideBtn && options.slideNavigation) {

            nextSlideBtn.addEventListener('click', present.toNextSlide);

        } else {

            nextSlideBtn.remove();

        }

        if (prevSlideBtn && options.slideNavigation) {

            prevSlideBtn.addEventListener('click', present.toPrevSlide);

        } else {

            prevSlideBtn.remove();

        }

        if (options.toggleAnswers) {

            var toggleAnswerBtns = document.getElementsByClassName('slide-choices__action-btn');

            for (var i = 0; i < toggleAnswerBtns.length; i++) {

                toggleAnswerBtns[i].addEventListener('click', toggleAnswers_);

            }

        }

        if (options.keyboard) {

            document.addEventListener('keydown', keyDownFunction_);

        }

        // select current slide from cookie
        if (pit.cookies.get('cur_slide') && pit.cookies.get('cur_slide').match(new RegExp(slidesHash))) {

            curSlide = parseInt(pit.cookies.get('cur_slide').replace(window.location.pathname.split('/')[3], ''));

            if (!slidesOrder.indexOf(curSlide))
                curSlide = slidesOrder[0];

        } else {

            curSlide = slidesOrder[0];

        }

        switchSlides();

        prepareChoicesSlides_();

    }


    /**
     * Prepare Answers on Choices Slide
     * @private
     */
    function prepareChoicesSlides_() {

        choicesSlides = [];

        var choicesSl = document.getElementsByClassName('slide-choices');

        for (var i = 0; i < choicesSl.length; i++) {

            var slide       = [],
                answers     = choicesSl[i].getElementsByClassName('slide-choices__option-wrapper'),
                answer      = null,
                answersArr  = [],
                maxScore    = getMaxScore(answers),
                score, image, bar;

            for (var j = 0; j < answers.length; j++) {

                score = answers[j].getElementsByClassName('slide-choices__option-score')[0];
                image = answers[j].getElementsByClassName('slide-choices__option-image')[0];
                bar   = answers[j].getElementsByClassName('slide-choices__option-bar')[0];

                answer = {
                    wrapper: answers[j],
                    score: {
                        wrapper: score,
                        score: parseInt(score.innerHTML),
                        bottom: parseInt(0)
                    },
                    img: {
                        wrapper: image,
                        height: image ? parseFloat(image.clientWidth) : 0,
                        bottom: 0
                    },
                    bar: {
                        wrapper: bar,
                        height: parseFloat(bar.clientHeight)
                    }
                };

                score.addEventListener('change', updateChoicesSlideScore_);

                answersArr.push(answer);

            }

            slide = {
                wrapper: choicesSl[i],
                maxScore: maxScore,
                answers: answersArr,
                inPercents: parseInt(choicesSl[i].getElementsByClassName('results-in-percents')[0].value)
            };

            choicesSlides.push(slide);
            updateChoicesSlideView_(slide);

            window.matchMedia('(max-width: 992px)').addListener(function () {

                updateChoicesSlideView_(slide);

            });

        }

    }


    /**
     * Update choices slide score by 'this' element
     * @private
     */
    function updateChoicesSlideScore_() {

        updateChoicesSlideView_(this.closest('.slide-choices__option-wrapper'));

    }


    /**
     * Toggle Image and Question Action
     */
    function toggleAnswers_() {

        var btn     = this,
            content = this.parentNode.parentNode.getElementsByClassName('slide-choices__content')[0],
            img     = this.parentNode.parentNode.getElementsByClassName('slide-choices__image')[0],
            icon    = this.getElementsByClassName('slide-choices__action-icon')[0],
            text    = this.getElementsByClassName('slide-choices__action-text')[0];

        icon.classList.toggle('slide-choices__action-icon--clicked');

        switch (btn.dataset.status) {
            case 'image':
                text.textContent = 'Показать результаты';
                img.classList.remove('hide', 'fade__in', 'fade__in--up');
                img.classList.add('fade__out--down');
                content.classList.remove('hide', 'fade__in', 'fade__out--down');
                content.classList.add('fade__in--up');
                btn.dataset.status = 'result';
                break;
            case 'result':
                text.textContent = 'Показать изображение';
                img.classList.remove('hide', 'fade__in', 'fade__out--down');
                img.classList.add('fade__in--up');
                content.classList.remove('hide', 'fade__in', 'fade__out--down');
                content.classList.add('fade__out--down');
                btn.dataset.status = 'image';
                break;
        }

        content.classList.toggle('fade__in--up', 'fade__out--down');

    }


    /**
     * Updating Question Slide
     * - bar height
     * - img position
     * - score position
     * @private
     * @param slide
     */
    function updateChoicesSlideView_(slide) {

        slide.maxScore = getMaxScore(slide.wrapper.getElementsByClassName('slide-choices__option-wrapper'));

        for( var i = 0; i < slide.answers.length; i++ ) {

            var answer = slide.answers[i],
                answerHeight = slide.answers[0].wrapper.clientHeight;

            answer.img.height = answer.img.wrapper !== undefined ? parseFloat(answer.img.wrapper.clientWidth / (answerHeight / 70)) : 0;

            var imgHeight = answer.img.wrapper !== undefined ? answer.img.height : 0,
                barHeight = answer.score.score === 0 ? 0 : parseFloat(48 * answer.score.score / slide.maxScore - imgHeight / 2);

            if (answer.img.wrapper === undefined) {

                // no image
                answer.score.bottom = 12 + barHeight;
                answer.bar.height = barHeight;

            } else {

                // with image
                answer.bar.height = barHeight > 0 ? barHeight : 0;
                answer.img.bottom = barHeight > 0 ? 12 + barHeight : 12;
                answer.score.bottom = answer.img.bottom + imgHeight;

            }

            answer.bar.wrapper.style.height = answer.bar.height + 'vh';
            answer.score.wrapper.style.bottom = answer.score.bottom + 'vh';
            answer.score.wrapper.textContent = slide.inPercents === 0 ? answer.score.score : parseInt(answer.score.score / getTotalScore(slide.wrapper.getElementsByClassName('slide-choices__option-wrapper')) * 100) + '%';

            if (answer.img.wrapper !== undefined )
                answer.img.wrapper.style.bottom = answer.img.bottom + 'vh';

        }

    }


    /**
     * Get Max Score For Choices Slide
     * @param answers
     * @returns {number}
     */
    function getMaxScore(answers) {

        var maxScore = 0, tempScore = 0;

        for (var j = 0; j < answers.length; j++) {

            tempScore = parseInt(answers[j].getElementsByClassName('slide-choices__option-score')[0].dataset.score);

            maxScore = maxScore < tempScore ? tempScore : maxScore;

        }
        maxScore =  maxScore === 0 ? 1 : maxScore;
        return maxScore;

    }


    /**
     * Get totol score for Choice slide
     * @param answers
     * @returns {number}
     */
    function getTotalScore(answers) {

        var totalScore = 0;

        for (var j = 0; j < answers.length; j++) {

            totalScore += parseInt(answers[j].getElementsByClassName('slide-choices__option-score')[0].dataset.score );

        }

        totalScore  =  totalScore === 0 ? 1 : totalScore ;

        return totalScore ;

    }


    /**
     * Add Score
     * @param slide - slide position in Array `choicesSlides`
     * @param answer - answer position in array `choicesSlides[slide].answers`
     */
    present.addScore = function (slide, answer) {

        choicesSlides[slide].answers[answer].score.score += 1;
        choicesSlides[slide].answers[answer].score.wrapper.dataset.score = choicesSlides[slide].answers[answer].score.score;

        updateChoicesSlideView_(choicesSlides[slide]);

    };


    /**
     * Open aside menu on mobile
     * @private
     */
    function openAsideMenu_() {

        this.classList.add('presentation__aside-open--opened');

    }

    /**
     * Toggle addition aside menu on mobile
     * @private
     */
    function toggleAdditionAsideMenu_() {

        this.classList.toggle('presentation__aside-link--opened');

    }


    /**
     * Close aside menu on mobile
     * @private
     */
    function closeAsideMenu_() {

        if ( asideBtn.classList.contains('presentation__aside-open--opened') )
            asideBtn.classList.remove('presentation__aside-open--opened');

    }


    /**
     * Switch to Next Slide
     * @private
     */
    present.toNextSlide = function () {

        if (slidesOrder.indexOf(curSlide) < slides.length - 1) {

            curSlide = slidesOrder[slidesOrder.indexOf(curSlide) + 1];
            switchSlides();
            pit.core.log('Switch to the next slide', 'log', 'presentation');

        }

    };

    /**
     * Switch to Previous Slide
     * @private
     */
    present.toPrevSlide = function () {

        if (slidesOrder.indexOf(curSlide) > 0) {

            curSlide = slidesOrder[slidesOrder.indexOf(curSlide) - 1];
            switchSlides();
            pit.core.log('Switch to the previous slide', 'log', 'presentation');

        }

    };


    /**
     * Switch slides
     * - include updating current slide in Cookie
     * @private
     */
    function switchSlides() {

        pit.cookies.set({
            name: 'cur_slide',
            value: 'presentation~' + window.location.pathname.split('/')[3] + curSlide,
            expires: 21600,
            path: '/'
        });

        for (var i = 0; i < slides.length; i++) {

            if (i < slidesOrder.indexOf(curSlide)) {

                slides[i].classList.remove('presentation__slide--active', 'presentation__slide--after');
                slides[i].classList.add('presentation__slide--before', 'presentation__slide--inactive');
                continue;

            }
            if (i > slidesOrder.indexOf(curSlide)) {

                slides[i].classList.remove('presentation__slide--active', 'presentation__slide--before');
                slides[i].classList.add('presentation__slide--after', 'presentation__slide--inactive');

            }

        }

        if (slidesOrder.indexOf(curSlide) !== -1) {

            slides[slidesOrder.indexOf(curSlide)].classList.remove('presentation__slide--after', 'presentation__slide--before', 'presentation__slide--inactive');
            slides[slidesOrder.indexOf(curSlide)].classList.add('presentation__slide--active');
            progressBar.style.width = parseInt(slidesOrder.indexOf(curSlide)/(slides.length-1) * 100) + '%';

        }

        if (slidesOrder.indexOf(curSlide) === 0) {

            prevSlideBtn.classList.add('hide');

        } else {

            prevSlideBtn.classList.remove('hide');

        }

        if (slidesOrder.indexOf(curSlide) === slides.length - 1) {

            nextSlideBtn.classList.add('hide');

        } else {

            nextSlideBtn.classList.remove('hide');

        }

    }


    /**
     * Full Screen
     */
    present.toggleFullScreen = function () {

        if (fullScreenEl) {

            if (fullScreenEl.dataset.fullscreen === 'true') {

                fullScreenEl.dataset.fullscreen = false;
                cancelFullScreen();

            } else {

                fullScreenEl.dataset.fullscreen = true;
                launchFullScreen(fullScreenEl);

            }

        } else {

            pit.core.log("Full screen button doesn't exist", 'error', 'presentation');

        }

    };

    /**
     * Launch Full Screen On Click
     * @param element
     * @private
     */
    function launchFullScreen(element) {

        if (element.requestFullScreen) {

            element.requestFullScreen();

        } else if (element.mozRequestFullScreen) {

            element.mozRequestFullScreen();

        } else if (element.webkitRequestFullScreen) {

            element.webkitRequestFullScreen();

        }

    }

    /**
     * Close Full Screen On Click
     * @private
     */
    function cancelFullScreen() {

        if (document.cancelFullScreen) {

            document.cancelFullScreen();

        } else if (document.mozCancelFullScreen) {

            document.mozCancelFullScreen();

        } else if (document.webkitCancelFullScreen) {

            document.webkitCancelFullScreen();

        }

    }


    /**
     * Toggle Instruction on Page
     */
    present.toggleInstruction = function () {

        if (instruction) {

            if (instruction.dataset.opened === 'false') {

                instruction.classList.toggle('hide');

                if (!instruction.classList.contains('hide')) {

                    instruction.children[1].removeAttribute('data-height');
                    instruction.click();

                }

            } else {

                instruction.click();

            }

        } else {

            pit.core.log("Instructions doesn't exist", 'error', 'presentation');

        }

    };


    /**
     * Key Down Navigation
     * @param e
     */
    function keyDownFunction_(e) {

        var keyCode = e.keyCode;

        if (keyCode === pit.core.keys.RIGHT || keyCode === pit.core.keys.SPACE) {

            present.toNextSlide();
            return;

        }
        if (keyCode === pit.core.keys.LEFT) {

            present.toPrevSlide();
            return;

        }
        if (keyCode === pit.core.keys.Q) {

            /**
             * TODO: hide||show Keyboard shortcuts
             */
            return;

        }
        if (keyCode === pit.core.keys.I) {

            present.toggleInstruction();
            return;

        }
        if (keyCode === pit.core.keys.H) {

            /**
             * TODO: hide||show results
             */
            return;

        }
        if (keyCode === pit.core.keys.F) {

            present.toggleFullScreen();
            return;

        }
        if (keyCode === pit.core.keys.C) {
            /**
             * TODO: open||close voting
             */
        }
        if (keyCode === pit.core.keys.E) {

            window.history.pushState('Presentation', window.location);
            window.location.replace(window.location + '/edit');

        }

    }


    present.init = function (options) {

        prepare_(options);

        pit.core.log('Module loaded', 'log', 'presentation');

    };

    return present;

}({});