<!DOCTYPE html>
<html lang="ru">
<head>
    <title><?=$title; ?> | Prezentit</title>
    <meta charset="UTF-8">
    <meta name="author" content="<?=$content; ?>" />
    <link type="image/x-icon" rel="shortcut icon" href="<?=$assets; ?>static/img/favicon.png" />

    <meta name="description" content="<?=$description; ?>" />
    <meta name="keywords" content="<?=$keywords; ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="<?=$assets; ?>vendor/font-awesome/css/font-awesome.css">

    <link rel="stylesheet" href="<?=$assets; ?>frontend/bundles/pit.min.css">
    <script type="text/javascript" src="<?=$assets; ?>frontend/bundles/pit.min.js"></script>

    <script type="text/javascript">
        function ready() {
            pit.aside.init();
            pit.collapse.init();
            pit.notification.createHolder();
            pit.tabs.init({
                search: false,
                counter: false
            });
            pit.form.init();
            pit.editPresent.init();
            pit.present.init({
                aside: false,
                slideNavigation: false,
                toggleInstruction: false,
                toggleAnswers: false,
                keyboard: false
            });
        }

        document.addEventListener("DOMContentLoaded", ready);
    </script>

</head>

<body>

    <header class="header clear-fix">

        <?= $header; ?>

    </header>

    <button id="openAside" class="aside__open-btn ">
        <i></i><i></i><i></i>
    </button>

    <aside class="aside aside-app">

        <?= $aside; ?>

    </aside>


    <section class="section">

        <?=$section; ?>

    </section>

    <div class="backdrop hide"></div>
</body>

</html>
