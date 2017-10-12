module.exports = function (properties) {

    var ws = null;

    var setWS = function () {

        return new Promise(function (resolve, reject) {

            var protocol = 'ws' + (properties.secure ? 's' : '') + '://',
                host = properties.host || 'localhost',
                path = properties.path ? '/' + properties.path : '',
                port = properties.port ? ':' + properties.port : '',
                url = protocol + host + port + path;


            ws = new WebSocket(url);

            var handlers = {

                opened: function () {


                    if (typeof properties.open == 'function') {

                        properties.open();

                    }

                    resolve();

                },

                closed: function () {

                    if (typeof properties.close == 'function') {

                        properties.close();

                    }

                    reject();

                },

                message: function (msg) {

                    if (typeof properties.message == 'function') {

                        properties.message(msg);

                    }

                },

                error: function (e) {

                    if (typeof properties.error == 'function') {

                        properties.error(e);

                    }

                }

            };

            ws.onopen = handlers.opened;
            ws.onmessage = handlers.message;
            ws.onerror = handlers.error;
            ws.onclose = handlers.closed;

        });

    };

    var send = function (message) {

        ws.send(JSON.stringify(message));

    };

    var close = function () {

        ws.close();

    };

    var status = function () {

        return ws.readyState;

    };

    var reconnect = function (attempts) {

        if (ws == null) {

            return Promise.reject();

        }

        return new Promise( function (resolve, reject) {

            setWS()
                .then(function () {

                    resolve();

                },
                function () {

                    if (attempts > 2) {

                        reconnect(attempts - 1).then(resolve, reject);

                    } else {

                        reject();

                    }

                });

        });



    };



    setWS().catch(console.log);

    return {
        send: send,
        close: close,
        reconnect: reconnect,
        status: status
    };

};