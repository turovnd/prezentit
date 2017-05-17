let editPresent = function (editPresent) {

    let present = null,
        newSlideBtn = null;

    let prepare_ = function () {
        present = document.getElementsByClassName('present')[0];
        newSlideBtn = document.getElementById('newSlide');

        if (newSlideBtn)
            newSlideBtn.addEventListener('click', openNewSlideForm_);

        transformPresentation();
        window.addEventListener('resize', transformPresentation);
    };


    let openNewSlideForm_ = function () {
        
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

        present.style.height = winW < 768 ? (winW - 80) * 3 /4 + "px" : '';
        present.style.transform = "scale(" + scale + ") translateY(" + offsetT / scale +"px) translateX(" + offsetL / scale + "px)";
    };


    editPresent.init = function () {
        prepare_();
        pit.core.log("Module loaded",'log','edit-present');
    };

    return editPresent;

}({});