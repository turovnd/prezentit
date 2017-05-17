var PresentName                 = document.getElementById('PresentName'),
    editPresentNameBtn          = document.getElementById('editPresentNameBtn'),
    editPresentNameFrom         = document.getElementById('editPresentNameFrom'),
    editPresentNameInput        = document.getElementById('editPresentNameInput'),
    editPresentNameBtnSubmit    = document.getElementById('editPresentNameBtnSubmit');

function toggleTitle() {
    PresentName.classList.toggle('hide');
    editPresentNameBtn.classList.toggle('hide');
    editPresentNameFrom.classList.toggle('hide');
}

function saveTitle() {
    toggleTitle();

    PresentName.innerHTML = editPresentNameInput.value;
    document.getElementsByTagName('title')[0].innerHTML = editPresentNameInput.value + " | Prezentit";

    /**
     * TODO update name via AJAX
     * editPresentNameInput.value
     */

}

function editTitle() {
    toggleTitle();
    editPresentNameInput.value = PresentName.innerHTML;
    editPresentNameInput.focus();
}

document.getElementsByClassName('presentation-name__btn')[0].addEventListener('click', saveTitle);
document.getElementsByClassName('header__title-btn-edit')[0].addEventListener('click', editTitle);