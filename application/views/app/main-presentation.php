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

    <link rel="stylesheet" href="<?=$assets; ?>frontend/bundles/prezentit.bundle.css">
    <script type="text/javascript" src="<?=$assets; ?>frontend/bundles/prezentit.bundle.js"></script>

    <!-- =============== VENDOR STYLES ===============-->
    <link rel="stylesheet" href="<?=$assets; ?>vendor/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="<?=$assets; ?>static/css/presentation.css">

    <!-- =============== VENDOR SCRIPTS ===============-->
    <script defer type="text/javascript" src="<?=$assets; ?>static/js/presentation.js"></script>

    <script defer type="text/javascript">
        function ready() {
            pit.collapse.init();
            present.init();
        }

        document.addEventListener("DOMContentLoaded", ready);
    </script>
</head>

<body>

    <main class="presentation user-select--none animated fade__in">
        <?= View::factory('app/pages/presentation', array('presentaton' => $presentaton))?>
    </main>

</body>

</html>
