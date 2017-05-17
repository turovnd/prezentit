function ready() {

    var host                = window.location.host,
        protocol            = window.location.protocol,
        rows                = document.getElementsByClassName('presentations__row'),
        toggleAction        = document.getElementsByClassName('presentations__actions-toggle'),
        closeAction         = document.getElementsByClassName('presentations__actions-close'),
        searchInput         = document.getElementById('searchInput'),
        newPres             = document.getElementById('newPres'),
        delPres             = document.getElementsByClassName('presentation__delete'),
        shPres              = document.getElementsByClassName('presentation__share'),
        shPresMobile        = document.getElementsByClassName('presentation__share-mobile'),
        presentations       = [],
        i, searchingText, presentation, shownpresent, time, presentID, ajaxData, formData, row, uri;


    var td = document.createElement('td');
        td.colSpan = 3;
        td.style = "text-align: center; padding: 20px 8px; border-bottom: 1px solid #e5e5e5;";
        td.innerHTML = "К сожалению, ничего ненеайдено. Попробуйте изменить запрос";

    var noResult = document.createElement('tr');
        noResult.id = "noResult";
        noResult.appendChild(td);

    var td1 = document.createElement('td');
        td1.colSpan = 3;
        td1.style = "text-align: center; padding: 20px 8px; border-bottom: 1px solid #e5e5e5;";
        td1.innerHTML = "Презентации ещё не созданы <i style='margin-left: 2px; font-size: 1.3em' class='fa fa-frown-o' aria-hidden='true'></i>";

    var noItems = document.createElement('tr');
        noItems.id = "noItems";
        noItems.appendChild(td1);

    /**
     * Open Table Mobile Actions on click
     */
    var openMobileAction = function () {

        var arr = this.parentNode.parentNode.children,
            len = this.parentNode.parentNode.children.length - 1;

        arr[len].classList.add('presentations__actions-mobile--opened');
    };


    /**
     * Close Table Mobile Actions on click
     */
    var closeMobileAction = function () {
        this.parentNode.classList.remove('presentations__actions-mobile--opened');
    };


    /**
     * Search Press
     */
    var searchPres = function () {
        searchingText = new RegExp(this.value.toLowerCase());
        shownpresent = 0;

        for (i = 0; i < presentations.length; i++) {

            if ( searchingText.test(presentations[i].name) ) {

                presentations[i].row.classList.remove('hide');
                shownpresent++;

            } else {

                presentations[i].row.classList.add('hide');

            }

            if ( shownpresent == 0 ) {
                document.getElementsByClassName('presentations__body')[0].appendChild(noResult);
            } else if ( document.getElementById('noResult')) {
                document.getElementById('noResult').remove();
            }
        }

    };


    /**
     * Create new presentation
     */
    var swalNewPres = function () {
        swal({
            html:
            '<h3>Новая презентация</h3>'+
            '<div class="form-group">' +
                '<input id="newPresFormName" class="form-group__control" type="text" name="name" placeholder="Введите название презентации">' +
            '</div>',

            confirmButtonColor: '#008DA7',
            showCancelButton: true,
            confirmButtonText: 'Создать',
            cancelButtonText: 'Отмена',
            showLoaderOnConfirm: true,
            preConfirm: function (text) {
                return new Promise(function (resolve, reject) {
                    formData = new FormData();
                    formData.append('name', document.getElementById('newPresFormName').value);
                    formData.append('csrf', document.getElementById('newPresFormCSRF').value);

                    ajaxData = {
                        url: '/app/presentation/new',
                        type: 'POST',
                        data: formData,
                        beforeSend: function(){
                            //$('#registr_form').parent('.modal-wrapper').addClass('whirl');
                        },
                        success: function(response) {
                            console.log(response);
                            response = JSON.parse(response);

                            if (response.code === "51") {
                                reject('Укажите название презентации.')
                            } else {
                                window.history.pushState('App', protocol + '//' + host + '/app');
                                window.location.replace(protocol + '//' + host + '/app/s/' + response.uri + '/edit');
                            }

                        },
                        error: function(callbacks) {
                            console.log(callbacks);
                        }
                    };

                    pit.ajax.send(ajaxData);

                })
            }

        });
    };


    /**
     * Delete presentation
     */
    var deletePres = function () {

        presentID = this.dataset.id;
        row = this.parentNode.parentNode;

        pit.notification.notify({
            type: 'confirm',
            message: '<h2>Подтверждение удаления</h2>' +
                        '<p>После удаления, у Вас не будет способа восстановить презентацию!</p>',
            showCancelButton: true,
            confirmText: 'Удалить',
            confirm: deletePresentation_
        });

        function deletePresentation_() {

            var wrapper = document.getElementsByClassName('notification--confirm')[0];

            ajaxData = {
                url: '/app/presentation/delete/' + presentID,
                type: 'POST',
                beforeSend: function () {
                    wrapper.classList.add('loadind')
                },
                success: function (response) {
                    response = JSON.parse(response);

                    pit.notification.notify({
                        type: response.status,
                        message: response.message
                    });

                    if (response.code === "52") {
                        row.remove();
                        calcNumberRows();
                    }

                    wrapper.classList.remove('loadind')

                },
                error: function (callbacks) {
                    pit.core.log('ajax error occur on deletePresentation','danger','authorization', callbacks);
                    wrapper.classList.remove('loadind')
                }
            };

            pit.ajax.send(ajaxData);

        }

    };


    /**
     * Swal for sharing presentation.
     */
    var sharePres = function () {
        uri = this.dataset.uri;

        pit.notification.notify({
            type: 'confirm',
            message: '<h2>Поделиться ссылкой</h2>' +
                        '<div class="form-group">' +
                            '<label for="" class="form-group__label">Используй ссылку, чтобы пользователи проголосовали</label>' +
                            '<input type="text" class="form-group__control" value="' + protocol+ '//' + host + '/' + uri + '">' +
                        '</div>',
        });

    };
    
    
    var calcNumberRows = function () {
        if (rows.length == 0) {
            document.getElementsByClassName('presentations__body')[0].appendChild(noItems);
        } else if ( document.getElementById('noItems')) {
            document.getElementById('noItems').remove();
        }  
    };


    /**
     * Format Date using moment.js
     */
    moment.locale('ru');
    var lastUpdate = function (date) {
        date = new Date(date);

        if ( new Date() - date < 259200000) {
            return moment(date).fromNow();
        } else {
            return moment(date).format('DD MMM YYYY');
        }
    };


    /**
     * Parse presentations rows
     * - for searching
     * - for setting time
     */
    calcNumberRows();
    for (i = 0; i < rows.length; i++) {
        presentation = {
            row: rows[i],
            name: rows[i].getElementsByClassName('presentations__title')[0].getElementsByTagName('a')[0].innerHTML.toLowerCase()
        };
        presentations.push(presentation);

        time = rows[i].getElementsByClassName('presentations__time')[0];
        time.innerHTML = lastUpdate(time.innerHTML);
    }
    
    




    /**
     * Add event listener
     */
    for (i = 0; i < toggleAction.length; i++){
        toggleAction[i].addEventListener('click', openMobileAction);
        closeAction[i].addEventListener('click', closeMobileAction);
        delPres[i].addEventListener('click', deletePres);
        shPres[i].addEventListener('click', sharePres);
        shPresMobile[i].addEventListener('click', sharePres);
    }

    if (searchInput) {
        searchInput.addEventListener('keyup', searchPres);
    }

    if (newPres){
        newPres.addEventListener('click', swalNewPres);
    }
}

document.addEventListener("DOMContentLoaded", ready);