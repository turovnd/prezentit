var present = function (present) {

    var instruction     = null,
        fullScreenEl    = null;


    var prepare_ = function () {
        instruction     = document.getElementById('toggleInstruction');
        fullScreenEl    = document.getElementsByClassName('presentation')[0];
    };


    /**
     * Full Screen
     */
    present.toggleFullScreen = function () {
        if (fullScreenEl) {
            if( fullScreenEl.dataset.fullscreen == "true" ) {
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

    var launchFullScreen = function (element) {
        if(element.requestFullScreen) {
            element.requestFullScreen();
        } else if(element.mozRequestFullScreen) {
            element.mozRequestFullScreen();
        } else if(element.webkitRequestFullScreen) {
            element.webkitRequestFullScreen();
        }
    };

    var cancelFullScreen = function () {
        if(document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if(document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if(document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    };



    /**
     * Toggle Instruction on Page
     */
    present.toggleInstruction = function () {
        if (instruction) {

            if(instruction.dataset.opened == "false") {
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

    present.init = function () {
        prepare_();
    };

    return present;

}({});