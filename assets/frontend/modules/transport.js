module.exports = (function (transport) {

    var settings_   = null, // transport settings
        input_      = null; // input


    var prepare_ = function (settings) {

        settings_ = settings;
        input_ = pit.draw.node('INPUT', '', {type : 'file'});

        if (settings_.multiple) {

            input_.multiple = true;

        }

        if (settings_.accept) {

            input_.accept = settings_.accept;

        }


        input_.click();
        input_.addEventListener('change', fileSelected_);

    };


    var fileSelected_ = function () {

        var file       = input_.files[0],
            formData   = new FormData();

        formData.append('files', file, file.name);
        formData.append('params', JSON.stringify(settings_.params));

        pit.ajax.send({
            url: settings_.url,
            type: 'POST',
            data: formData,
            beforeSend: settings_.beforeSend,
            success: settings_.success,
            error: settings_.error
        });

    };

    transport.init = function (settings) {

        prepare_(settings);

    };

    transport.getInput = function () {

        return input_;

    };

    return transport;

})({});