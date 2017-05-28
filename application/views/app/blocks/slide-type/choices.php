<div class="form-group">
    <label for="" class="form-group__label">Вопрос</label>
    <div class="form-group__control-group">
        <input type="text" class="form-group__control form-group__control-group-input" maxlength="80">
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

</div>



<script>

    var optionsList         = document.getElementById('optionsList'),
        addOption           = document.getElementById('addOption'),
        deleteOption        = document.getElementsByClassName('deleteOption'),
        optionsWithImageBtn = document.getElementById('optionsWithImage'),
        optionsWithImage    = false;

    optionsWithImageBtn.addEventListener('click', toggleOptionsWithImage);

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
            newOptionDeleteBtn = document.createElement('a'),
            newOptionAnswerBtn = null;

        newOption.classList.add('form-group__control-group','m-b-5');

        newOptionInput.type = 'text';
        newOptionInput.classList.add('form-group__control','form-group__control-group-input');
        newOptionInput.maxLength = 60;

        newOptionDeleteBtn.classList.add('form-group__control-group-addon','deleteOption');
        newOptionDeleteBtn.innerHTML = '<i class="fa fa-trash" aria-hidden="true"></i>';

        newOption.appendChild(newOptionInput);

        pit.form.createCounter(newOptionInput);
        newOptionDeleteBtn.addEventListener('click', deleteOptionFun);

        if (optionsWithImage) {
            newOptionAnswerBtn = createOptionWithImage(parseInt(optionsList.childElementCount + 1));
            newOption.appendChild(newOptionAnswerBtn);
        }

        newOption.appendChild(newOptionDeleteBtn);

        optionsList.appendChild(newOption);

    }


    addOption.addEventListener('click', addOptionFun);

    for( var i = 0; i < deleteOption.length; i++ ) {
        deleteOption[i].addEventListener('click', deleteOptionFun);
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

</script>
