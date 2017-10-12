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

    <link rel="stylesheet" href="<?=$assets; ?>vendor/font-awesome/css/font-awesome.css?v=<?= filemtime("assets/vendor/font-awesome/css/font-awesome.css") ?>">

    <link rel="stylesheet" href="<?=$assets; ?>frontend/bundles/pit.min.css?v=<?= filemtime("assets/frontend/bundles/pit.min.css") ?>">
    <link rel="stylesheet" href="<?=$assets; ?>frontend/bundles/present.min.css?v=<?= filemtime("assets/frontend/bundles/present.min.css") ?>">
    <link rel="stylesheet" href="<?=$assets; ?>frontend/bundles/editPresent.min.css?v=<?= filemtime("assets/frontend/bundles/editPresent.min.css") ?>">

    <script type="text/javascript" src="<?=$assets; ?>frontend/bundles/pit.min.js?v=<?= filemtime("assets/frontend/bundles/pit.min.js") ?>"></script>
    <script type="text/javascript" src="<?=$assets; ?>frontend/bundles/present.min.js?v=<?= filemtime("assets/frontend/bundles/present.min.js") ?>"></script>
    <script type="text/javascript" src="<?=$assets; ?>frontend/bundles/editPresent.min.js?v=<?= filemtime("assets/frontend/bundles/editPresent.min.js") ?>"></script>

    <script type="text/javascript">
        function ready() {
            present.plagin.init({
                aside: false,
                slideNavigation: false,
                toggleInstruction: false,
                toggleAnswers: false,
                keyboard: false
            });
            editPresent.plagin.init();
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
