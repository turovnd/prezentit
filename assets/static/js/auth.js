function ready() {

    var host            = window.location.host,
        protocol        = window.location.protocol,
        pathname        = window.location.pathname,
        signin          = document.getElementById('signin'),
        forget          = document.getElementById('forget'),
        reset           = document.getElementById('reset'),
        signup          = document.getElementById('signup'),
        toSignIn        = document.getElementById('toSignIn'),
        toSignUp        = document.getElementById('toSignUp'),
        toReset         = document.getElementById('toReset'),
        cancelForget    = document.getElementById('cancelForget');

    /**
     * Opening SignIn Form
     */
    var openSignIn = function () {
        signin.classList.remove('hide');
        toSignUp.classList.remove('hide');
        forget.classList.add('hide');
        signup.classList.add('hide');
        toSignIn.classList.add('hide')
    };

    /**
     * Open SignUp Form
     */
    var openSignUp = function () {
        signup.classList.remove('hide');
        toSignIn.classList.remove('hide');
        signin.classList.add('hide');
        toSignUp.classList.add('hide');
        forget.classList.add('hide');
    };

    /**
     * Open Reset Password Form
     */
    var openReset = function () {
        signin.classList.add('hide');
        signup.classList.add('hide');
        toSignIn.classList.add('hide');
        forget.classList.remove('hide');
        toSignUp.classList.remove('hide');
    };


    /**
     * On page load
     */
    if (pathname === "/login") {
        openSignIn();
    } else if (pathname === "/signup") {
        openSignUp();
    } else {
        window.location.replace(protocol + '//' + host + '/auth');
    }



    /**
     * Event Listener
     */
    toSignIn.addEventListener('click', openSignIn);
    toSignUp.addEventListener('click', openSignUp);
    toReset.addEventListener('click', openReset);
    cancelForget.addEventListener('click', openSignIn);


    /**
     * Submit SignIn Form
     */
    signin.addEventListener('submit', function (event) {
        event.preventDefault();

        var ajaxData = {
            url: 'auth/signin',
            type: 'POST',
            data: new FormData(signin),
            beforeSend: function(){
                //$('#registr_form').parent('.modal-wrapper').addClass('whirl');
            },
            success: function(response) {
                response = JSON.parse(response);
                console.log(response);

                window.location.replace(protocol + '//' + host + '/app');
            },
            error: function(callbacks) {
                console.log(callbacks);
            }
        };

        ajax.send(ajaxData);
    });



    /**
     * Submit SignUp Form
     */
    signup.addEventListener('submit', function (event) {
        event.preventDefault();

        var ajaxData = {
            url: '/auth/signup',
            type: 'POST',
            data: new FormData(signup),
            beforeSend: function(){
                //$('#registr_form').parent('.modal-wrapper').addClass('whirl');
            },
            success: function(response) {
                console.log(response );
                response = JSON.parse(response);

                if (response.code === "20") {
                    window.location.replace(protocol + '//' + host + '/app');
                } else {

                }
            },
            error: function(callbacks) {
                console.log(callbacks);
            }
        };

        ajax.send(ajaxData);
    });




}

document.addEventListener("DOMContentLoaded", ready);