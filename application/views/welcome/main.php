<!DOCTYPE html>
<html lang="ru">
<head>
    <title><?=$title; ?> | <?=$GLOBALS['SITE_NAME']; ?></title>
    <meta charset="UTF-8">
    <meta name="author" content="<?=$GLOBALS['SITE_NAME']; ?>" />

    <link type="image/x-icon" rel="shortcut icon" href="" />

    <meta name="description" content="<?=$description; ?>" />
    <meta name="keywords" content="<?=$keywords; ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />


    <!-- modules -->
    <link rel="stylesheet" href="<?=$assets; ?>frontend/modules/css/header.css">
    <link rel="stylesheet" href="<?=$assets; ?>frontend/modules/css/asside.css">
    <link rel="stylesheet" href="<?=$assets; ?>frontend/modules/css/collapse.css">
    <link rel="stylesheet" href="<?=$assets; ?>frontend/modules/css/parallax.css">
    <link rel="stylesheet" href="<?=$assets; ?>frontend/modules/css/global.css">

    <script type="text/javascript" src="<?=$assets; ?>frontend/modules/js/header.js"></script>
    <script type="text/javascript" src="<?=$assets; ?>frontend/modules/js/collapse.js"></script>
    <script type="text/javascript" src="<?=$assets; ?>frontend/modules/js/parallax.js"></script>
    <script type="text/javascript">
        function ready() {
            header.init("welcome");
            collapse.init();
            parallax.init();
        }

        document.addEventListener("DOMContentLoaded", ready);

    </script>


    <!-- =============== VENDOR STYLES ===============-->
    <link rel="stylesheet" href="<?=$assets; ?>static/css/welcome.css">

    <!-- =============== VENDOR SCRIPTS ===============-->
    <script type="text/javascript" src=""></script>

</head>

<body>

    <header class="header animated fade__in">
        <?= View::factory('welcome/blocks/header'); ?>
    </header>

    <button id="openAsside" class="asside__open-btn animated fade__in">
        <i></i><i></i><i></i>
    </button>

    <aside class="asside">
        <?= View::factory('welcome/blocks/asside'); ?>
    </aside>


    <section>
        <?=$section; ?>
    </section>


    <footer class="footer">
        <?= View::factory('welcome/blocks/footer'); ?>
    </footer>

    <div class="backdrop hide"></div>
</body>

</html>
