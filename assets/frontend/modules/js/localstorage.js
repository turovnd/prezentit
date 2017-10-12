module.exports = function () {

    var storage = localStorage;

    var set = function (key, value) {

        storage.setItem(key, JSON.stringify(value));

    };

    var get = function (key) {

        var value = storage.getItem(key);

        try {

            return JSON.parse(value);

        } catch (e) {

            return value;

        }

    };

    var remove = function (key) {

        var value = get(key);

        storage.removeItem(key);

        return value;

    };

    var append = function (key, data) {

        var value = get(key);

        if (value == null) {

            value = [];

        }

        switch (typeof value) {
            case 'object': if (Array.isArray(value)) value.push(data); break;
            default: value = value + data.toString();
        }

        set(key, value);

    };

    return {
        set: set,
        get: get,
        append: append,
        remove: remove
    };

}();