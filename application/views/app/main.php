<!DOCTYPE html>
<html lang="ru">
<head>
    <title><?=$user->name; ?> | <?=$GLOBALS['SITE_NAME']; ?></title>
    <meta charset="UTF-8">
    <meta name="author" content="<?=$content; ?>" />
    <link type="image/x-icon" rel="shortcut icon" href="<?=$assets; ?>static/img/favicon.png" />

    <meta name="description" content="<?=$description; ?>" />
    <meta name="keywords" content="<?=$keywords; ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="<?=$assets; ?>frontend/bundles/prezentit.bundle.css">
    <script type="text/javascript" src="<?=$assets; ?>frontend/bundles/prezentit.bundle.js"></script>

    <script type="text/javascript">
        function ready() {
            pit.header.init('app');
            pit.aside.init();
            pit.collapse.init();
            pit.parallax.init();
        }

        document.addEventListener("DOMContentLoaded", ready);
    </script>


    <!-- =============== VENDOR STYLES ===============-->
    <link rel="stylesheet" href="<?=$assets; ?>vendor/font-awesome/css/font-awesome.css">

    <!-- =============== VENDOR SCRIPTS ===============-->
    <script type="text/javascript" src=""></script>

</head>

<body>

    <header class="header clear-fix">
        <?= View::factory('app/blocks/header', array('title' => $title)); ?>
    </header>

    <button id="openAside" class="aside__open-btn ">
        <i></i><i></i><i></i>
    </button>

    <aside class="aside aside-app">
        <?= View::factory('app/blocks/aside'); ?>
    </aside>


    <section>

        <?=$section; ?>
    </section>

    <div class="backdrop hide"></div>
</body>

</html>
