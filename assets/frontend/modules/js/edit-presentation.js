let editPresent = function (editPresent) {

    let presentation = null;

    let prepare_ = function () {
        presentation = document.getElementsByClassName('presentation')[0];

        transformPresentation();
        window.addEventListener('resize', transformPresentation);
    };


    /**
     * Transform Presentation Block on Resize
     */
    let transformPresentation = function () {
        let winW    = window.innerWidth,
            winH    = window.innerHeight,
            offsetL = winW > 768 ? 220 : 40,
            offsetT = 77,
            scale   = winW > 768 ? (winW - 590) / winW : (winW - 80) / winW;

        presentation.style.height = winW < 768 ? (winW - 80) * 3 /4 + "px" : '';
        presentation.style.transform = "scale(" + scale + ") translateY(" + offsetT / scale +"px) translateX(" + offsetL / scale + "px)";
    };


    editPresent.init = function () {
        prepare_();
    };

    return editPresent;

}({});