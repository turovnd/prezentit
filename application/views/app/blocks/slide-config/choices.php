<div class="form-group">
    <label for="heading_choices_<?=$slide->id; ?>" class="form-group__label">Вопрос</label>

    <div class="form-group__control-group">

        <input id="heading_choices_<?=$slide->id; ?>" type="text" class="form-group__control form-group__control-group-input js-ajax-edited" maxlength="80" value="<?=$slide->heading; ?>" data-name="heading" placeholder="Вопрос">

        <label class="form-group__control-group-addon bg-image <? echo $slide->image == (NULL || '') ? '' : 'bg-image--with-image'; ?>" title="Фоновая картинка" value="<?=$slide->image?>" data-name="image">
            <i class="fa fa-image bg-image__icon" aria-hidden="true"></i>
            <i class="fa fa-close bg-image__close" aria-hidden="true"></i>
            <img src="<?=URL::site('uploads/slides/s_' . $slide->image); ?>" class="bg-image__image">
        </label>

    </div>

</div>

<div id="answer_choices_<?=$slide->id; ?>" class="form-group clear-fix answer" data-image="<? echo $slide->answers_with_image == 1 ? 'true':'false'?>" >

    <label class="form-group__label">Варианты ответа</label>

    <ul class="m-b-10 answer__list">

        <?
            $defaultAnswers = '[{"text": "", "image": ""}, {"text": "", "image": ""}]';

            $answers = json_decode($slide->answers) != NULL ? json_decode($slide->answers) : json_decode($defaultAnswers);
        ?>

        <? if ($answers != '') : ?>

            <? foreach ($answers as $answer) :?>

                <li class="form-group__control-group answer__item">

                    <input type="text" class="form-group__control form-group__control-group-input answer__value" maxlength="60" value="<?=$answer->text; ?>">

                    <? if ($slide->answers_with_image == 1) : ?>

                        <a class="form-group__control-group-addon b-l-0 answer__image <? echo $answer->image == (NULL || '') ? '' : 'bg-image--with-image'; ?>" title="Картинка ответа">
                            <i class="fa fa-image bg-image__icon" aria-hidden="true"></i>
                            <i class="fa fa-close bg-image__close" aria-hidden="true"></i>
                            <img src="<? echo $answer->image == (NULL || '') ? '/' : URL::site('uploads/slides/answers/s_' . $answer->image); ?>" class="bg-image__image" data-src="<?=$answer->image; ?>">
                        </a>

                    <? endif; ?>

                    <a class="form-group__control-group-addon js-option-delete">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>

                </li>

            <? endforeach; ?>

        <? endif; ?>

    </ul>

    <button role="button" class="btn btn--brand col-xs-12 js-option-add">
        <i class="fa fa-plus" aria-hidden="true"></i> добавить
    </button>

</div>

<div class="form-group">

    <label class="form-group__label">Дополнительно</label>

    <div class="m-t-5">
        <input id="show_percent_choices_<?=$slide->id; ?>" type="checkbox" class="checkbox" data-name="results_in_percents" data-value="1" <? echo $slide->results_in_percents == 1 ? 'checked' : ''; ?>>
        <label for="show_percent_choices_<?=$slide->id; ?>" class="checkbox-label">показать результаты в %</label>
    </div>

    <div class="m-t-5">
        <input id="show_image_choices_<?=$slide->id; ?>" type="checkbox" class="checkbox answers-with-image" data-name="answers_with_image" data-value="1" <? echo $slide->answers_with_image == 1 ? 'checked' : ''; ?>>
        <label for="show_image_choices_<?=$slide->id; ?>" class="checkbox-label">ответы с изображением</label>
    </div>

</div>



<!--<script>-->
<!---->
<!--    var optionsList         = document.getElementById('optionsList'),-->
<!--        addOption           = document.getElementById('addOption'),-->
<!--        deleteOption        = document.getElementsByClassName('deleteOption'),-->
<!--        optionsWithImageBtn = document.getElementById('optionsWithImage'),-->
<!--        optionsWithImage    = false;-->
<!---->
<!--    optionsWithImageBtn.addEventListener('click', toggleOptionsWithImage);-->
<!---->
<!--    function createOptionWithImage(index) {-->
<!---->
<!--        var optionBtn   = document.createElement('label'),-->
<!--            optionImage = document.createElement('input');-->
<!---->
<!--        optionBtn.setAttribute('for', 'optionImage_' + index);-->
<!--        optionBtn.classList.add('form-group__control-group-addon','b-l-0','cursor-pointer','optionImage');-->
<!--        optionBtn.innerHTML = '<i class="fa fa-image" aria-hidden="true"></i>';-->
<!--        optionImage.setAttribute('type', 'file');-->
<!--        optionImage.id = 'optionImage_' + index;-->
<!--        optionImage.classList.add('hide');-->
<!---->
<!--        optionBtn.appendChild(optionImage);-->
<!---->
<!--        return optionBtn;-->
<!--    }-->
<!---->
<!---->
<!--    function deleteOptionFun(el) {-->
<!---->
<!--        var element = el.target || el;-->
<!---->
<!--        if ( ! element.classList.contains('deleteOption') ) {-->
<!--            element = element.parentNode;-->
<!--        }-->
<!---->
<!--        element.parentNode.remove();-->
<!---->
<!--    }-->
<!---->
<!---->
<!--    function addOptionFun() {-->
<!---->
<!--        var newOption = document.createElement('li'),-->
<!--            newOptionInput = document.createElement('input'),-->
<!--            newOptionDeleteBtn = document.createElement('a'),-->
<!--            newOptionAnswerBtn = null;-->
<!---->
<!--        newOption.classList.add('form-group__control-group','m-b-5');-->
<!---->
<!--        newOptionInput.type = 'text';-->
<!--        newOptionInput.classList.add('form-group__control','form-group__control-group-input');-->
<!--        newOptionInput.maxLength = 60;-->
<!---->
<!--        newOptionDeleteBtn.classList.add('form-group__control-group-addon','deleteOption');-->
<!--        newOptionDeleteBtn.innerHTML = '<i class="fa fa-trash" aria-hidden="true"></i>';-->
<!---->
<!--        newOption.appendChild(newOptionInput);-->
<!---->
<!--        pit.form.createCounter(newOptionInput);-->
<!--        newOptionDeleteBtn.addEventListener('click', deleteOptionFun);-->
<!---->
<!--        if (optionsWithImage) {-->
<!--            newOptionAnswerBtn = createOptionWithImage(parseInt(optionsList.childElementCount + 1));-->
<!--            newOption.appendChild(newOptionAnswerBtn);-->
<!--        }-->
<!---->
<!--        newOption.appendChild(newOptionDeleteBtn);-->
<!---->
<!--        optionsList.appendChild(newOption);-->
<!---->
<!--    }-->
<!---->
<!---->
<!--    addOption.addEventListener('click', addOptionFun);-->
<!---->
<!--    for( var i = 0; i < deleteOption.length; i++ ) {-->
<!--        deleteOption[i].addEventListener('click', deleteOptionFun);-->
<!--    }-->
<!---->
<!---->
<!--    function toggleOptionsWithImage() {-->
<!---->
<!--        optionsWithImage = optionsWithImageBtn.checked;-->
<!---->
<!--        for (var i = 0; i < optionsList.childElementCount; i++) {-->
<!---->
<!--            if (optionsWithImage) {-->
<!--                optionsList.children[i].insertBefore(createOptionWithImage(i), optionsList.children[i].children[1]);-->
<!--            } else {-->
<!--                optionsList.getElementsByClassName('optionImage')[0].remove();-->
<!--            }-->
<!---->
<!--        }-->
<!---->
<!--    }-->
<!---->
<!--</script>-->
