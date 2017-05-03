<!-- =============== PAGE STYLES ===============-->
<link rel="stylesheet" href="<?=$assets; ?>static/css/edit-presentation.css">
<link rel="stylesheet" href="<?=$assets; ?>static/css/presentation.css">


<section class="section animated fade__in">

    <div class="presentation-background"></div>


    <main class="presentation" style="transform: scale(.5); pointer-events: none">
        <?= View::factory('app/pages/presentation', array('presentaton' => $presentaton)); ?>
    </main>


    <div class="slide-block col-xs-12">
        <div id="slide-block__1">
            <ul class="tabs__header">
                <li class="tabs__btn" data-toggle="tabs" data-block="slideType">
                    Тип
                </li>
                <li class="tabs__btn tabs__btn--active" data-toggle="tabs" data-block="slideContent">
                    Содержание
                </li>
            </ul>
            <div class="tabs__content fl_l">
                <div id="slideType" class="tabs__block">
                    <?= View::factory('app/blocks/slide-type/default')?>
                </div>
                <div id="slideContent" class="tabs__block tabs__block--active">
<!--                    --><?//= View::factory('app/blocks/slide-type/heading')?>
                    <?= View::factory('app/blocks/slide-type/image')?>
<!--                    --><?//= View::factory('app/blocks/slide-type/paragraph')?>
<!--                    --><?//= View::factory('app/blocks/slide-type/choices')?>
<!--                    --><?//= View::factory('app/blocks/slide-type/options')?>
                </div>

            </div>
        </div>
    </div>

</section>

<!-- =============== PAGE SCRIPTS ===============-->
<script type="text/javascript" src="<?=$assets; ?>static/js/presentation.js"></script>
<script>
    function ready() {
        pit.tabs.init({
            search: false,
            counter: false
        });
        pit.form.init();
    }

    document.addEventListener("DOMContentLoaded", ready);
</script>