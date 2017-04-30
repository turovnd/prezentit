<div class="m-t-20">

    <div class="form-group">
        <label for="" class="form-group__label">Заголовок</label>
        <div class="form-group__control-group">
            <input type="text" class="form-group__control form-group__control-group-input" maxlength="90">
            <label for="bgImage" class="form-group__control-group-addon cursor-pointer">
                <i class="fa fa-image" aria-hidden="true"></i>
                <input id="bgImage" type="file" class="hide">
            </label>
        </div>
    </div>

    <div class="form-group">
        <label for="" class="form-group__label">Параграф</label>
        <textarea id="" name="" class="form-group__control" maxlength="300" rows="6"></textarea>
    </div>

    <div class="form-group clear-fix">
        <label for="" class="form-group__label">Реакции аудитории <i class="fa fa-question reaction-tooltip-icon" aria-hidden="true"></i></label>
        <div class="m-t-5 clear-fix">
            <div class="text-center fl_l m-r-20">
                <label for="reactionLikes" class="reactions__label">
                    <i class="fa fa-heart" aria-hidden="true"></i>
                </label>
                <input id="reactionLikes" type="checkbox" class="m-t-5 checkbox">
                <label for="reactionLikes" class="checkbox-label reactions__label-checkbox"></label>
            </div>
            <div class="text-center fl_l m-r-20">
                <label for="reactionQuestion" class="reactions__label">
                    <i class="fa fa-question" aria-hidden="true"></i>
                </label>
                <input id="reactionQuestion" type="checkbox" class="m-t-5 checkbox">
                <label for="reactionQuestion" class="checkbox-label reactions__label-checkbox"></label>
            </div>
            <div class="text-center fl_l m-r-20">
                <label for="reactionThumbsUp" class="reactions__label">
                    <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                </label>
                <input id="reactionThumbsUp" type="checkbox" class="m-t-5 checkbox">
                <label for="reactionThumbsUp" class="checkbox-label reactions__label-checkbox"></label>
            </div>
            <div class="text-center fl_l m-r-20">
                <label for="reactionThumbsDown"class="reactions__label">
                    <i class="fa fa-thumbs-down" aria-hidden="true"></i>
                </label>
                <input id="reactionThumbsDown" type="checkbox" class="m-t-5 checkbox">
                <label for="reactionThumbsDown" class="checkbox-label reactions__label-checkbox"></label>
            </div>
        </div>
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
