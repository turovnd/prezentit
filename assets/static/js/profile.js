function ready() {

    var changePassword  = document.getElementById('changePassword'),
        changeProfile   = document.getElementById('changeProfile');


    /**
     * Submit Change Profile Form
     */
     changeProfile.addEventListener('submit', function (event) {
        event.preventDefault();

        var ajaxData = {
            url: '/app/profile/update',
            type: 'POST',
            data: new FormData(changeProfile),
            beforeSend: function(){
                //$('#registr_form').parent('.modal-wrapper').addClass('whirl');
            },
            success: function(response) {
                console.log(response);
                response = JSON.parse(response);

                if (response.code === "40") {
                    document.getElementsByClassName('header')[0].getElementsByClassName('header__title')[0].innerHTML = "Профиль - " + document.getElementById('profileName').value;
                } else {

                }
            },
            error: function(callbacks) {
                console.log(callbacks);
            }
        };

        pit.ajax.send(ajaxData);
    });


    /**
     * Submit Change Password Form
     */
    changePassword.addEventListener('submit', function (event) {
        event.preventDefault();

        var ajaxData = {
            url: '/app/profile/updatepassword',
            type: 'POST',
            data: new FormData(changePassword),
            beforeSend: function(){
                //$('#registr_form').parent('.modal-wrapper').addClass('whirl');
            },
            success: function(response) {
                console.log(response);
                response = JSON.parse(response);

                if (response.code === "44") {
                    changePassword.reset();
                } else {

                }
            },
            error: function(callbacks) {
                console.log(callbacks);
            }
        };

        pit.ajax.send(ajaxData);
    });



}

document.addEventListener("DOMContentLoaded", ready);