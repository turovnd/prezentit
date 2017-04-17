<!DOCTYPE html>
<html lang="ru">
<head>
    <title><?=$title; ?> | <?=$GLOBALS['SITE_NAME']; ?></title>
    <meta charset="UTF-8">
    <meta name="author" content="<?=$content; ?>" />

    <link type="image/x-icon" rel="shortcut icon" href="" />

    <meta name="description" content="<?=$description; ?>" />
    <meta name="keywords" content="<?=$keywords; ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />


    <!-- modules -->
    <link rel="stylesheet" href="<?=$assets; ?>frontend/modules/css/header.css">
    <link rel="stylesheet" href="<?=$assets; ?>frontend/modules/css/footer.css">
    <link rel="stylesheet" href="<?=$assets; ?>frontend/modules/css/aside.css">
    <link rel="stylesheet" href="<?=$assets; ?>frontend/modules/css/collapse.css">
    <link rel="stylesheet" href="<?=$assets; ?>frontend/modules/css/parallax.css">
    <link rel="stylesheet" href="<?=$assets; ?>frontend/modules/css/cols.css">
    <link rel="stylesheet" href="<?=$assets; ?>frontend/modules/css/typography.css">
    <link rel="stylesheet" href="<?=$assets; ?>frontend/modules/css/button.css">
    <link rel="stylesheet" href="<?=$assets; ?>frontend/modules/css/form.css">
    <link rel="stylesheet" href="<?=$assets; ?>frontend/modules/css/animation.css">
    <link rel="stylesheet" href="<?=$assets; ?>frontend/modules/css/global.css">

    <script type="text/javascript" src="<?=$assets; ?>frontend/modules/js/header.js"></script>
    <script type="text/javascript" src="<?=$assets; ?>frontend/modules/js/aside.js"></script>
    <script type="text/javascript" src="<?=$assets; ?>frontend/modules/js/collapse.js"></script>
    <script type="text/javascript" src="<?=$assets; ?>frontend/modules/js/parallax.js"></script>
    <script type="text/javascript" src="<?=$assets; ?>frontend/modules/js/ajax.js"></script>
    <script type="text/javascript" src="<?=$assets; ?>frontend/modules/js/cookies.js"></script>
    <script type="text/javascript">
        function ready() {
            header.init('welcome');
            aside.init();
            collapse.init();
            parallax.init();
        }

        document.addEventListener("DOMContentLoaded", ready);
    </script>


    <!-- =============== VENDOR STYLES ===============-->
    <link rel="stylesheet" href="<?=$assets; ?>static/css/welcome.css">
    <link rel="stylesheet" href="<?=$assets; ?>vendor/font-awesome/css/font-awesome.css">

    <!-- =============== VENDOR SCRIPTS ===============-->
    <script type="text/javascript" src=""></script>

</head>

<body>

    <header class="header header--default animated fade__in clear-fix">
        <?= View::factory('welcome/blocks/header'); ?>
    </header>

    <button id="openAside" class="aside__open-btn animated fade__in">
        <i></i><i></i><i></i>
    </button>

    <aside class="aside">
        <?= View::factory('welcome/blocks/aside'); ?>
    </aside>


    <section>
        <?=$section; ?>
    </section>


    <footer class="footer">
        <?= View::factory('welcome/blocks/footer'); ?>
    </footer>

    <div class="backdrop hide"></div>
    <input id="newSubCSRF" type="hidden" value="<?=Security::token(); ?>">
</body>

<link rel="stylesheet" href="<?=$assets; ?>vendor/sweetalert2/sweetalert2.min.css">
<script type="text/javascript" src="<?=$assets; ?>vendor/sweetalert2/sweetalert2.min.js"></script>

<script type="text/javascript">
    function ready() {

        function swalSubscribe() {
            swal({
                title: 'Будь первым',
                html:
                '<div class="col-xs-12">' +
                '<p>Совсем скоро система начнет функционировать, будь первым, кто получит бесплатный доступ!</p>' +
                '<div class="form-group text-left m-t-20">' +
                    '<label for="emailSub" class="form-group__label">Эл.почта</label>' +
                    '<input id="emailSub" class="form-group__control" type="email">' +
                '</div>' +
                '<div class="form-group text-left">' +
                    '<label for="nameSub" class="form-group__label">Имя</label>' +
                    '<input id="nameSub" class="form-group__control" type="text">' +
                '</div></div>',

                confirmButtonColor: '#008DA7',
                showCancelButton: true,
                confirmButtonText: 'Быть в курсе!',
                cancelButtonText: 'Отмена',
                showLoaderOnConfirm: true,
                preConfirm: function (text) {
                    return new Promise(function (resolve, reject) {
                        var formData = new FormData();
                        formData.append('name', document.getElementById('nameSub').value);
                        formData.append('email', document.getElementById('emailSub').value);
                        formData.append('csrf', document.getElementById('newSubCSRF').value);

                        ajaxData = {
                            url: '/newsubscriber',
                            type: 'POST',
                            data: formData,
                            beforeSend: function(){

                            },
                            success: function(response) {
                                console.log(response);
                                response = JSON.parse(response);

                                if (response.code === "60") {
                                    reject('Неправильный формат эл.почты')
                                } else if (response.code === "30") {
                                    reject('Укажите имя')
                                } else {
                                    resolve();
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
        }


        var btn = document.getElementsByClassName('subscribe');

        for (var i = 0; i < btn.length; i++) {
            btn[i].addEventListener('click', swalSubscribe);
        }

    }

    document.addEventListener("DOMContentLoaded", ready);
</script>

</html>
