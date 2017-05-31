<!DOCTYPE html>
<html lang="ru">
<head>
    <title><?=$presentaton->name; ?> | Prezentit</title>
    <meta charset="UTF-8">
    <meta name="author" content="<?=$content; ?>" />
    <link type="image/x-icon" rel="shortcut icon" href="<?=$assets; ?>static/img/favicon.png" />

    <meta name="description" content="<?=$description; ?>" />
    <meta name="keywords" content="<?=$keywords; ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="<?=$assets; ?>vendor/font-awesome/css/font-awesome.css?v=<?= filemtime("assets/vendor/font-awesome/css/font-awesome.css") ?>">

    <link rel="stylesheet" href="<?=$assets; ?>frontend/bundles/present.min.css?v=<?= filemtime("assets/frontend/bundles/present.min.css") ?>">
    <script type="text/javascript" src="<?=$assets; ?>frontend/bundles/present.min.js?v=<?= filemtime("assets/frontend/bundles/present.min.js") ?>"></script>

    <script defer type="text/javascript">
        function ready() {
            pit.collapse.init();
            pit.present.init({
                aside: true,
                slideNavigation: true,
                toggleInstruction: true,
                toggleAnswers: true,
                keyboard: true
            });
        }

        document.addEventListener("DOMContentLoaded", ready);
    </script>
</head>

<body>

    <main class="presentation animated fade__in">

        <?= View::factory('app/pages/presentation', array('presentaton' => $presentaton))?>

    </main>

</body>

</html>
