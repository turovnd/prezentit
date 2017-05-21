let allPresent = function (allPresent) {

    let coreLogPrefix       = "all-presentations",
        newPresentBtn       = null,
        deletePresentBtns   = null,
        newPresentModal     = null,
        deletePresentModal  = null,
        noResults           = null,
        noItems             = null,
        presentID           = null,
        presentRow          = null,
        deleteClickBtn      = null,
        searchPresentInput  = null,
        presentations       = [],
        sharePresentModal   = null;

    let preparePresentations_ = function () {

        moment.locale('ru');

        noResults = pit.draw.node('tr','',{ id: "noResult"});
        noResults.innerHTML = '<td colspan="3" style="text-align: center; padding: 20px 8px; border-bottom: 1px solid #e5e5e5;">К сожалению, ничего ненеайдено. Попробуйте изменить запрос</td>';

        noItems = pit.draw.node('tr','',{id:"noItems"});
        noItems.innerHTML = '<td colspan="3" style = "text-align: center; padding: 20px 8px; border-bottom: 1px solid #e5e5e5;">Презентации ещё не созданы <i style="margin-left: 2px; font-size: 1.3em" class="fa fa-frown-o" aria-hidden="true"></i></td>';


        let presentation, time,
            rows = document.getElementsByClassName('presentations__row');

        for (let i = 0; i < rows.length; i++) {
            presentation = {
                row: rows[i],
                name: rows[i].getElementsByClassName('presentations__title')[0].getElementsByTagName('a')[0].innerHTML.toLowerCase()
            };
            presentations.push(presentation);

            time = rows[i].getElementsByClassName('presentations__time')[0];
            time.innerHTML = lastUpdate_(time.innerHTML);
        }

        checkOnNoPresentation_();

        searchPresentInput = document.getElementById('searchPresentInput');

        if (searchPresentInput)
            searchPresentInput.addEventListener('keyup', searchPresent_);

        newPresentBtn = document.getElementById('newPresent');

        if (newPresentBtn)
            newPresentBtn.addEventListener('click', openNewPresentModal_);


        let deletePresentBtns = document.getElementsByClassName('presentation__delete');
        for (let i = 0; i < deletePresentBtns.length; i++) {
            deletePresentBtns[i].addEventListener('click', openDeletePresentModal_);
        }

    };
    
    
    let prepareMobileMenu_ = function () {
        let toggleAction = document.getElementsByClassName('presentations__actions-toggle'),
            closeAction = document.getElementsByClassName('presentations__actions-close'),
            sharePresent = document.getElementsByClassName('presentation__share'),
            sharePresentMobile = document.getElementsByClassName('presentation__share-mobile');

        for (let i = 0; i < toggleAction.length; i++) {
            toggleAction[i].addEventListener('click', openMobileActions_);
            closeAction[i].addEventListener('click', closeMobileActions_);
            sharePresent[i].addEventListener('click', sharePresentModal_);
            sharePresentMobile[i].addEventListener('click', sharePresentModal_);
        }
    };


    /**
     * Searching presentation on page
     * @private
     */
    let searchPresent_ = function () {
        let searchingText = new RegExp(this.value.toLowerCase()),
            shownPresent = 0;

        for (let i = 0; i < presentations.length; i++) {

            if ( searchingText.test(presentations[i].name) ) {

                presentations[i].row.classList.remove('hide');
                shownPresent++;

            } else {

                presentations[i].row.classList.add('hide');

            }

            if ( shownPresent === 0 ) {
                document.getElementsByClassName('presentations__body')[0].appendChild(noResults);
            } else if ( document.getElementById('noResult')) {
                document.getElementById('noResult').remove();
            }

        }

    };


    /**
     * Format Date using moment.js
     * @param date - date from DB
     * @returns String
     * @private
     */
    let lastUpdate_ = function (date) {
        date = new Date(date);

        if ( new Date() - date < 259200000) {
            return moment(date).fromNow();
        } else {
            return moment(date).format('DD MMM YYYY');
        }
    };


    /**
     * Open modal for creating presentation
     * @private
     */
    let openNewPresentModal_ = function () {
        newPresentModal = pit.notification.notify({
            type: 'confirm',
            message: '<div class="new-present"> ' +
                        '<h2>Новая презентация</h2>'+
                        '<div class="form-group">' +
                            '<input id="newPresentFormName" class="form-group__control" type="text" name="name" placeholder="Введите название презентации">' +
                        '</div>' +
                    '</div>',
            showCancelButton: true,
            validation: true,
            confirmText: 'Создать',
            confirm: createPresent_
        });
    };


    /**
     * Submit creating new presentation
     * @private
     */
    let createPresent_ = function () {

        let formData = new FormData(),
            newPresentWrapper = document.getElementsByClassName('new-present')[0];

        formData.append('name', document.getElementById('newPresentFormName').value);
        formData.append('csrf', document.getElementById('newPresentFormCSRF').value);

        let ajaxData = {
            url: '/presentation/new',
            type: 'POST',
            data: formData,
            beforeSend: function(){
                newPresentWrapper.classList.add('loader');
            },
            success: function(response) {
                response = JSON.parse(response);

                pit.notification.notify({
                    type: response.status,
                    message: response.message
                });

                if (parseInt(response.code) !== 50) {
                    pit.core.log(response.message, 'error', coreLogPrefix);
                    return false;
                }

                newPresentModal.close();
                newPresentModal = null;
                window.history.pushState('App', window.location.protocol + '//' + window.location.host + '/app');
                window.location.replace(window.location.protocol + '//' + window.location.host + '/app/s/' + response.uri + '/edit');
                newPresentWrapper.classList.remove('loader');
            },
            error: function(callbacks) {
                pit.core.log('ajax error occur on creating presentation','error', coreLogPrefix, callbacks);
                newPresentWrapper.classList.remove('loader');
            }
        };

        pit.ajax.send(ajaxData);

    };


    /**
     * Open modal for deleting presentation
     * @private
     */
    let openDeletePresentModal_ = function () {

        presentRow = this.parentNode.parentNode;
        deleteClickBtn = this;
        presentID = this.dataset.id;

        deletePresentModal = pit.notification.notify({
            type: 'confirm',
            message: '<h2>Подтверждение удаления</h2><p>После удаления, у Вас не будет способа восстановить презентацию!</p>',
            showCancelButton: true,
            validation: true,
            confirmText: 'Удалить',
            confirm: deletePresent_
        });
    };

    /**
     * Submit deleting presentation
     * @private
     */
    let deletePresent_ = function() {

        let formData = new FormData(),
            deleteWrapper = document.getElementsByClassName('notification--confirm')[0];

        formData.append('id', presentID);

        let ajaxData = {
            url: '/presentation/delete',
            type: 'POST',
            data: formData,
            beforeSend: function () {
                deleteWrapper.classList.add('loading')
            },
            success: function (response) {
                response = JSON.parse(response);

                pit.notification.notify({
                    type: response.status,
                    message: response.message
                });

                deleteWrapper.classList.remove('loading');

                if (parseInt(response.code) !== 52) {
                    pit.core.log(response.message, 'error', coreLogPrefix);
                    return false;
                }

                pit.core.log('Presentation with id=' + presentID + ' has been deleted','', coreLogPrefix);
                deleteClickBtn.removeEventListener('click', openDeletePresentModal_);
                presentRow.remove();
                presentID = null;
                deletePresentModal.close();
                deletePresentModal = null;
                checkOnNoPresentation_();
            },
            error: function (callbacks) {
                pit.core.log('ajax error occur on deleting presentation','error', coreLogPrefix, callbacks);
                deleteWrapper.classList.remove('loading')
            }
        };

        pit.ajax.send(ajaxData);

    };

    /**
     * Open mobile menu actions on click
     * @private
     */
    let openMobileActions_ = function () {

        let arr = this.parentNode.parentNode.children,
            len = this.parentNode.parentNode.children.length - 1;

        arr[len].classList.add('presentations__actions-mobile--opened');
    };


    /**
     * Close mobile menu actions on click
     * @private
     */
    let closeMobileActions_ = function () {
        this.parentNode.classList.remove('presentations__actions-mobile--opened');
    };


    /**
     * Share presentation modal form
     * @private
     */
    let sharePresentModal_ = function () {
        let code = this.dataset.code;

        pit.notification.notify({
            type: 'confirm',
            message: '<h2>Как предоставить доступ</h2>' +
            '<h3 class="text-bold">Перейдите по адресу www.prezentit.ru</h3>' +
            '<div class="form-group">' +
            '<label for="" class="form-group__label">Введите код для просмотра презентации и голосования</label>' +
                '<input type="text" class="form-group__control text-center text-bold" value="' + code + '" style="width:60%; margin: 15px auto 0 auto; letter-spacing: 10px">' +
            '</div>',
        });

    };


    /**
     * Checking Number of presentation on Page
     * @private
     */
    let checkOnNoPresentation_ = function () {
        if (document.getElementsByClassName('presentations__row').length === 0) {
            document.getElementsByClassName('presentations__body')[0].appendChild(noItems);
        } else if ( document.getElementById('noItems')) {
            document.getElementById('noItems').remove();
        }
    };


    allPresent.init = function () {
        preparePresentations_();
        prepareMobileMenu_();
        pit.core.log('Module loaded', '', coreLogPrefix);
    };

    return allPresent;

}({});