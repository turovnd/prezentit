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
    <script type="text/javascript" src="<?=$assets; ?>frontend/bundles/pit.min.js?v=<?= filemtime("assets/frontend/bundles/pit.min.js") ?>"></script>

    <script type="text/javascript">
        function ready() {
            pit.header.init('welcome');
            pit.aside.init();
            pit.collapse.init();
            pit.parallax.init();
            pit.notification.createHolder();
        }
        document.addEventListener("DOMContentLoaded", ready);
    </script>

    <!-- =============== VENDOR STYLES ===============-->
    <link rel="stylesheet" href="<?=$assets; ?>static/css/welcome.css?v=<?= filemtime("assets/static/css/welcome.css") ?>">

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
</body>

<!-- Yandex.Metrika counter --
<script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter44244999 = new Ya.Metrika({ id:44244999, clickmap:true, trackLinks:true, accurateTrackBounce:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/44244999" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

</html>
