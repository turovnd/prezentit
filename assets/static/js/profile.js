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
                changeProfile.classList.add('loading');
            },
            success: function(response) {
                response = JSON.parse(response);

                pit.notification.notify({
                    type: response.status,
                    message: response.message
                });

                changeProfile.classList.remove('loading');

                if (parseInt(response.code) === 40)
                    document.getElementsByClassName('header')[0].getElementsByClassName('header__title')[0].innerHTML = "Профиль - " + document.getElementById('profileName').value;

            },
            error: function(callbacks) {
                pit.core.log('ajax error occur on changeProfile form','danger','authorization',callbacks);
                changeProfile.classList.remove('loading');
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
                changePassword.classList.add('loading');
            },
            success: function(response) {
                response = JSON.parse(response);

                pit.notification.notify({
                    type: response.status,
                    message: response.message
                });

                if (response.code === "44")
                    changePassword.reset();

                changePassword.classList.remove('loading');
            },
            error: function(callbacks) {
                pit.core.log('ajax error occur on changePassword form','danger','authorization',callbacks);
                changePassword.classList.remove('loading');
            }
        };

        pit.ajax.send(ajaxData);
    });



}

document.addEventListener("DOMContentLoaded", ready);