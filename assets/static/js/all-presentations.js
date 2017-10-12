var allPresent = function (allPresent) {

    var coreLogPrefix       = "All-present",
        noResults           = null,
        noItems             = null,
        createPresentModal  = null,
        deletePresentModal  = null,
        delPresentID        = null,
        presentations       = [];


    var preparePresentTable_ = function () {

        moment.locale('ru');

        noResults = pit.draw.node('TR','',{ id: "noResult"});
        noResults.innerHTML =
            '<td colspan="3" style="text-align: center; padding: 20px 8px; border-bottom: 1px solid #e5e5e5;">' +
                'К сожалению, ничего ненеайдено. Попробуйте изменить запрос' +
            '</td>';

        noItems = pit.draw.node('TR','',{id:"noItems"});
        noItems.innerHTML =
            '<td colspan="3" style = "text-align: center; padding: 20px 8px; border-bottom: 1px solid #e5e5e5;">' +
                'Презентации ещё не созданы ' +
                '<i style="margin-left: 2px; font-size: 1.3em" class="fa fa-frown-o" aria-hidden="true"></i>' +
            '</td>';


        var rows = document.getElementsByClassName('presentations__row');

        for (var i = 0; i < rows.length; i++) {

            var name         = rows[i].getElementsByClassName('presentations__title')[0].getElementsByTagName('a')[0].innerHTML.toLowerCase(),
                time         = rows[i].getElementsByClassName('presentations__time')[0],
                toggleAction = rows[i].getElementsByClassName('presentations__actions-toggle')[0],
                closeAction  = rows[i].getElementsByClassName('presentations__actions-close')[0];

            if (!name || !time || !toggleAction || !closeAction)
                return false;

            var presentation = {
                row: rows[i],
                name: name
            };

            presentations.push(presentation);

            time.innerHTML = getLastUpdate_(time.innerHTML);

            toggleAction.addEventListener('click', openMobileActions_);
            closeAction.addEventListener('click', closeMobileActions_);
        }

        checkOnEmptyTable_();

        var searchInput   = document.getElementById('searchPresentInput');

        if (!searchInput)
            return false;

        searchInput.addEventListener('keyup', searchPresent_);

        createPresentModal = document.getElementById('presentModal');

        if (!createPresentModal)
            return false;

        createPresentModal.addEventListener('submit', createNewPresent_);

        return true;
    };


    /**
     * Searching presentation on page
     * @private
     */
    var searchPresent_ = function () {
        var searchingText = new RegExp(this.value.toLowerCase()),
            shownPresent = 0;

        for (var i = 0; i < presentations.length; i++) {

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
    var getLastUpdate_ = function (date) {
        date = new Date(date);

        if ( new Date() - date < 259200000) {
            return moment(date).fromNow();
        } else {
            return moment(date).format('DD MMM YYYY');
        }
    };



    /**
     * Submit creating new presentation
     * @private
     */
    var createNewPresent_ = function (event) {

        event.preventDefault();

        var ajaxData = {
            url: '/presentation/new',
            type: 'POST',
            data: new FormData(createPresentModal),
            beforeSend: function(){
                createPresentModal.getElementsByClassName('modal__wrapper')[0].classList.add('loader');
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

                window.location.assign(window.location.protocol + '//' + window.location.host + '/app/s/' + response.uri + '/edit');
                createPresentModal.getElementsByClassName('modal__wrapper')[0].classList.remove('loader');
            },
            error: function(callbacks) {
                pit.core.log('ajax error occur on creating presentation','error', coreLogPrefix, callbacks);
                createPresentModal.getElementsByClassName('modal__wrapper')[0].classList.remove('loader');
            }
        };

        pit.ajax.send(ajaxData);

    };


    /**
     * Open modal for delete presentation
     */
    allPresent.deletePresentation = function (element) {

        delPresentID = element.dataset.id;

        deletePresentModal = pit.notification.notify({
            type: 'confirm',
            message:
                '<h2>Подтверждение удаления</h2>' +
                '<p>После удаления, у Вас не будет способа восстановить презентацию со всеми её материалами!</p>',
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
    var deletePresent_ = function() {

        var formData = new FormData(),
            deleteWrapper = document.getElementsByClassName('notification--confirm')[0];

        formData.append('id', delPresentID);
        formData.append('csrf', document.getElementById('csrf').value);

        var ajaxData = {
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

                pit.core.log('Presentation with id=' + delPresentID + ' has been deleted','', coreLogPrefix);

                var row = document.getElementById('row'+delPresentID);
                if (row)
                    row.remove();
                delPresentID = null;
                deletePresentModal.close();
                deletePresentModal = null;
                checkOnEmptyTable_();
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
    var openMobileActions_ = function () {

        var arr = this.parentNode.parentNode.children,
            len = this.parentNode.parentNode.children.length - 1;

        arr[len].classList.add('presentations__actions-mobile--opened');
    };


    /**
     * Close mobile menu actions on click
     * @private
     */
    var closeMobileActions_ = function () {
        this.parentNode.classList.remove('presentations__actions-mobile--opened');
    };


    /**
     * Checking Number of presentation on Page
     * @private
     */
    var checkOnEmptyTable_ = function () {
        if (document.getElementsByClassName('presentations__row').length === 0) {
            document.getElementsByClassName('presentations__body')[0].appendChild(noItems);
        } else if (document.getElementById('noItems')) {
            document.getElementById('noItems').remove();
        }
    };



    var init_ = function () {

        if (preparePresentTable_())
            pit.core.log('Module loaded', '', coreLogPrefix);

        else
            pit.core.log('Module NOT loaded', 'error', coreLogPrefix);

    };

    document.addEventListener("DOMContentLoaded", init_);

    return allPresent;

}({});