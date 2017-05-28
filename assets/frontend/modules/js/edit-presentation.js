let editPresent = function (editPresent) {

    let coreLogPrefix            = "edit-presentation",
        present                  = null,
        presentationName         = null,
        presentationId           = null,
        editPresentNameBtn       = null,
        editPresentNameFrom      = null,
        editPresentNameInput     = null,
        editPresentNameBtnSubmit = null,
        newSlideBtn              = null,
        newSlideModal            = null,
        newSlideBlocks           = null,
        selectedNewSlide         = null,
        asideMenu                = null,
        configContent            = null,
        deleteSlideModal         = null,
        deleted_id               = null,
        slides_order             = null,
        slidesHash               = null,
        curSlideId               = null,
        configStatus             = null,
        editedFields             = null;


    const newSlidesContent = [
        {
            'type': 1,
            'name': 'Заголовок',
            'icon': 'fa-header',
            'image': 'heading_ru.png'
        },{
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
                },{
                    'id': 'image_position_full',
                    'type': 'radio',
                    'name': '2_image_position',
                    'data_name': 'image_position',
                    'data_value': '2',
                    'title': 'Изображение на весь слайд'
                }
            ]
        },{
            'type': 3,
            'name': 'Параграф',
            'icon': 'fa-paragraph',
            'image': 'paragraph_ru.png'
        },{
            'type': 4,
            'name': 'Слайд с вопросом',
            'icon': 'fa-bar-chart',
            'image': 'choices_ru.png',
            'options' : [
                {
                    'id': '4_answers_with_image',
                    'type': 'checkbox',
                    'name': '4_answers_with_image',
                    'data_name': 'answers_with_image',
                    'data_value': '1',
                    'title': 'Ответы с изображением'
                },{
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


    /**
     * Prepare Heading For Editing Presentation Name
     * @private
     */
    let prepareHeader_ = function () {
       presentationName = document.getElementById('PresentName');
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

        present         = document.getElementsByClassName('presentation')[0];
        newSlideBtn     = document.getElementById('newSlide');
        presentationId  = document.getElementById('presentation_id').value;
        slides_order    = document.getElementById('slides_order').value === '' ? [] : document.getElementById('slides_order').value.split(',');
        configStatus    = document.getElementsByClassName('config__status')[0];
        slidesHash      = location.pathname.split('/')[3];
        configContent   = document.getElementById('configContent');
        asideMenu = document.getElementsByClassName('aside__menu')[0];
        editedFields    = document.getElementsByClassName('js-ajax-edited');

        if (newSlideBtn) {
            newSlideBtn.addEventListener('click', openNewSlideForm_);
        }

        transformPresentation();
        window.addEventListener('resize', transformPresentation);

        for (let i = 0; i < editedFields.length; i++) {
            editedFields[i].addEventListener('keyup', updateFieldData_);
        }

    };


    let prepareAside_ = function () {
        let asideSelectBtns = document.getElementsByClassName('js-select-slide'),
            asideDeleteBtns = document.getElementsByClassName('js-delete-slide'),
            existCurSlideId = false;

        if (pit.cookies.get('cur_slide') && pit.cookies.get('cur_slide').match(new RegExp(slidesHash))) {
            curSlideId = parseInt(pit.cookies.get('cur_slide').replace(location.pathname.split('/')[3], ''));
        }

        for ( let i = 0; i < asideSelectBtns.length; i++) {
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
                    value: 'presentation~' + location.pathname.split('/')[3] + curSlideId,
                    expires: 21600,
                    path: '/'
                });
            }

            selectSlide_(curSlideId);
        }

    };


    /**
     * Open New Slide On Click `newSlideBtn`
     * @private
     */
    let openNewSlideForm_ = function () {

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
        let closeNewSlideBlocksBtn = document.getElementsByClassName('new-slide__close-icon');
        for(let i = 0; i < newSlideBlocks .length; i++) {
            newSlideBlocks[i].addEventListener('click', selectNewSlide_);
            closeNewSlideBlocksBtn[i].addEventListener('click', closeNewSlide_);
        }
        
    };


    /**
     * Create New Slides Blocks for Creating New Slide
     * @returns {string}
     * @private
     */
    let getNewSlidesContent_ = function () {
        let outStr = "", optStrOpt;
        for(let i = 0; i < newSlidesContent.length; i++) {
            optStrOpt = "";
            outStr +=   '<div class="new-slide__block" data-type="' + newSlidesContent[i].type + '">' +
                            '<i class="fa fa-close new-slide__close-icon" aria-hidden="true"></i>' +
                            '<div class="new-slide__content">' +
                                '<p class="new-slide__name">' + newSlidesContent[i].name +'</p>' +
                                '<img class="new-slide__image" src="/assets/static/img/slides/types/' + newSlidesContent[i].image + '">'+
                                '<i class="fa ' + newSlidesContent[i].icon + ' new-slide__icon" aria-hidden="true"></i>' +
                            '</div>';


            if ( newSlidesContent[i].options !== undefined ) {
                optStrOpt +=   '<div class="new-slide__options-wrapper">';

                for (let j = 0; j < newSlidesContent[i].options.length; j++) {
                    optStrOpt +=    '<div class="new-slide__option">' +
                                        '<input type="' + newSlidesContent[i].options[j].type +'" id="' + newSlidesContent[i].options[j].id +'" name="' + newSlidesContent[i].options[j].name +'" data-name="' + newSlidesContent[i].options[j].data_name + '" data-value="' + newSlidesContent[i].options[j].data_value + '" class="checkbox">' +
                                        '<label for="' + newSlidesContent[i].options[j].id +'" class="checkbox-label">' + newSlidesContent[i].options[j].title +'</label>' +
                                    '</div>';
                }

                optStrOpt += '</div>';

            }

            outStr += optStrOpt+ '</div>'

        }
        return outStr;
    };

    /**
     * Select New Slide - open options which slide has
     * @private
     */
    let selectNewSlide_ = function () {
        selectedNewSlide = this;
        for(let i = 0; i < newSlideBlocks .length; i++) {
            newSlideBlocks[i].parentNode.classList.add('hide');
        }
        selectedNewSlide.parentNode.classList.remove('hide');
        selectedNewSlide.removeEventListener('click', selectNewSlide_);
        selectedNewSlide.parentNode.classList.add('new-slide__block--selected');
    };


    /**
     * Close Selected New Slide - returns to selecting slide type
     * @private
     */
    let closeNewSlide_ = function () {
        selectedNewSlide.addEventListener('click', selectNewSlide_);
        selectedNewSlide.parentNode.classList.remove('new-slide__block--selected');
        selectedNewSlide = null;
        for (let i = 0; i < newSlideBlocks .length; i++) {
            newSlideBlocks[i].parentNode.classList.remove('hide');
        }
    };


    /**
     * Drop New Slide Form
     * @private
     */
    let dropNewSlide_ = function () {
        for(let i = 0; i < newSlideBlocks .length; i++) {
            newSlideBlocks[i].removeEventListener('click', selectNewSlide_)
        }
        newSlideBlocks = null;
    };


    /**
     * Submit Creating New Slide
     * @private
     */
    let createNewSlide_ = function () {

        if (selectedNewSlide === null) {
            pit.notification.notify({message:"Пожалуйста выберите тип слайда", type:"error"});
            pit.core.log('New slide type has not chosen', 'error', coreLogPrefix);
            return false;
        }

        let newSlideWrapper = document.getElementsByClassName('new-slide')[0];
        newSlideWrapper.classList.add('loading');

        let formData = new FormData(),
            type = selectedNewSlide.parentNode.dataset.type,
            options = selectedNewSlide.nextSibling,
            input = null;

        selectedNewSlide = null;

        formData.append('type', type);
        formData.append('presentation', presentationId);

        if (options) {
            for (let i = 0; i < options.childElementCount; i++) {
                input = options.children[i].querySelector('input:checked');
                if (input)
                    formData.append(input.dataset.name, input.dataset.value);
            }
        }

        let ajaxData = {
            url: '/slide/add',
            type: 'POST',
            data: formData,
            success: function(response) {
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

                changeOrder_('add', response.slideId);
                selectSlide_(response.slideId);

                pit.core.log('New slide with type=' + type + ' has been created', '', coreLogPrefix);
                newSlideModal.close();
                newSlideModal = null;
            },
            error: function(callbacks) {
                pit.core.log('ajax error occur on sending new slide data','error',coreLogPrefix, callbacks);
                newSlideWrapper.classList.remove('loading');
                return false;
            }
        };

        pit.ajax.send(ajaxData);
    };


    /**
     * Switch slide - get new ID of selected slide
     * @private
     */
    let switchSlide_ = function () {

        curSlideId = this.parentNode.id.split('_')[1];
        selectSlide_(curSlideId);

    };


    /**
     * Open selected slide in aside + presentation + config areas
     * @private
     */
    let selectSlide_ = function (id) {

        if (document.getElementsByClassName('aside__item--active')[0])
            document.getElementsByClassName('aside__item--active')[0].classList.remove('aside__item--active');

        if (document.getElementsByClassName('config__item--active')[0])
            document.getElementsByClassName('config__item--active')[0].classList.remove('config__item--active');

        // set active classes
        document.getElementById('aside_' + id).classList.add('aside__item--active');
        document.getElementById('config_' + id).classList.add('config__item--active');

        pit.cookies.set({
            name: 'cur_slide',
            value: 'presentation~' + location.pathname.split('/')[3] + id,
            expires: 21600,
            path: '/'
        });

    };


    /**
     * Open modal form for deleting slide
     * @private
     */
    let openDeleteSlide_ = function () {
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

        deleted_id = this.id.split('_')[1];
    };


    /**
     * Delete slide from DB and page
     * @private
     */
    let deleteSlide_ = function () {

        let formData = new FormData(),
            deleteWrapper = document.getElementsByClassName('delete-slide')[0];

        formData.append('id', deleted_id);
        formData.append('presentation', presentationId);

        let ajaxData = {
            url: '/slide/delete',
            type: 'POST',
            data: formData,
            beforeSend: function(){
                deleteWrapper.classList.add('loading');
            },
            success: function(response) {
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

                removeAside_(deleted_id);
                removeConfig_(deleted_id);

                changeOrder_('remove', deleted_id);

                pit.core.log('Slide with id=' + deleted_id + ' has been deleted', '', coreLogPrefix);
                deleteSlideModal.close();
                deleted_id = null;
                deleteSlideModal = null;
            },
            error: function(callbacks) {
                pit.core.log('ajax error occur on deleting slide','error', coreLogPrefix, callbacks);
                deleteWrapper.classList.remove('loading');
                return false;
            }
        };

        pit.ajax.send(ajaxData);
    };


    /**
     * Insert aside view of creating slide
     * @param html - HTML String of aside
     * @param s_id - slide ID
     * @private
     */
    let insertAsideSlide_ = function (html, s_id) {
        let asideEl = pit.draw.node('A','aside__item', {id:'aside_' + s_id,role:'button'});
        asideEl.innerHTML = '<span class="aside__item-number">' + parseInt(document.getElementsByClassName('js-select-slide').length + 1) + '</span>' +
                            '<span class="aside__item-action">'+
                                '<i id="delete_' + s_id + '" class="fa fa-trash aside__item-action-icon text-danger js-delete-slide" aria-hidden="true"></i>' +
                            '</span>' + html;

        asideMenu.appendChild(asideEl);
        document.getElementById('aside_' + s_id).getElementsByClassName('js-select-slide')[0].addEventListener('click', switchSlide_);
        document.getElementById('delete_' + s_id).addEventListener('click', openDeleteSlide_);
    };


    /**
     * Remove aside item by slide id
     * - change on existed slide
     * @param id - slide ID
     * @private
     */
    let removeAside_ = function (id) {
        document.getElementById('aside_'+id).getElementsByClassName('js-select-slide')[0].removeEventListener('click', switchSlide_);
        document.getElementById('delete_'+id).removeEventListener('click', deleteSlide_);
        let changed_id = null;
        if (document.getElementById('aside_'+id).classList.contains('aside__item--active') && slides_order.length > 1) {
            if (slides_order.indexOf(id) === 0) {
                changed_id = slides_order[1];
            } else {
                changed_id = slides_order[slides_order.indexOf(id) - 1];
            }
            selectSlide_(changed_id);
        }
        document.getElementById('aside_'+id).remove();
        updateAsideNumbers_();
    };


    /**
     * Inserting new config area
     * - add listeners on inputs elements
     * @param html - HTML String of config
     * @param s_id - slide ID
     * @private
     */
    let insertConfigSlide_ = function (html, s_id) {
        let config = pit.draw.node('LI', 'config__item', {id: 'config_' + s_id});
        config.innerHTML = html;
        configContent.appendChild(config);

        let inputsArea = config.getElementsByClassName('js-ajax-edited');

        for (let i = 0; i < inputsArea.length; i++) {
            inputsArea[i].addEventListener('keyup', updateFieldData_);
        }


        config = null;
        inputsArea = null;
    };


    /**
     * Remove config area by slide id
     * @param id - slide ID
     * @private
     */
    let removeConfig_ = function (id) {
        let inputsArea = document.getElementById('config_'+id).getElementsByClassName('js-ajax-edited');

        for (let i = 0; i < inputsArea.length; i++) {
            inputsArea[i].removeEventListener('keyup', updateFieldData_);
        }

        document.getElementById('config_'+id).remove();
    };


    /**
     * Updating slides number in aside menu
     * @private
     */
    let updateAsideNumbers_ = function () {
        let asideNumbers = document.getElementsByClassName('aside__item-number');
        for (let i = 0; i < asideNumbers.length; i++) {
            asideNumbers[i].textContent = parseInt(i + 1);
        }
    };


    /**
     * Update Slides order
     * @param action - add || remove slide
     * @param id1
     * @param id2
     * @private
     */
    let changeOrder_ = function (action, id1, id2) {
        switch (action) {
            case 'add':
                slides_order.push(id1);
                break;
            case 'remove':
                let pos = 0;
                pos = slides_order.indexOf(id1);
                slides_order.splice(pos, 1);
                break;
            default:
                /**
                * TODO менять эдементы местами при смене порядка слайда
                */
                break;
        }

        let formData = new FormData();
        formData.append('presentation', presentationId);
        formData.append('order', slides_order.join(','));

        let ajaxData = {
            url: '/slide/update/order',
            type: 'POST',
            data: formData,
            success: function(response) {
                response = JSON.parse(response);

                if (parseInt(response.code) !== 74) {
                    pit.core.log(response.message, 'error', coreLogPrefix);
                    return false;
                }
            },
            error: function(callbacks) {
                pit.core.log('ajax error occur on deleting slide','error', coreLogPrefix, callbacks);
                return false;
            }
        };

        pit.ajax.send(ajaxData);

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
     * Update Field of input || textarea areas
     * @private
     */
    let updateFieldData_ = function () {
        let formData = new FormData(),
            name     = this.dataset.name,
            value    = this.value,
            slideId  = this.closest('.config__item').id.split('_')[1];

        if (name === 'heading')
            document.getElementById('aside_' + slideId).getElementsByClassName('aside__item-name')[0].textContent = value !== "" ? value : this.placeholder;

        formData.append('id', slideId);
        formData.append('name', name);
        formData.append('value', value);

        let ajaxData = {
            url: '/slide/update/field',
            type: 'POST',
            data: formData,
            beforeSend: function () {
                configStatus.classList.remove('config__status--error');
                configStatus.classList.add('config__status--updating')
            },
            success: function(response) {
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

            },
            error: function(callbacks) {
                pit.core.log('ajax error occur on updating field of slide content','error', coreLogPrefix, callbacks);
                configStatus.classList.remove('config__status--updating');
                configStatus.classList.add('config__status--error');
                return false;
            }
        };

        pit.ajax.send(ajaxData);

    };


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
        let formData = new FormData();
        formData.append('id', presentationId);
        formData.append('name', editPresentNameInput.value);

        let ajaxData = {
            url: '/presentation/editname',
            type: 'POST',
            data: formData,
            beforeSend: function () {
                configStatus.classList.remove('config__status--error');
                configStatus.classList.add('config__status--updating')
            },
            success: function(response) {
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
                document.getElementsByTagName('title')[0].innerHTML = editPresentNameInput.value + " | Prezentit";

            },
            error: function(callbacks) {
                pit.core.log('ajax error occur on updating presentation name','error', coreLogPrefix, callbacks);
                configStatus.classList.remove('config__status--updating');
                configStatus.classList.add('config__status--error');
                return false;
            }
        };

        pit.ajax.send(ajaxData);

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
        prepareHeader_();
        prepare_();
        prepareAside_();


        pit.core.log("Module loaded",'log',coreLogPrefix);
    };

    return editPresent;

}({});