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

    <div class="form-group">
        <label for="" class="form-group__label">Варианты ответа</label>
        <ul id="optionsList" class="m-b-10">
            <li class="form-group__control-group m-b-5">
                <input type="text" class="form-group__control form-group__control-group-input" maxlength="60">
                <a class="form-group__control-group-addon deleteOption">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </a>
            </li>
            <li class="form-group__control-group m-b-5">
                <input type="text" class="form-group__control form-group__control-group-input" maxlength="60">
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


    var optionsList     = document.getElementById('optionsList'),
        addOption       = document.getElementById('addOption'),
        deleteOption    = document.getElementsByClassName('deleteOption');


    function deleteOptionFun(el) {

        var element = el.target || el;

        if ( ! element.classList.contains('deleteOption') ) {
            element = element.parentNode;
        }

        element.parentNode.remove();

    }


    function addOptionFun() {

        var newOption = document.createElement('li'),
            newOptionInput = document.createElement('input'),
            newOptionDeleteBtn = document.createElement('a');

        newOption.classList.add('form-group__control-group','m-b-5');

        newOptionInput.type = 'text';
        newOptionInput.classList.add('form-group__control','form-group__control-group-input');
        newOptionInput.maxLength = 60;

        newOptionDeleteBtn.classList.add('form-group__control-group-addon','deleteOption');
        newOptionDeleteBtn.innerHTML = '<i class="fa fa-trash" aria-hidden="true"></i>';

        newOption.appendChild(newOptionInput);

        createCounter(newOptionInput);
        newOptionDeleteBtn.addEventListener('click', deleteOptionFun);

        newOption.appendChild(newOptionDeleteBtn);

        optionsList.appendChild(newOption);

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
