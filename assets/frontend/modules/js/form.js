module.exports = (function (form) {

    var inputs      = null,
        textareas   = null;

    var prepare_ = function () {

        inputs      = document.getElementsByTagName('input');
        textareas   = document.getElementsByTagName('textarea');

        for (var i = 0; i < inputs.length; i++) {

            if ( inputs[i].hasAttribute('maxlength') ) {

                form.createCounter(inputs[i], inputs[i].maxLength);

            }

        }

        for (var i = 0; i < textareas.length; i++) {

            if ( textareas[i].hasAttribute('maxlength') ) {

                form.createCounter(textareas[i], textareas[i].maxLength);

            }

        }

    };

    form.init = function () {

        prepare_();

    };

    var changeCounter = function (el) {

        var inputArea   = el.target || el,
            counter     = inputArea.parentNode.children[1];

        counter.innerHTML = inputArea.maxLength - inputArea.value.length;

    };


    form.createCounter = function (el, len) {

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

    };

    return form;

})({});
