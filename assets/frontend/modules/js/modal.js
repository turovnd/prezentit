module.exports = (function (modal) {


    function prepare_() {

        var modalOpenBtns = document.querySelectorAll('[data-toggle="modal"]');

        if (modalOpenBtns !== null) {

            for (var i = 0; i < modalOpenBtns.length; i++) {

                modalOpenBtns[i].addEventListener('click', modal.show);

            }

        }

    }


    /**
     * Modal Create Function via JS
     *
     *  settings = {
     *      node     - DIV || FORM
     *      id       - unique ID of modal block
     *      size     - width of modal block (small || large)
     *      header   - STRING
     *      body     - body HTML
     *      footer   - footer HTML ( for close include data attribute: `data-close="modal"`)
     *      onclose: - remove || hide
     *  }
     */
    modal.create = function (settings) {

        settings.node = settings.node || 'DIV';

        var modalWrapper = vp.draw.node(settings.node, 'modal', {id: settings.id, 'tabindex': '-1'}),
            content      = vp.draw.node('DIV', 'modal__content'),
            wrapper      = vp.draw.node('DIV', 'modal__wrapper'),
            header       = vp.draw.node('DIV', 'modal__header'),
            headerTitle  = vp.draw.node('H4', 'modal__title'),
            closeHeadBtn = vp.draw.node('BUTTON', 'modal__title-close', {'data-close':'modal'}),
            body         = vp.draw.node('DIV', 'modal__body'),
            footer       = vp.draw.node('DIV', 'modal__footer'),
            onclose      = settings.onclose || 'hide';

        closeHeadBtn.innerHTML = '<i class="fa fa-close" aria-hidden="true"></i>';
        headerTitle.textContent = settings.header;

        header.appendChild(closeHeadBtn);
        header.appendChild(headerTitle);

        closeHeadBtn.addEventListener('click', modal.hide);

        body.innerHTML = settings.body;

        if (settings.header !== false)
            wrapper.appendChild(header);

        wrapper.appendChild(body);

        if (settings.footer) {

            footer.innerHTML = settings.footer;

            var closeBtns = footer.querySelectorAll('[data-close="modal"]');

            for(var i = 0; i < closeBtns.length; i++) {

                if (onclose === 'remove')
                    closeBtns[i].addEventListener('click', modal.remove);
                else
                    closeBtns[i].addEventListener('click', modal.hide);

            }

            wrapper.appendChild(footer);

        }

        content.appendChild(wrapper);
        content.classList.add('modal__content--' + settings.size);
        modalWrapper.appendChild(content);

        document.body.appendChild(modalWrapper);

        modal.show(modalWrapper);

        return modalWrapper;

    };


    modal.show = function (element) {

        var block = null;

        if (element.nodeType === 1) {

            block = element;

        } else {

            if (this.dataset.area) {

                block = document.getElementById(this.dataset.area);

            } else {

                vp.core.log('Can not catch `data-area`', 'error', 'VP: modal module');
                return;

            }


        }

        var closes = block.querySelectorAll('[data-close="modal"]');

        for (var i = 0; i < closes.length; i++) {

            closes[i].addEventListener('click', modal.hide);

        }

        var backdrop = vp.draw.node('DIV', 'modal-backdrop');

        block.classList.add('modal--opening', 'modal--opened');
        document.body.classList.add('overflow--hidden');
        document.body.appendChild(backdrop);

        window.setTimeout(function () {

            block.classList.remove('modal--opening');

        }, 200);

    };

    modal.hide = function (element) {

        var block = null;

        if (element.nodeType === 1) {

            block = element;

        } else {

            block = document.getElementsByClassName('modal--opened');

            if (block.length) {

                block = block[0];

            } else {

                vp.core.log('Can not catch element', 'error', 'VP: modal module');
                return;

            }

        }

        if (block.tagName === 'FORM')
            block.reset();

        block.classList.add('modal--closing');

        window.setTimeout(function () {

            block.classList.remove('modal--opened', 'modal--closing');
            document.body.classList.remove('overflow--hidden');
            document.getElementsByClassName('modal-backdrop')[0].remove();

        }, 200);

    };

    modal.remove = function (element) {

        var block = null;

        if (element.nodeType === 1) {

            block = element;

        } else {

            block = document.getElementsByClassName('modal--opened');

            if (block.length) {

                block = block[0];

            } else {

                vp.core.log('Can not catch element', 'error', 'VP: modal module');
                return;

            }

        }

        block.classList.add('modal--closing');

        window.setTimeout(function () {

            block.classList.remove('modal--opened', 'modal--closing');
            document.body.classList.remove('overflow--hidden');
            document.getElementsByClassName('modal-backdrop')[0].remove();
            block.remove();

        }, 200);

    };


    modal.init = function () {

        prepare_();

    };


    return modal;

})({});