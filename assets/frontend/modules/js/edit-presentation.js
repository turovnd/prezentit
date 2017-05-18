let editPresent = function (editPresent) {

    let present                  = null,
        PresentName              = null,
        editPresentNameBtn       = null,
        editPresentNameFrom      = null,
        editPresentNameInput     = null,
        editPresentNameBtnSubmit = null,
        newSlideBtn              = null;

    /**
     * Prepare Heading For Editing Presentation Name
     * @private
     */
    let prepareHeader_ = function () {
        PresentName = document.getElementById('PresentName');
        editPresentNameBtn = document.getElementById('editPresentNameBtn');
        editPresentNameFrom = document.getElementById('editPresentNameFrom');
        editPresentNameInput = document.getElementById('editPresentNameInput');
        editPresentNameBtnSubmit = document.getElementById('editPresentNameBtnSubmit');

        if (editPresentNameBtnSubmit)
            editPresentNameBtnSubmit.addEventListener('click', saveTitle_);

        if(editPresentNameBtn)
            editPresentNameBtn.addEventListener('click', editTitle_);
    };
    

    let prepare_ = function () {

        present = document.getElementsByClassName('presentation')[0];
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


    /**
     * Toggle Editing Area for Editing Presentation Name
     * @private
     */
    function toggleTitle_() {
        PresentName.classList.toggle('hide');
        editPresentNameBtn.classList.toggle('hide');
        editPresentNameFrom.classList.toggle('hide');
    }


    /**
     * Save Presentation Name -> send to DB
     * @private
     */
    function saveTitle_() {
        toggleTitle_();

        PresentName.innerHTML = editPresentNameInput.value;
        document.getElementsByTagName('title')[0].innerHTML = editPresentNameInput.value + " | Prezentit";

        /**
         * TODO update name via AJAX
         * editPresentNameInput.value
         */

    }


    /**
     * Edit Presentation Name -> open form for editing
     * @private
     */
    function editTitle_() {
        toggleTitle_();
        editPresentNameInput.value = PresentName.innerHTML;
        editPresentNameInput.focus();
    }
    


    editPresent.init = function () {
        prepareHeader_();
        prepare_();
        pit.core.log("Module loaded",'log','edit-present');
    };

    return editPresent;

}({});