let present = function (present) {

    let instruction     = null,
        fullScreenEl    = null,
        slides          = null,
        slidesHash      = null,
        curSlide        = null,
        nextSlideBtn    = null,
        prevSlideBtn    = null,
        progressBar     = null,
        slideQuestion   = [];


    let prepare_ = function () {
        instruction     = document.getElementById('toggleInstruction');
        fullScreenEl    = document.getElementsByClassName('presentation')[0];
        slides          = document.getElementsByClassName('presentation__slide');
        slidesHash      = location.pathname;
        nextSlideBtn    = document.getElementsByClassName('presentation__navigation-btn--right')[0];
        prevSlideBtn    = document.getElementsByClassName('presentation__navigation-btn--left')[0];
        progressBar     = document.getElementsByClassName('presentation__progress-bar')[0];

        if (nextSlideBtn) {
            nextSlideBtn.addEventListener('click', toNextSlide);
        }
        if (prevSlideBtn) {
            prevSlideBtn.addEventListener('click', toPrevSlide);
        }
        prepareSlides_(slides);
        prepareQuestions_(document.getElementsByClassName('slide-question__content'));

        document.addEventListener("keydown", keyDownFunction, false);

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
                answerHeight = element.answers[0].el.clientHeight,
                imgHeight = (answer.img.el.getAttribute('src') === '') ? 0 : answer.img.height,
                barHeight = parseFloat(40 * answer.score.score / element.maxScore - imgHeight / 2);

            answer.img.height = parseFloat(answer.img.el.clientWidth / (answerHeight / 65));

            if (answer.img.el.getAttribute('src') === '') {
                // no image
                answer.score.bottom = 13 + barHeight;
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

        element.question.classList.remove('invisible');
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