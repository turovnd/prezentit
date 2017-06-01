module.exports = function (editPresent) {

    var coreLogPrefix            = 'edit-presentation',
        present                  = null,
        presentationName         = null,
        presentationId           = null,
        editPresentNameBtn       = null,
        editPresentNameFrom      = null,
        editPresentNameInput     = null,
        editPresentNameBtnSubmit = null,
        newSlideModal            = null,
        newSlideBlocks           = null,
        selectedNewSlide         = null,
        asideMenu                = null,
        configContent            = null,
        deleteSlideModal         = null,
        deletedID                = null,
        slidesOrder              = null,
        curSlideId               = null,
        configStatus             = null,
        editedFields             = null,
        choiceAnswers            = null;


    const newSlidesContent = [
        {
            'type': 1,
            'name': 'Заголовок',
            'icon': 'fa-header',
            'image': 'heading_ru.png'
        }, {
            'type': 2,
            'name': 'Изображение',
            'icon': 'fa-image',
            'image': 'image_ru.png',
            'options' : [
                {
                    'id': 'image_position_center',
                    'type': 'radio',
                    'name': '2_image_position',
                    'data_name': 'image_position',
                    'data_value': '1',
                    'title': 'Изображение по центру слайда'
                }, {
                    'id': 'image_position_full',
                    'type': 'radio',
                    'name': '2_image_position',
                    'data_name': 'image_position',
                    'data_value': '2',
                    'title': 'Изображение на весь слайд'
                }
            ]
        }, {
            'type': 3,
            'name': 'Параграф',
            'icon': 'fa-paragraph',
            'image': 'paragraph_ru.png'
        }, {
            'type': 4,
            'name': 'Слайд с вопросом',
            'icon': 'fa-bar-chart',
            'image': 'choices_ru.png',
            'options' : [
                {
                    'id': '4_answer_with_image',
                    'type': 'checkbox',
                    'name': '4_answers_with_image',
                    'data_name': 'answers_with_image',
                    'data_value': '1',
                    'title': 'Ответы с изображением'
                }, {
                    'id': '4_results_in_percents',
                    'type': 'checkbox',
                    'name': '4_results_in_percents',
                    'data_name': 'results_in_percents',
                    'data_value': '1',
                    'title': 'Выводить результаты в процентах'
                }
            ]
        }
    ];


    function prepareHeader_() {

        presentationName = document.getElementById('PresentName');
        editPresentNameBtn = document.getElementById('editPresentNameBtn');
        editPresentNameFrom = document.getElementById('editPresentNameFrom');
        editPresentNameInput = document.getElementById('editPresentNameInput');
        editPresentNameBtnSubmit = document.getElementById('editPresentNameBtnSubmit');

        if (!editPresentNameBtnSubmit || !editPresentNameBtn)
            return false;

        editPresentNameBtnSubmit.addEventListener('click', saveTitle_);
        editPresentNameBtn.addEventListener('click', editTitle_);

        return true;

    }

    function prepareNewSlide_() {

        var newSlideBtns = document.getElementsByClassName('js-new-slide');

        if (newSlideBtns.length === 0)
            return false;

        for (var i = 0; i < newSlideBtns.length; i++) {

            newSlideBtns[i].addEventListener('click', openNewSlideForm_);

        }

        return true;

    }


    function prepareSlides_() {

        present         = document.getElementsByClassName('presentation')[0];
        presentationId  = document.getElementById('presentation_id').value;

        var slides      = document.getElementsByClassName('presentation__slide');

        if (slides.length === 0) {

            createDefaultSlide_();

        }

        for (var i = 0; i < slides.length; i++) {

            slides[i].classList.remove('presentation__slide--after', 'presentation__slide--before');

        }

        transformPresentation_();
        window.addEventListener('resize', transformPresentation_);

        return true;

    }


    function prepareAside_() {

        asideMenu       = document.getElementsByClassName('aside__menu')[0];
        slidesOrder     = JSON.parse(document.getElementById('slides_order').value);

        var slidesHash      = window.location.pathname.split('/')[3],
            asideSelectBtns = document.getElementsByClassName('js-select-slide'),
            asideDeleteBtns = document.getElementsByClassName('js-delete-slide'),
            existCurSlideId = false;

        if (pit.cookies.get('cur_slide') && pit.cookies.get('cur_slide').match(new RegExp(slidesHash))) {

            curSlideId = parseInt(pit.cookies.get('cur_slide').replace(window.location.pathname.split('/')[3], ''));

        }

        for ( var i = 0; i < asideSelectBtns.length; i++) {

            asideSelectBtns[i].addEventListener('click', switchSlide_);
            asideDeleteBtns[i].addEventListener('click', openDeleteSlide_);

            if (asideSelectBtns[i].parentNode.id === 'aside_' + curSlideId)
                existCurSlideId = true;

        }


        if (asideSelectBtns.length > 0) {

            if (!existCurSlideId) {

                curSlideId = asideSelectBtns[0].parentNode.id.split('_')[1];
                pit.cookies.set({
                    name: 'cur_slide',
                    value: 'presentation~' + window.location.pathname.split('/')[3] + curSlideId,
                    expires: 21600,
                    path: '/'
                });

            }

            selectSlide_(curSlideId);

        }

        return true;

    }


    function prepareConfig_() {

        configStatus    = document.getElementsByClassName('config__status')[0];
        configContent   = document.getElementById('configContent');
        editedFields    = document.getElementsByClassName('js-ajax-edited');

        for (var i = 0; i < editedFields.length; i++) {

            editedFields[i].addEventListener('keyup', updateFieldData_);

        }

        var updateImage = document.getElementsByClassName('bg-image');

        for (var i = 0; i < updateImage.length; i++) {

            if (updateImage[i].classList.contains('bg-image--with-image'))
                updateImage[i].addEventListener('click', removeBackground_);
            else
                updateImage[i].addEventListener('click', transportBackground_);

        }

        var checkbox = document.getElementsByClassName('checkbox');

        for (var i = 0; i < checkbox.length; i++) {

            checkbox[i].addEventListener('click', updateCheckboxData_);

        }


        return true;

    }


    function prepareChoiceOptions_() {

        choiceAnswers = [];

        var answers = document.getElementsByClassName('answer'),
            options = null,
            answer  = null,
            items   = null;

        for (var i = 0; i < answers.length; i++) {

            options = [];
            answers[i].dataset.answer = i;

            items = answers[i].getElementsByClassName('answer__item');

            for (var j = 0; j < items.length; j++) {

                items[j].getElementsByClassName('js-option-delete')[0].addEventListener('click', removeAnswer_);
                items[j].getElementsByClassName('js-option-delete')[0].dataset.number = j;

                var input = items[j].getElementsByClassName('answer__value')[0],
                    image = items[j].getElementsByClassName('answer__image')[0];

                answer = {
                    'text': input.value,
                    'image': (image && image.getElementsByClassName('bg-image__image')[0].dataset.src !== '') ? image.getElementsByClassName('bg-image__image')[0].dataset.src : '',
                };

                input.addEventListener('keyup', updateInputAnswers_);
                input.dataset.number = j;

                if (image) {

                    if (image.getElementsByClassName('bg-image__image')[0].dataset.src === '')
                        image.addEventListener('click', transportAnswerImage_);
                    else
                        image.addEventListener('click', removeAnswerImage_);
                    image.dataset.number = j;

                }

                image = input = null;
                options.push(answer);

            }

            choiceAnswers.push(options);

        }

        var toggleImage   = document.getElementsByClassName('answers-with-image'),
            addOptionBtns = document.getElementsByClassName('js-option-add');

        for (var i = 0; i < toggleImage.length; i++) {

            toggleImage[i].addEventListener('click', answerWithImage_);

        }

        for (var i = 0; i < addOptionBtns.length; i++) {

            addOptionBtns[i].addEventListener('click', addAnswer_);

        }

        return true;

    }


    /**
     * Create Default slide with btn "new slide@
     * @private
     */
    function createDefaultSlide_() {

        var slide = pit.draw.node('SECTION', 'cursor-pointer presentation__slide presentation__slide--items-center presentation__slide--active', {id:'defaultSlide'});

        slide.innerHTML = '<div class="presentation__content presentation__content--center"><h1 class="presentation__content-heading presentation__text--light"> Создать новый слайд </h1></div>';

        slide.addEventListener('click', openNewSlideForm_);
        document.getElementsByClassName('presentation__slides')[0].appendChild(slide);

    }



    /**
     * Open New Slide On Click `newSlideBtn`
     * @private
     */
    function openNewSlideForm_() {

        newSlideModal = pit.notification.notify({
            type: 'confirm',
            size: 'large',
            message:    '<div class="new-slide">' +
                            '<h2 class="new-slide__title">Новый слайд</h2>' +
                            '<div class="new-slide__wrapper">' +
                                 getNewSlidesContent_() +
                            '</div>' +
                        '</div>',
            showCancelButton: true,
            confirmText: 'Создать',
            cancelText: 'Закрыть',
            validation: true,
            confirm: createNewSlide_,
            cancel: dropNewSlide_

        });


        newSlideBlocks = document.getElementsByClassName('new-slide__content');
        var closeNewSlideBlocksBtn = document.getElementsByClassName('new-slide__close-icon');

        for(var i = 0; i < newSlideBlocks .length; i++) {

            newSlideBlocks[i].addEventListener('click', selectNewSlide_);
            closeNewSlideBlocksBtn[i].addEventListener('click', closeNewSlide_);

        }

    }


    /**
     * Create New Slides Blocks for Creating New Slide
     * @returns {string}
     * @private
     */
    function getNewSlidesContent_() {

        var outStr = '', optStrOpt;

        for(var i = 0; i < newSlidesContent.length; i++) {

            optStrOpt = '';
            outStr +=   '<div class="new-slide__block" data-type="' + newSlidesContent[i].type + '">' +
                            '<i class="fa fa-close new-slide__close-icon" aria-hidden="true"></i>' +
                            '<div class="new-slide__content">' +
                                '<p class="new-slide__name">' + newSlidesContent[i].name +'</p>' +
                                '<img class="new-slide__image" src="/assets/static/img/slides/types/' + newSlidesContent[i].image + '">'+
                                '<i class="fa ' + newSlidesContent[i].icon + ' new-slide__icon" aria-hidden="true"></i>' +
                            '</div>';


            if ( newSlidesContent[i].options !== undefined ) {

                optStrOpt +=   '<div class="new-slide__options-wrapper">';

                for (var j = 0; j < newSlidesContent[i].options.length; j++) {

                    optStrOpt +=    '<div class="new-slide__option">' +
                                        '<input type="' + newSlidesContent[i].options[j].type +'" id="' + newSlidesContent[i].options[j].id +'" name="' + newSlidesContent[i].options[j].name +'" data-name="' + newSlidesContent[i].options[j].data_name + '" data-value="' + newSlidesContent[i].options[j].data_value + '" class="checkbox">' +
                                        '<label for="' + newSlidesContent[i].options[j].id +'" class="checkbox-label">' + newSlidesContent[i].options[j].title +'</label>' +
                                    '</div>';

                }

                optStrOpt += '</div>';

            }

            outStr += optStrOpt+ '</div>';

        }
        return outStr;

    }

    /**
     * Select New Slide - open options which slide has
     * @private
     */
    function selectNewSlide_() {

        selectedNewSlide = this;

        for(var i = 0; i < newSlideBlocks .length; i++) {

            newSlideBlocks[i].parentNode.classList.add('hide');

        }

        selectedNewSlide.parentNode.classList.remove('hide');
        selectedNewSlide.removeEventListener('click', selectNewSlide_);
        selectedNewSlide.parentNode.classList.add('new-slide__block--selected');

    }


    /**
     * Close Selected New Slide - returns to selecting slide type
     * @private
     */
    function closeNewSlide_() {

        selectedNewSlide.addEventListener('click', selectNewSlide_);
        selectedNewSlide.parentNode.classList.remove('new-slide__block--selected');
        selectedNewSlide = null;
        for (var i = 0; i < newSlideBlocks .length; i++) {

            newSlideBlocks[i].parentNode.classList.remove('hide');

        }

    }

    /**
     * Drop New Slide Form
     * @private
     */
    function dropNewSlide_() {

        for(var i = 0; i < newSlideBlocks .length; i++) {

            newSlideBlocks[i].removeEventListener('click', selectNewSlide_);

        }
        newSlideBlocks = null;

    }


    /**
     * Submit Creating New Slide
     * @private
     */
    function createNewSlide_() {

        if (selectedNewSlide === null) {

            pit.notification.notify({message:'Пожалуйста выберите тип слайда', type:'error'});
            pit.core.log('New slide type has not chosen', 'error', coreLogPrefix);
            return false;

        }

        var newSlideWrapper = document.getElementsByClassName('new-slide')[0];

        newSlideWrapper.classList.add('loading');

        var formData = new FormData(),
            type = selectedNewSlide.parentNode.dataset.type,
            options = selectedNewSlide.nextSibling,
            input = null;

        selectedNewSlide = null;

        formData.append('type', type);
        formData.append('presentation', presentationId);

        if (options) {

            for (var i = 0; i < options.childElementCount; i++) {

                input = options.children[i].querySelector('input:checked');
                if (input)
                    formData.append(input.dataset.name, input.dataset.value);

            }

        }

        var ajaxData = {
            url: '/slide/add',
            type: 'POST',
            data: formData,
            success: function (response) {

                response = JSON.parse(response);

                pit.notification.notify({
                    type: response.status,
                    message: response.message
                });

                newSlideWrapper.classList.remove('loading');

                if (parseInt(response.code) !== 70) {

                    pit.core.log(response.message, 'error', coreLogPrefix);
                    return false;

                }

                insertAsideSlide_(response.aside, response.slideId);
                insertConfigSlide_(response.config, response.slideId);
                insertSlide_(response.slide, response.slideId);

                changeOrder_('add', response.slideId);
                selectSlide_(response.slideId);

                pit.core.log('New slide with type=' + type + ' has been created', '', coreLogPrefix);
                newSlideModal.close();
                newSlideModal = null;

            },
            error: function (callbacks) {

                pit.core.log('ajax error occur on sending new slide data', 'error', coreLogPrefix, callbacks);
                newSlideWrapper.classList.remove('loading');
                return false;

            }
        };

        pit.ajax.send(ajaxData);

    }


    /**
     * Switch slide - get new ID of selected slide
     * @private
     */
    function switchSlide_() {

        curSlideId = this.parentNode.id.split('_')[1];
        selectSlide_(curSlideId);

    }


    /**
     * Open selected slide in aside + presentation + config areas
     * @private
     */
    function selectSlide_(id) {

        if (document.getElementsByClassName('aside__item--active')[0])
            document.getElementsByClassName('aside__item--active')[0].classList.remove('aside__item--active');

        if (document.getElementsByClassName('config__item--active')[0])
            document.getElementsByClassName('config__item--active')[0].classList.remove('config__item--active');

        if (document.getElementsByClassName('presentation__slide--active')[0]) {

            document.getElementsByClassName('presentation__slide--active')[0].classList.add('presentation__slide--inactive');
            document.getElementsByClassName('presentation__slide--active')[0].classList.remove('presentation__slide--active');

        }

        // set active classes
        document.getElementById('aside_' + id).classList.add('aside__item--active');
        document.getElementById('config_' + id).classList.add('config__item--active');
        document.getElementById('slide_' + id).classList.remove('presentation__slide--inactive');
        document.getElementById('slide_' + id).classList.add('presentation__slide--active');

        pit.cookies.set({
            name: 'cur_slide',
            value: 'presentation~' + window.location.pathname.split('/')[3] + id,
            expires: 21600,
            path: '/'
        });

    }


    /**
     * Open modal form for deleting slide
     * @private
     */
    function openDeleteSlide_() {

        deleteSlideModal = pit.notification.notify({
            type: 'confirm',
            message:    '<div class="delete-slide">' +
                            '<h2 class="">Удаление слайда</h2>' +
                            '<p>Вы уверены что хотите удалить? Удалив слайд у Вас не будет возможности его восстановить.</p>' +
                        '</div>',
            showCancelButton: true,
            confirmText: 'Удалить',
            cancelText: 'Закрыть',
            validation: true,
            confirm: deleteSlide_,
        });

        deletedID = this.id.split('_')[1];

    }


    /**
     * Delete slide from DB and page
     * @private
     */
    function deleteSlide_() {

        var formData = new FormData(),
            deleteWrapper = document.getElementsByClassName('delete-slide')[0];

        formData.append('id', deletedID);
        formData.append('presentation', presentationId);

        var ajaxData = {
            url: '/slide/delete',
            type: 'POST',
            data: formData,
            beforeSend: function () {

                deleteWrapper.classList.add('loading');

            },
            success: function (response) {

                response = JSON.parse(response);

                pit.notification.notify({
                    type: response.status,
                    message: response.message
                });

                deleteWrapper.classList.remove('loading');

                if (parseInt(response.code) !== 73) {

                    pit.core.log(response.message, 'error', coreLogPrefix);
                    return false;

                }

                removeAside_(deletedID);
                removeConfig_(deletedID);
                document.getElementById('slide_' + deletedID).remove();

                if (document.getElementsByClassName('presentation__slide').length === 0)
                    createDefaultSlide_();

                changeOrder_('remove', deletedID);

                pit.core.log('Slide with id=' + deletedID + ' has been deleted', '', coreLogPrefix);
                deleteSlideModal.close();
                deletedID = null;
                deleteSlideModal = null;

            },
            error: function (callbacks) {

                pit.core.log('ajax error occur on deleting slide', 'error', coreLogPrefix, callbacks);
                deleteWrapper.classList.remove('loading');
                return false;

            }
        };

        pit.ajax.send(ajaxData);

    }


    /**
     * Insert aside view of creating slide
     * @param html - HTML String of aside
     * @param sID - slide ID
     * @private
     */
    function insertAsideSlide_(html, sID) {

        var asideEl = pit.draw.node('A', 'aside__item', {id:'aside_' + sID, role:'button'});

        asideEl.innerHTML = '<span class="aside__item-number">' + parseInt(document.getElementsByClassName('js-select-slide').length + 1) + '</span>' +
                            '<span class="aside__item-action">'+
                                '<i id="delete_' + sID + '" class="fa fa-trash aside__item-action-icon text-danger js-delete-slide" aria-hidden="true"></i>' +
                            '</span>' + html;

        asideMenu.appendChild(asideEl);
        document.getElementById('aside_' + sID).getElementsByClassName('js-select-slide')[0].addEventListener('click', switchSlide_);
        document.getElementById('delete_' + sID).addEventListener('click', openDeleteSlide_);

    }


    /**
     * Remove aside item by slide id
     * - change on existed slide
     * @param id - slide ID
     * @private
     */
    function removeAside_(id) {

        document.getElementById('aside_'+id).getElementsByClassName('js-select-slide')[0].removeEventListener('click', switchSlide_);
        document.getElementById('delete_'+id).removeEventListener('click', openDeleteSlide_);

        var changedID = null;

        if (document.getElementById('aside_'+id).classList.contains('aside__item--active') && slidesOrder.length > 1) {

            if (slidesOrder.indexOf(id) === 0) {

                changedID = slidesOrder[1];

            } else {

                changedID = slidesOrder[slidesOrder.indexOf(id) - 1];

            }
            selectSlide_(changedID);

        }

        document.getElementById('aside_'+id).remove();
        updateAsideNumbers_();

    }


    /**
     * Inserting new config area
     * - add listeners on inputs elements
     * @param html - HTML String of config
     * @param sID - slide ID
     * @private
     */
    function insertConfigSlide_(html, sID) {

        var config = pit.draw.node('LI', 'config__item', {id: 'config_' + sID});

        config.innerHTML = html;
        configContent.appendChild(config);

        var inputsArea  = config.getElementsByClassName('js-ajax-edited'),
            bgImage     = config.getElementsByClassName('bg-image'),
            checkbox    = config.getElementsByClassName('checkbox'),
            answer     = config.getElementsByClassName('answer')[0];

        for (var i = 0; i < inputsArea.length; i++) {

            inputsArea[i].addEventListener('keyup', updateFieldData_);

        }

        for (var i = 0; i < bgImage.length; i++) {

            bgImage[i].addEventListener('click', transportBackground_);

        }

        for (var i = 0; i < checkbox.length; i++) {

            checkbox[i].addEventListener('click', updateCheckboxData_);

        }

        if (answer) {

            answer.dataset.answer = choiceAnswers.length;

            var items   = answer.getElementsByClassName('answer__item'),
                options = [];

            for (var j = 0; j < items.length; j++) {

                items[j].getElementsByClassName('js-option-delete')[0].addEventListener('click', removeAnswer_);
                items[j].getElementsByClassName('js-option-delete')[0].dataset.number = j;

                var input = items[j].getElementsByClassName('answer__value')[0],
                    image = items[j].getElementsByClassName('answer__image')[0];

                answer = {
                    'text': '',
                    'image': '',
                };

                input.addEventListener('keyup', updateInputAnswers_);
                input.dataset.number = j;

                if (image) {

                    image.addEventListener('click', transportAnswerImage_);
                    image.dataset.number = j;

                }

                image = input = null;
                options.push(answer);

            }

            choiceAnswers.push(options);

        }

        config      = null;
        inputsArea  = null;
        bgImage     = null;
        checkbox    = null;
        answer      = null;

    }


    /**
     * Remove config area by slide id
     * @param id - slide ID
     * @private
     */
    function removeConfig_(id) {

        var inputsArea  = document.getElementById('config_'+id).getElementsByClassName('js-ajax-edited'),
            bgImage     = document.getElementById('config_'+id).getElementsByClassName('bg-image'),
            checkbox    = document.getElementById('config_'+id).getElementsByClassName('checkbox');

        for (var i = 0; i < inputsArea.length; i++) {

            inputsArea[i].removeEventListener('keyup', updateFieldData_);

        }

        for (var i = 0; i < bgImage.length; i++) {

            bgImage[i].removeEventListener('click', transportBackground_);

        }

        for (var i = 0; i < checkbox.length; i++) {

            checkbox[i].removeEventListener('click', updateCheckboxData_);

        }

        inputsArea  = null;
        bgImage     = null;
        checkbox    = null;

        document.getElementById('config_'+id).remove();

    }


    function insertSlide_(html, sID) {

        var slide         = pit.draw.node('SECTION', 'presentation__slide', {id: 'slide_' + sID}),
            slidesContent = document.getElementsByClassName('presentation__slides')[0],
            defaultSlide  = document.getElementById('defaultSlide');

        if (defaultSlide) {

            defaultSlide.removeEventListener('click', createDefaultSlide_);
            defaultSlide.remove();

        }


        slide.innerHTML = html;
        slidesContent.appendChild(slide);

    }

    /**
     * Updating slides number in aside menu
     * @private
     */
    function updateAsideNumbers_() {

        var asideNumbers = document.getElementsByClassName('aside__item-number');

        for (var i = 0; i < asideNumbers.length; i++) {

            asideNumbers[i].textContent = parseInt(i + 1);

        }

    }


    /**
     * Update Slides order
     * @param action - add || remove slide
     * @param id1
     * @param id2
     * @private
     */
    function changeOrder_(action, id1, id2) {

        switch (action) {
            case 'add':
                slidesOrder.push(parseInt(id1));
                break;
            case 'remove':
                var pos = 0;

                pos = slidesOrder.indexOf(parseInt(id1));
                slidesOrder.splice(pos, 1);
                break;
            default:
                /**
                * TODO менять эдементы местами при смене порядка слайда
                */
                break;
        }

        var formData = new FormData();

        formData.append('presentation', presentationId);
        formData.append('order', JSON.stringify(slidesOrder));

        var ajaxData = {
            url: '/slide/update/order',
            type: 'POST',
            data: formData,
            success: function (response) {

                response = JSON.parse(response);

                if (parseInt(response.code) !== 74) {

                    pit.core.log(response.message, 'error', coreLogPrefix);
                    return false;

                }

            },
            error: function (callbacks) {

                pit.core.log('ajax error occur on deleting slide', 'error', coreLogPrefix, callbacks);
                return false;

            }
        };

        pit.ajax.send(ajaxData);

    }

    /**
     * Transform Presentation Block on Resize
     */
    function transformPresentation_() {

        var winW    = window.innerWidth,
            winH    = window.innerHeight,
            offsetL = winW > 768 ? 220 : 40,
            offsetT = 77,
            scale   = winW > 768 ? (winW - 590) / winW : (winW - 80) / winW;

        present.style.height = winW < 768 ? (winW - 80) * 3 /4 + 'px' : '';
        present.style.transform = 'scale(' + scale + ') translateY(' + offsetT / scale +'px) translateX(' + offsetL / scale + 'px)';

    }


    /**
     * Update Field of input || textarea areas
     * @private
     */
    function updateFieldData_(el) {

        if (el.nodeType !== 1)
            el = this;

        var formData = new FormData(),
            name     = el.dataset.name,
            value    = el.value,
            slideId  = el.closest('.config__item').id.split('_')[1];

        if (name === 'heading')
            document.getElementById('aside_' + slideId).getElementsByClassName('aside__item-name')[0].textContent = value !== '' ? value : el.placeholder;

        formData.append('id', slideId);
        formData.append('name', name);
        formData.append('value', value);

        var ajaxData = {
            url: '/slide/update/field',
            type: 'POST',
            data: formData,
            beforeSend: function () {

                configStatus.classList.remove('config__status--error');
                configStatus.classList.add('config__status--updating');

            },
            success: function (response) {

                response = JSON.parse(response);
                configStatus.classList.remove('config__status--updating');
                if (parseInt(response.code) !== 76) {

                    pit.notification.notify({
                        type: 'warning',
                        message: response.message
                    });
                    pit.core.log(response.message, 'warning', coreLogPrefix);
                    configStatus.classList.add('config__status--error');
                    return false;

                }

                document.getElementById('slide_' + slideId).innerHTML = response.slide;

            },
            error: function (callbacks) {

                pit.core.log('ajax error occur on updating field of slide content', 'error', coreLogPrefix, callbacks);
                configStatus.classList.remove('config__status--updating');
                configStatus.classList.add('config__status--error');
                return false;

            }
        };

        pit.ajax.send(ajaxData);

    }


    /**
     * Update Checkbox Fields
     * @private
     */
    function updateCheckboxData_() {

        if(this.checked)
            this.value = this.dataset.value;
        else
            this.value = 0;

        updateFieldData_(this);

    }


    /**
     * Toggle Editing Area for Editing Presentation Name
     * @private
     */
    function toggleTitle_() {

        presentationName.classList.toggle('hide');
        editPresentNameBtn.classList.toggle('hide');
        editPresentNameFrom.classList.toggle('hide');

    }


    /**
     * Save Presentation Name -> send to DB
     * @private
     */
    function saveTitle_() {

        toggleTitle_();
        var formData = new FormData();

        formData.append('id', presentationId);
        formData.append('name', editPresentNameInput.value);

        var ajaxData = {
            url: '/presentation/editname',
            type: 'POST',
            data: formData,
            beforeSend: function () {

                configStatus.classList.remove('config__status--error');
                configStatus.classList.add('config__status--updating');

            },
            success: function (response) {

                response = JSON.parse(response);
                configStatus.classList.remove('config__status--updating');
                if (parseInt(response.code) !== 54) {

                    pit.notification.notify({
                        type: response.type,
                        message: response.message
                    });
                    pit.core.log(response.message, response.type, coreLogPrefix);
                    configStatus.classList.add('config__status--error');
                    return false;

                }

                presentationName.innerHTML = editPresentNameInput.value;
                document.getElementsByTagName('title')[0].innerHTML = editPresentNameInput.value + ' | Prezentit';

            },
            error: function (callbacks) {

                pit.core.log('ajax error occur on updating presentation name', 'error', coreLogPrefix, callbacks);
                configStatus.classList.remove('config__status--updating');
                configStatus.classList.add('config__status--error');
                return false;

            }
        };

        pit.ajax.send(ajaxData);

    }


    /**
     * Send Background Image
     * @private
     */
    function transportBackground_() {

        var id     = this.closest('.config__item').id.split('_')[1],
            block  = this,
            holder = this.getElementsByClassName('bg-image__image')[0];

        pit.transport.init({
            url : '/transport/1',
            beforeSend : function () {

                var fileReader = new FileReader(),
                    input = pit.transport.getInput(),
                    file = input.files[0];

                fileReader.readAsDataURL(file);
                block.classList.add('bg-image--with-image');
                configStatus.classList.remove('config__status--error');
                configStatus.classList.add('config__status--updating');
                fileReader.onload = function (event) {

                    holder.classList.add('bg-image--loading');
                    holder.src = event.target.result;

                };

            },
            success : function (response) {

                response = JSON.parse(response);
                configStatus.classList.remove('config__status--updating');

                pit.notification.notify({
                    type: response.status,
                    message: response.message
                });

                if (parseInt(response.code) === 88) {

                    holder.src = response.icon_url;
                    holder.classList.remove('bg-image--loading');
                    block.removeEventListener('click', transportBackground_);
                    block.addEventListener('click', removeBackground_);
                    block.value = response.name;
                    updateFieldData_(block);

                } else {

                    block.classList.remove('bg-image--with-image');
                    configStatus.classList.add('config__status--error');
                    return false;

                }

            },
            error : function (callbacks) {

                pit.core.log('ajax error occur on updating background', 'error', coreLogPrefix, callbacks);
                configStatus.classList.remove('config__status--updating');
                configStatus.classList.add('config__status--error');
                return false;

            }
        });

    }


    /**
     * Remove Background Image
     * @private
     */
    function removeBackground_() {

        var block    = this,
            holder   = this.getElementsByClassName('bg-image__image')[0];

        block.classList.remove('bg-image--with-image');
        block.removeEventListener('click', removeBackground_);
        block.addEventListener('click', transportBackground_);
        block.value = '';

        holder.src = '/';

        updateFieldData_(block);

    }


    /**
     * Remove answer from answers list
     * @private
     */
    function removeAnswer_() {

        var answer  = this.closest('.answer'),
            number  = parseInt(this.dataset.number);

        if (choiceAnswers[answer.dataset.answer].length <= 2) {

            pit.notification.notify({
                type: 'warning',
                message: 'Минимальное количество ответов - 2'
            });
            return false;

        }

        if (answer.dataset.image === 'true')
            this.removeEventListener('click', transportAnswerImage_);

        answer.getElementsByTagName('input')[number].removeEventListener('keyup', updateInputAnswers_);
        answer.getElementsByClassName('js-option-delete')[number].removeEventListener('click', removeAnswer_);

        for ( var i = number + 1; i < choiceAnswers[answer.dataset.answer].length; i++) {

            var elements = answer.querySelectorAll('[data-number="' + i + '"]');

            for (var j = 0; j < elements.length; j++) {

                elements[j].dataset.number = i - 1;

            }

        }

        choiceAnswers[answer.dataset.answer].splice(number, 1);
        answer.querySelector('.answer__item:nth-child(' + ( number + 1) + ')').remove();

        answer.getElementsByClassName('js-answers-json')[0].value = JSON.stringify(choiceAnswers[answer.dataset.answer]);

        updateFieldData_(answer.getElementsByClassName('js-answers-json')[0]);

    }


    /**
     * Add answer to answers list
     * @private
     */
    function addAnswer_() {

        var answer  = this.closest('.answer');

        if (choiceAnswers[answer.dataset.answer].length >= 8) {

            pit.notification.notify({
                type: 'warning',
                message: 'Макисмальное количество ответов - 8'
            });
            return false;

        }

        var block = pit.draw.node('LI', 'form-group__control-group answer__item');

        block.innerHTML = '<input type="text" class="form-group__control form-group__control-group-input answer__value input-with-counter" maxlength="60" data-number="' + choiceAnswers[answer.dataset.answer].length + '">';

        if (answer.dataset.image === 'true')
            block.innerHTML += '<a class="form-group__control-group-addon b-l-0 answer__image " title="Картинка ответа" data-number="' + choiceAnswers[answer.dataset.answer].length + '">' +
                '<i class="fa fa-image bg-image__icon" aria-hidden="true"></i>' +
                '<i class="fa fa-close bg-image__close" aria-hidden="true"></i>' +
                '<img src="/" class="bg-image__image" data-src="">' +
                '</a>';

        block.innerHTML += '<a class="form-group__control-group-addon js-option-delete" data-number="' + choiceAnswers[answer.dataset.answer].length + '">' +
            '<i class="fa fa-trash" aria-hidden="true"></i>' +
            '</a>';

        if (answer.dataset.image === 'true')
            block.getElementsByClassName('answer__image')[0].addEventListener('click', transportAnswerImage_);

        block.getElementsByTagName('input')[0].addEventListener('keyup', updateInputAnswers_);
        pit.form.createCounter(block.getElementsByTagName('input')[0], 60);

        block.getElementsByClassName('js-option-delete')[0].addEventListener('click', removeAnswer_);

        answer.getElementsByClassName('answer__list')[0].appendChild(block);

        choiceAnswers[answer.dataset.answer].push({
            'text': '',
            'image': '',
        });

        answer.getElementsByClassName('js-answers-json')[0].value = JSON.stringify(choiceAnswers[answer.dataset.answer]);

        updateFieldData_(answer.getElementsByClassName('js-answers-json')[0]);

    }


    /**
     * Transport answer image
     * @private
     */
    function transportAnswerImage_() {

        var answer  = this.closest('.answer'),
            image   = this.dataset.number,
            block   = this,
            holder  = this.getElementsByClassName('bg-image__image')[0];

        pit.transport.init({
            url : '/transport/2',
            beforeSend : function () {

                var fileReader = new FileReader(),
                    input = pit.transport.getInput(),
                    file = input.files[0];

                fileReader.readAsDataURL(file);
                block.classList.add('bg-image--with-image');
                configStatus.classList.remove('config__status--error');
                configStatus.classList.add('config__status--updating');

                fileReader.onload = function (event) {

                    holder.classList.add('bg-image--loading');
                    holder.src = event.target.result;

                };

            },
            success : function (response) {

                response = JSON.parse(response);
                configStatus.classList.remove('config__status--updating');

                pit.notification.notify({
                    type: response.status,
                    message: response.message
                });

                if (parseInt(response.code) === 88) {

                    holder.src = response.icon_url;
                    holder.classList.remove('bg-image--loading');
                    block.removeEventListener('click', transportAnswerImage_);
                    block.addEventListener('click', removeAnswerImage_);
                    choiceAnswers[answer.dataset.answer][image].image = response.name;

                    answer.getElementsByClassName('js-answers-json')[0].value = JSON.stringify(choiceAnswers[answer.dataset.answer]);
                    updateFieldData_(answer.getElementsByClassName('js-answers-json')[0]);

                } else {

                    block.classList.remove('bg-image--with-image');
                    configStatus.classList.add('config__status--error');
                    return false;

                }

            },
            error : function (callbacks) {

                pit.core.log('ajax error occur on updating answer image', 'error', coreLogPrefix, callbacks);
                configStatus.classList.remove('config__status--updating');
                configStatus.classList.add('config__status--error');
                return false;

            }
        });

    }


    /**
     * Remove answer image
     * @private
     */
    function removeAnswerImage_() {

        var answer  = this.closest('.answer'),
            block   = this,
            image   = this.dataset.number;

        block.classList.remove('bg-image--with-image');
        block.removeEventListener('click', removeAnswerImage_);
        block.addEventListener('click', transportAnswerImage_);
        choiceAnswers[answer.dataset.answer][image].image = '';

        answer.getElementsByClassName('js-answers-json')[0].value = JSON.stringify(choiceAnswers[answer.dataset.answer]);

        updateFieldData_(answer.getElementsByClassName('js-answers-json')[0]);

    }


    /**
     * Update answer text
     * @private
     */
    function updateInputAnswers_() {

        var answer = this.closest('.answer'),
            input  = this.dataset.number;

        choiceAnswers[answer.dataset.answer][input].text = this.value;

        answer.getElementsByClassName('js-answers-json')[0].value = JSON.stringify(choiceAnswers[answer.dataset.answer]);

        updateFieldData_(answer.getElementsByClassName('js-answers-json')[0]);

    }


    /**
     * Listener for checkbox answer-with-image
     * @private
     */
    function answerWithImage_() {

        if (this.checked)
            answerWithImageBuild_(this.closest('.config__item').getElementsByClassName('answer__item'));
        else
            answerWithImageDestroy_(this.closest('.config__item').getElementsByClassName('answer__item'));

    }


    /**
     * Build answer-with-image
     * @param elements - all answers
     * @private
     */
    function answerWithImageBuild_(elements) {

        elements[0].closest('.answer').dataset.image = true;

        var element = null;

        for (var i = 0; i < elements.length; i++) {

            element = pit.draw.node('A', 'form-group__control-group-addon b-l-0 answer__image ', {title:'Картинка ответа', 'data-number': i});
            element.innerHTML = '<i class="fa fa-image bg-image__icon" aria-hidden="true"></i>'+
                '<i class="fa fa-close bg-image__close" aria-hidden="true"></i>'+
                '<img src="/" class="bg-image__image" data-src="">';

            pit.core.insertBefore(elements[i].getElementsByClassName('js-option-delete')[0], element);
            element.addEventListener('click', transportAnswerImage_);
            element = null;

        }

    }


    /**
     * Destroy answer-with-image
     * @param elements - all answers
     * @private
     */
    function answerWithImageDestroy_(elements) {

        elements[0].closest('.answer').dataset.image = false;

        var answer = elements[0].closest('.answer');

        for (var i = 0; i < choiceAnswers[answer.dataset.answer].length; i++) {

            elements[i].getElementsByClassName('answer__image')[0].removeEventListener('click', transportAnswerImage_);
            elements[i].getElementsByClassName('bg-image__image')[0].dataset.src = '';
            elements[i].getElementsByClassName('answer__image')[0].remove();
            choiceAnswers[answer.dataset.answer][i].image = '';

        }

        answer.getElementsByClassName('js-answers-json')[0].value = JSON.stringify(choiceAnswers[answer.dataset.answer]);

        updateFieldData_(answer.getElementsByClassName('js-answers-json')[0]);

    }



    /**
     * Edit Presentation Name -> open form for editing
     * @private
     */
    function editTitle_() {

        toggleTitle_();
        editPresentNameInput.value =presentationName.innerHTML;
        editPresentNameInput.focus();

    }



    editPresent.init = function () {

        var isLoad =  prepareHeader_() === prepareNewSlide_() === prepareSlides_() === prepareAside_() === prepareConfig_() === prepareChoiceOptions_();

        if (isLoad)
            pit.core.log('Module loaded', 'log', coreLogPrefix);
        else
            pit.core.log('Module has not loaded', 'error', coreLogPrefix);

    };

    return editPresent;

}({});