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
        cancelForget    = document.getElementById('cancelForget'),
        cancelReset     = document.getElementById('cancelReset');

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



    if (!pit.cookies.get('reset_link')) {

        /**
         * On page load
         */
        if (pathname === "/login") {
            openSignIn();
        } else if (pathname === "/signup") {
            openSignUp();
        } else {
            window.location.replace(protocol + '//' + host);
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
                    signin.classList.add('loading');
                },
                success: function(response) {
                    response = JSON.parse(response);

                    pit.notification.notify({
                        type: response.status,
                        message: response.message
                    });

                    signin.classList.remove('loading');

                    if (parseInt(response.code) === 12)
                        window.location.replace(protocol + '//' + host + '/app');
                },
                error: function(callbacks) {
                    pit.core.log('ajax error occur on signin form','error','authorization',callbacks);
                    signin.classList.add('loading');
                }
            };

            pit.ajax.send(ajaxData);
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
                    signup.classList.add('loading');
                },
                success: function(response) {
                    response = JSON.parse(response);

                    pit.notification.notify({
                        type: response.status,
                        message: response.message
                    });

                    signup.classList.remove('loading');

                    if (response.code === "20")
                        window.location.replace(protocol + '//' + host + '/app');

                },
                error: function(callbacks) {
                    pit.core.log('ajax error occur on signup form','error','authorization',callbacks);
                    signup.classList.remove('loading');
                }
            };

            pit.ajax.send(ajaxData);
        });


        /**
         * Submit Forget password Form
         */
        forget.addEventListener('submit', function (event) {
            event.preventDefault();

            var ajaxData = {
                url: '/auth/forget',
                type: 'POST',
                data: new FormData(forget),
                beforeSend: function(){
                    forget.classList.add('loading');
                },
                success: function(response) {
                    response = JSON.parse(response);

                    pit.notification.notify({
                        type: response.status,
                        message: response.message
                    });

                    forget.classList.remove('loading');

                    if (response.code === "62")
                        window.location.replace(protocol + '//' + host + '/login');

                },
                error: function(callbacks) {
                    pit.core.log('ajax error occur on forget form','error','authorization',callbacks);
                    forget.classList.remove('loading');
                }
            };

            pit.ajax.send(ajaxData);
        });


    } else {

        /**
         * Submit Reset password Form
         */
        reset.addEventListener('submit', function (event) {
            event.preventDefault();

            var ajaxData = {
                url: '/auth/reset',
                type: 'POST',
                data: new FormData(reset),
                beforeSend: function(){
                    reset.classList.add('loading');
                },
                success: function(response) {
                    response = JSON.parse(response);

                    pit.notification.notify({
                        type: response.status,
                        message: response.message
                    });

                    reset.classList.remove('loading');

                    if (response.code === "15")
                        window.location.reload();

                },
                error: function(callbacks) {
                    pit.core.log('ajax error occur on reset form','error','authorization',callbacks);
                    reset.classList.remove('loading');
                }
            };

            pit.ajax.send(ajaxData);
        });

        cancelReset.addEventListener('click', function () {
           pit.cookies.remove('reset_link');
           window.location.reload();
        });

    }



}

document.addEventListener("DOMContentLoaded", ready);