let present = function (present) {

    let asideBtn        = null,
        instruction     = null,
        fullScreenEl    = null,
        slides          = null,
        slidesHash      = null,
        curSlide        = null,
        nextSlideBtn    = null,
        prevSlideBtn    = null,
        progressBar     = null,
        slideActionBtns = null,
        slideQuestion   = [];


    let prepare_ = function (options) {
        instruction     = document.getElementById('toggleInstruction');
        fullScreenEl    = document.getElementsByClassName('presentation')[0];
        slides          = document.getElementsByClassName('presentation__slide');
        slidesHash      = location.pathname.split('/')[3];
        nextSlideBtn    = document.getElementsByClassName('presentation__navigation-btn--right')[0];
        prevSlideBtn    = document.getElementsByClassName('presentation__navigation-btn--left')[0];
        progressBar     = document.getElementsByClassName('presentation__progress-bar')[0];
        slideActionBtns = document.getElementsByClassName('slide-question__action-btn');
        asideBtn        = document.getElementsByClassName('presentation__aside-open')[0];

        prepareSlides_(slides);
        prepareQuestions_(document.getElementsByClassName('slide-question__content'));

        if (asideBtn && ! options.aside) {
            asideBtn.remove()
        }

        if (nextSlideBtn && options.slideNavigation) {
            nextSlideBtn.addEventListener('click', present.toNextSlide);
        }

        if (prevSlideBtn && options.slideNavigation) {
            prevSlideBtn.addEventListener('click', present.toPrevSlide);
        }

        for (let i = 0; i < slideActionBtns.length; i++) {
            if (options.slideActions) {
                slideActionBtns[i].addEventListener('click', toggleSlideAction);
            } else {
                slideActionBtns[i].remove();
            }
        }

        if (options.keyboard) {
            document.addEventListener("keydown", keyDownFunction, false);
        }

    };

    /**
     * Toggle Image and Question Action
     */
    let toggleSlideAction = function () {
        let btn     = this,
            content = this.parentNode.parentNode.getElementsByClassName('slide-question__content')[0],
            img     = this.parentNode.parentNode.getElementsByClassName('slide-question__image')[0];

        btn.children[0].classList.toggle('slide-question__action-icon--open');
        btn.children[1].classList.toggle('hide');
        btn.children[2].classList.toggle('hide');
        img.classList.toggle('fade__in--up');
        img.classList.toggle('fade__out--down');
        content.classList.toggle('fade__in--up');
        content.classList.toggle('fade__out--down');
    };


    /**
     * Updating Question Slide
     * - bar height
     * - img position
     * - score position
     * @param element
     * @private
     */
    let updateQuestionScore = function (element) {

        element.maxScore = getMaxScore(element.question.children);

        for( let i = 0; i < element.answers.length; i++ ) {

            let answer = element.answers[i],
                answerHeight = element.answers[0].el.clientHeight;

            answer.img.height = parseFloat(answer.img.el.clientWidth / (answerHeight / 65));

            let imgHeight = (answer.img.el.getAttribute('src') === '') ? 0 : answer.img.height,
                barHeight = parseFloat(40 * answer.score.score / element.maxScore - imgHeight / 2);

            if (answer.img.el.getAttribute('src') === '') {
                // no image
                answer.score.bottom = 13 + barHeight;
                answer.img.el.classList.add('hide');
                answer.bar.height = barHeight;
            } else {
                //with image
                answer.bar.height = barHeight > 0 ? barHeight : 0;
                answer.img.bottom = barHeight > 0 ? 12 + barHeight : 12;
                answer.score.bottom = answer.img.bottom + imgHeight;
            }

            answer.bar.el.style.height = answer.bar.height + "vh";
            answer.img.el.style.bottom = answer.img.bottom + "vh";
            answer.score.el.style.bottom = answer.score.bottom + "vh";
        }
    };


    /**
     * Get Max Score For Group of Answers
     * @param answers
     * @returns {number}
     */
    let getMaxScore = function (answers) {
        let maxScore = 0;

        for (let j = 0; j < answers.length; j++) {
            let tempScore = parseInt(answers[j].getElementsByClassName('slide-question__option-score')[0].innerHTML);
            maxScore = maxScore < tempScore ? tempScore : maxScore;
        }
        return maxScore
    };

    /**
     * Prepare Question on Slide
     * - field slideQuestion array
     * @param questions
     * @private
     */
    let prepareQuestions_ = function (questions) {

        for (let i = 0; i < questions.length; i++) {
            let question = [],
                answers = questions[i].children,
                answersArr = [],
                maxScore = getMaxScore(answers);

            for (let j = 0; j < answers.length; j++) {

                let tempAnswer = {
                    el: answers[j],
                    score: {
                        el: answers[j].getElementsByClassName('slide-question__option-score')[0],
                        score: parseInt(answers[j].getElementsByClassName('slide-question__option-score')[0].innerHTML),
                        bottom: 0
                    },
                    img: {
                        el: answers[j].getElementsByClassName('slide-question__option-image')[0],
                        height: parseFloat(answers[j].getElementsByClassName('slide-question__option-image')[0].clientWidth),
                        bottom: 0

                    },
                    bar: {
                        el: answers[j].getElementsByClassName('slide-question__option-bar')[0],
                        height: parseFloat(answers[j].getElementsByClassName('slide-question__option-bar')[0].clientHeight)
                    }
                };
                answersArr.push(tempAnswer);
            }
            question = {
                question: questions[i],
                maxScore: maxScore,
                answers: answersArr
            };
            slideQuestion.push(question);
            updateQuestionScore(question);

            window.matchMedia("(max-width: 992px)").addListener(function() {
                updateQuestionScore(question);
            });

        }
    };

    /**
     * Prepare Slides
     * - select current slide from Cookie if exist
     * @param slides
     * @private
     */
    let prepareSlides_ = function (slides) {
        if (pit.cookies.get('cur_slide') && pit.cookies.get('cur_slide').match(new RegExp(slidesHash))) {
            curSlide = parseInt(pit.cookies.get('cur_slide').replace(location.pathname.split('/')[3], ''));
        } else {
            curSlide = 0;
        }
        switchSlides();
    };

    /**
     * Switch to Next Slide
     * @private
     */
    present.toNextSlide = function () {
        if (curSlide < slides.length - 1) {
            curSlide++;
            switchSlides();
            pit.core.log("Switch to the next slide",'log','presentation');
        }
    };

    /**
     * Switch to Previous Slide
     * @private
     */
    present.toPrevSlide = function () {
        if (curSlide > 0) {
            curSlide--;
            switchSlides();
            pit.core.log("Switch to the previous slide",'log','presentation');
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
            value: 'presentation~' + location.pathname.split('/')[3] + curSlide,
            expires: 21600,
            path: '/'
        });

        for (let i = 0; i < slides.length; i++) {
            if (i < curSlide) {
                slides[i].classList.remove('presentation__slide--active', 'presentation__slide--after');
                slides[i].classList.add('presentation__slide--before', 'presentation__slide--inactive');
                continue;
            }
            if (i > curSlide) {
                slides[i].classList.remove('presentation__slide--active', 'presentation__slide--before');
                slides[i].classList.add('presentation__slide--after', 'presentation__slide--inactive');
            }
        }

        slides[curSlide].classList.remove('presentation__slide--after', 'presentation__slide--before', 'presentation__slide--inactive');
        slides[curSlide].classList.add('presentation__slide--active');

        progressBar.style.width = parseInt(curSlide/(slides.length-1) * 100) + "%";

        if (curSlide === 0) {
            prevSlideBtn.classList.add('hide')
        } else {
            prevSlideBtn.classList.remove('hide')
        }

        if (curSlide === slides.length - 1) {
            nextSlideBtn.classList.add('hide')
        } else {
            nextSlideBtn.classList.remove('hide')
        }
    };


    /**
     * Full Screen
     */
    present.toggleFullScreen = function () {
        if (fullScreenEl) {
            if (fullScreenEl.dataset.fullscreen === "true") {
                fullScreenEl.dataset.fullscreen = false;
                cancelFullScreen();
                pit.core.log("Close Full Screen",'log','presentation');
            } else {
                fullScreenEl.dataset.fullscreen = true;
                launchFullScreen(fullScreenEl);
                pit.core.log("Open Full Screen",'log','presentation');
            }
        } else {
            pit.core.log("Full screen button doesn't exist",'error','presentation');
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
                pit.core.log("Open instructions",'log','presentation');

            } else {
                pit.core.log("Close instructions",'log','presentation');
                instruction.click();
            }

        } else {
            pit.core.log("Instructions doesn't exist",'error','presentation');
        }
    };

    /**
     * Key Down Navigation
     * @param e
     */
    let keyDownFunction = function (e) {
        let keyCode = e.keyCode;

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
    };


    present.init = function (options) {

        prepare_(options);

        setTimeout(function () {
            document.getElementsByClassName('presentation__loader')[0].remove();
            pit.core.log("Module loaded",'log','presentation');
        }, 600);

    };

    return present;

}({});