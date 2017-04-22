var cookies = function () {

    var get = function (name) {

        var match = document.cookie.match(RegExp(name+'=([^;]*)'));

        return match ? decodeURIComponent(match[1]).split('~')[1] : undefined;

    };

    var set = function (options) {

        options = options || {};

        var expires = options.expires;

        if (typeof expires == 'number' && expires) {

            var date = new Date();

            date.setTime(date.getTime() + expires * 1000);
            expires = options.expires = date;

        }

        if (expires && expires.toUTCString) {

            options.expires = expires.toUTCString();

        }

        var value = encodeURIComponent(options.value);

        var updatedCookie = options.name + '=' + value;

        for (var propName in options) {

            if (propName == 'name' || propName == 'value') {

                continue;

            }

            updatedCookie += '; ' + propName;
            var propValue = options[propName];

            if (propValue !== true) {

                updatedCookie += '=' + propValue;

            }

        }

        document.cookie = updatedCookie;

    };

    var remove = function (name) {

        set({
            name: name,
            value: '',
            expires: -1,
            path: '/'
        });

    };

    return {
        get: get,
        set: set,
        remove: remove
    };

}();

module.exports = cookies;