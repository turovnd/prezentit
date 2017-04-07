function ready() {

    var host                = window.location.host,
        protocol            = window.location.protocol,
        toggleAction        = document.getElementsByClassName('presentations__actions-toggle'),
        closeAction         = document.getElementsByClassName('presentations__actions-close'),
        searchInput         = document.getElementById('searchInput'),
        newPresentation     = document.getElementById('newPresentation'),
        presentations       = [],
        i, toglebtn, cancelbtn, searchingText, presentation, shownpresent;


    var td = document.createElement('td');
        td.colSpan = 3;
        td.style = "text-align: center; padding: 20px 8px; border-bottom: 1px solid #e5e5e5;";
        td.innerHTML = "К сожалению, ничего ненеайдено. Попробуйте изменить запрос";

    var noresult = document.createElement('tr');
        noresult.id = "noResult";
        noresult.append(td);




    /**
     * Prepare presentations for searching
     */
    for (i = 0; i < document.getElementsByClassName('presentations__row').length; i++) {
        presentation = {
            row: document.getElementsByClassName('presentations__row')[i],
            name: document.getElementsByClassName('presentations__row')[i].getElementsByClassName('presentations__title')[0].getElementsByTagName('a')[0].innerHTML.toLowerCase()
        };

        presentations.push(presentation);
    }



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
     * Search Presentations
     */
    var searchPresentation = function () {
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
     *
     */
    var swalNewPresentation = function () {
        swal({
            html:
            '<h3>Новая презентация</h3>'+
            '<div class="form-group">' +
                '<input id="newPresentFormName" class="form-group__control" type="text" name="name" placeholder="Введите название презентации">' +
            '</div>',

            confirmButtonColor: '#008DA7',
            showCancelButton: true,
            confirmButtonText: 'Создать',
            cancelButtonText: 'Отмена',
            showLoaderOnConfirm: true,
            preConfirm: function (text) {
                return new Promise(function (resolve, reject) {
                    var formData = new FormData();
                        formData.append('name', document.getElementById('newPresentFormName').value);
                        formData.append('csrf', document.getElementById('newPresentFormCSRF').value);

                    var ajaxData = {
                        url: '/app/newpresentation',
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
     * Add event listener
     */
    for (i = 0; i < toggleAction.length; i++){
        toggleAction[i].addEventListener('click', openMobileAction);
        closeAction[i].addEventListener('click', closeMobileAction);
    }

    if (searchInput) {
        searchInput.addEventListener('keyup', searchPresentation);
    }

    if (newPresentation){
        newPresentation.addEventListener('click', swalNewPresentation);
    }
}

document.addEventListener("DOMContentLoaded", ready);