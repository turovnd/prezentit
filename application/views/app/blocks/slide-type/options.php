<div class="m-t-20">

    <div class="form-group">
        <label for="" class="form-group__label">Вопрос</label>
        <div class="form-group__control-group">
            <input type="text" class="form-group__control form-group__control-group-input" maxlength="90">
            <label for="bgImage" class="form-group__control-group-addon cursor-pointer">
                <i class="fa fa-image" aria-hidden="true"></i>
                <input id="bgImage" type="file" class="hide">
            </label>
        </div>
    </div>

    <div class="form-group clear-fix">
        <label class="form-group__label">Варианты ответа</label>
        <ul id="optionsList" class="m-b-10">
            <li class="form-group__control-group m-b-5">
                <input type="text" class="form-group__control form-group__control-group-input" maxlength="60">
                <label for="optionCheckbox_1" class="form-group__control-group-addon p-t-0 p-b-0 b-l-0 cursor-pointer">
                    <input id="optionCheckbox_1" type="checkbox" class="checkbox">
                    <label for="optionCheckbox_1" class="checkbox-label reactions__label-checkbox"></label>
                </label>
                <a class="form-group__control-group-addon deleteOption">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </a>
            </li>
            <li class="form-group__control-group m-b-5">
                <input type="text" class="form-group__control form-group__control-group-input" maxlength="60">
                <label for="optionCheckbox_2" class="form-group__control-group-addon p-t-0 p-b-0 b-l-0 cursor-pointer">
                    <input id="optionCheckbox_2" type="checkbox" class="checkbox">
                    <label for="optionCheckbox_2" class="checkbox-label reactions__label-checkbox"></label>
                </label>
                <a class="form-group__control-group-addon deleteOption">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </a>
            </li>
        </ul>
        <button id="addOption" role="button" class="btn btn--brand col-xs-12">
            <i class="fa fa-plus" aria-hidden="true"></i>
            добавить
        </button>
    </div>

    <div class="form-group">

        <label class="form-group__label">Дополнительно</label>

        <div class="m-t-5">
            <input id="showInPercents" type="checkbox" class="checkbox">
            <label for="showInPercents" class="checkbox-label">показать результаты в %</label>
        </div>

        <div class="m-t-5">
            <input id="optionsWithImage" type="checkbox" class="checkbox">
            <label for="optionsWithImage" class="checkbox-label">ответы с изображением</label>
        </div>

        <div class="m-t-5">
            <input id="askMoreQuestions" type="checkbox" class="checkbox">
            <label for="askMoreQuestions" class="checkbox-label">разрешить ответить более чем на один вопрос</label>
        </div>

    </div>

    <div id="askMoreQuestionsBlock" class="form-group m-t-5 hide">
        <label for="askMoreQuestionsSelect" class="form-group__label">Максимальное количество вариантов ответов</label>
        <select id="askMoreQuestionsSelect" class="form-group__control">
            <option value="1">1</option>
            <option value="2">2</option>
        </select>
    </div>

</div>

<style>
    .input-with-counter-block{
        position: relative;
    }
    .input-with-counter{
        float: none;
        padding-right: 35px;
        resize: vertical;
    }
    .counter-block{
        position: absolute;
        bottom: 0;
        right: 0;
        color: #ccc;
        opacity:0;
        margin: 8px 10px;
        font-size: .8em;
        z-index: 5;
    }
    .input-with-counter:focus + .counter-block{
        opacity:1;
    }
    .reactions__label-checkbox{
        padding-left: 18px !important;
        margin-top: 5px;
    }
</style>

<script>

    var optionsList         = document.getElementById('optionsList'),
        addOption           = document.getElementById('addOption'),
        deleteOption        = document.getElementsByClassName('deleteOption'),
        moreQuestionsBlock  = document.getElementById('askMoreQuestionsBlock'),
        moreQuestionsBth    = document.getElementById('askMoreQuestions'),
        moreQuestionsSelect = document.getElementById('askMoreQuestionsSelect'),
        optionsWithImageBtn  = document.getElementById('optionsWithImage'),
        optionsWithImage     = false;

    function toggleAskMoreThanOneQuestion() {
        moreQuestionsBlock.classList.toggle('hide');
    }
    


    optionsWithImageBtn.addEventListener('click', toggleOptionsWithImage);
    moreQuestionsBth.addEventListener('click', toggleAskMoreThanOneQuestion);


    function deleteOptionFun(el) {

        var element = el.target || el;

        if ( ! element.classList.contains('deleteOption') ) {
            element = element.parentNode;
        }

        element.parentNode.remove();

        moreQuestionsSelect.lastElementChild.remove();

    }


    function createOptionWithImage(index) {

        var optionBtn   = document.createElement('label'),
            optionImage = document.createElement('input');

        optionBtn.setAttribute('for', 'optionImage_' + index);
        optionBtn.classList.add('form-group__control-group-addon','b-l-0','cursor-pointer','optionImage');
        optionBtn.innerHTML = '<i class="fa fa-image" aria-hidden="true"></i>';
        optionImage.setAttribute('type', 'file');
        optionImage.id = 'optionImage_' + index;
        optionImage.classList.add('hide');

        optionBtn.appendChild(optionImage);

        return optionBtn;
    }


    function createOption(index) {
        var optionBtn   = document.createElement('label'),
            optionInput = document.createElement('input'),
            optionLabel = document.createElement('label');

        optionBtn.classList.add('form-group__control-group-addon','p-t-0','p-b-0','b-l-0','cursor-pointer');
        optionBtn.setAttribute('for', 'optionCheckbox_' + index);
        optionInput.id = 'optionCheckbox_' + index;
        optionInput.setAttribute('type','checkbox');
        optionInput.classList.add('checkbox');
        optionLabel.setAttribute('for', 'optionCheckbox_' + index);
        optionLabel.classList.add('checkbox-label','reactions__label-checkbox');

        optionBtn.appendChild(optionInput);
        optionBtn.appendChild(optionLabel);

        return optionBtn;
    }


    function toggleOptionsWithImage() {

        optionsWithImage = optionsWithImageBtn.checked;

        for (var i = 0; i < optionsList.childElementCount; i++) {

            if (optionsWithImage) {
                optionsList.children[i].insertBefore(createOptionWithImage(i), optionsList.children[i].children[1]);
            } else {
                optionsList.getElementsByClassName('optionImage')[0].remove();
            }

        }

    }


    function addOptionFun() {

        var newOption          = document.createElement('li'),
            newOptionInput     = document.createElement('input'),
            newOptionDeleteBtn = document.createElement('a'),
            newOptionAnswerBtn = null;

        newOption.classList.add('form-group__control-group','m-b-5');

        newOptionInput.type = 'text';
        newOptionInput.classList.add('form-group__control','form-group__control-group-input');
        newOptionInput.maxLength = 60;

        newOptionDeleteBtn.classList.add('form-group__control-group-addon','deleteOption');
        newOptionDeleteBtn.innerHTML = '<i class="fa fa-trash" aria-hidden="true"></i>';

        newOption.appendChild(newOptionInput);

        createCounter(newOptionInput);
        newOptionDeleteBtn.addEventListener('click', deleteOptionFun);

        if (optionsWithImage) {
            newOptionAnswerBtn = createOptionWithImage(parseInt(optionsList.childElementCount + 1));
            newOption.appendChild(newOptionAnswerBtn);
            newOptionAnswerBtn = createOption(parseInt(optionsList.childElementCount + 1));
            newOption.appendChild(newOptionAnswerBtn);
        } else {
            newOptionAnswerBtn = createOption(parseInt(optionsList.childElementCount + 1));
            newOption.appendChild(newOptionAnswerBtn);
        }

        newOption.appendChild(newOptionDeleteBtn);

        optionsList.appendChild(newOption);

        var selectOption = document.createElement('option');
        selectOption.value = optionsList.childElementCount;
        selectOption.innerHTML = optionsList.childElementCount;

        moreQuestionsSelect.appendChild(selectOption);

    }


    addOption.addEventListener('click', addOptionFun);

    for( var i = 0; i < deleteOption.length; i++ ) {
        deleteOption[i].addEventListener('click', deleteOptionFun);
    }





    /* form */
    function changeCounter(el) {
        var inputArea   = el.target || el,
            counter     = inputArea.parentNode.children[1];

        counter.innerHTML = inputArea.maxLength - inputArea.value.length;
    }

    function createCounter(el, len) {
        var inputBlock  = document.createElement('div'),
            counter     = document.createElement('span'),
            formBlock   = el.parentNode;

        counter.classList.add('counter-block');
        counter.innerHTML = len;

        el.classList.add('input-with-counter');
        inputBlock.classList.add('input-with-counter-block');

        inputBlock.appendChild(el);
        inputBlock.appendChild(counter);
        if ( formBlock.classList.contains('form-group__control-group') ) {
            formBlock.insertBefore(inputBlock, formBlock.childNodes[0]);
        } else {
            formBlock.appendChild(inputBlock);
        }
        changeCounter(el);
        el.addEventListener('keyup', changeCounter);

    }

    var inputs = document.getElementsByTagName('input');
    var textareas = document.getElementsByTagName('textarea');

    for (var i = 0; i < inputs.length; i++) {

        if ( inputs[i].hasAttribute('maxlength') ) {
            createCounter(inputs[i], inputs[i].maxLength);
        }

    }

    for (var i = 0; i < textareas.length; i++) {

        if ( textareas[i].hasAttribute('maxlength') ) {
            createCounter(textareas[i], textareas[i].maxLength);
        }

    }
</script>
