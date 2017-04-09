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
        i, toglebtn, cancelbtn, searchingText, presentation, shownpresent, time, presentID, ajaxData, formData, row, uri;


    var td = document.createElement('td');
        td.colSpan = 3;
        td.style = "text-align: center; padding: 20px 8px; border-bottom: 1px solid #e5e5e5;";
        td.innerHTML = "К сожалению, ничего ненеайдено. Попробуйте изменить запрос";

    var noresult = document.createElement('tr');
        noresult.id = "noResult";
        noresult.append(td);

    td.innerHTML = "Презентации ещё не созданы <i style='margin-left: 2px; font-size: 1.3em' class='fa fa-frown-o' aria-hidden='true'></i>";

    var noitems = document.createElement('tr');
        noitems.id = "noItems";
        noitems.append(td);

    /**
     * Open Table Mobile Actions on click
     */
    var openMobileAction = function () {
        if (event.target.classList.contains('presentations__actions-toggle')) toglebtn = event.target;
        else toglebtn = event.target.parentNode;

        var arr = toglebtn.parentNode.parentNode.children,
            len = toglebtn.parentNode.parentNode.children.length - 1;

        arr[len].classList.add('presentations__actions-mobile--opened');

    };


    /**
     * Close Table Mobile Actions on click
     */
    var closeMobileAction = function () {
        if (event.target.classList.contains('presentations__actions-close')) cancelbtn = event.target;
        else cancelbtn = event.target.parentNode;

        cancelbtn.parentNode.classList.remove('presentations__actions-mobile--opened');
    };


    /**
     * Search Press
     */
    var searchPres = function () {
        searchingText = new RegExp(event.target.value.toLowerCase());
        shownpresent = 0;

        for (i = 0; i < presentations.length; i++) {

            if ( searchingText.test(presentations[i].name) ) {

                presentations[i].row.classList.remove('hide');
                shownpresent++;

            } else {

                presentations[i].row.classList.add('hide');

            }

            if ( shownpresent == 0 ) {
                document.getElementsByClassName('presentations__body')[0].append(noresult);
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

                    ajax.send(ajaxData);

                })
            }

        });
    };


    /**
     * Delete presentation
     */
    var deletePres = function () {
        if (event.target.classList.contains('presentation__delete')) {
            presentID = event.target.dataset.id;
            row = event.target.parentNode.parentNode;
        } else {
            presentID = event.target.parentNode.dataset.id;
            row = event.target.parentNode.parentNode.parentNode;
        }

        swal({
            title: 'Подтверждение удаления',
            text: "После удаления, у Вас не будет способа восстановить презентацию!",
            type: 'warning',
            confirmButtonColor: '#008DA7',
            showCancelButton: true,
            confirmButtonText: 'Удалить',
            cancelButtonText: 'Отмена',
            showLoaderOnConfirm: true,
        }).then(function () {

            ajaxData = {
                url: '/app/presentation/delete/' + presentID,
                type: 'POST',
                beforeSend: function () {
                    //$('#registr_form').parent('.modal-wrapper').addClass('whirl');
                },
                success: function (response) {
                    console.log(response);
                    response = JSON.parse(response);

                    if (response.code === "52") {
                        row.remove();
                        calcNumberRows();
                    }

                },
                error: function (callbacks) {
                    console.log(callbacks);
                }
            };

            ajax.send(ajaxData);
        });

    };


    /**
     * Swal for sharing presentation.
     */
    var sharePres = function () {
        if (event.target.classList.contains('presentation__share')) {
            uri = event.target.dataset.uri;
        } else {
            uri = event.target.parentNode.dataset.uri;
        }

        swal({
            title: 'Поделиться ссылкой',
            html:
            '<div class="form-group">' +
                '<label for="" class="form-group__label">Используй ссылку, чтобы пользователи проголосовали</label>' +
                '<input type="text" class="form-group__control" value="' + protocol+ '//' + host + '/' + uri + '">' +
            '</div>',
            confirmButtonColor: '#008DA7',
            confirmButtonText: 'Готово!',
        });
    };
    
    
    var calcNumberRows = function () {
        //rows
        console.log(rows.length, noitems );
        if (rows.length == 0) {
            document.getElementsByClassName('presentations__body')[0].append(noitems);
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