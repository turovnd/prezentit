<!-- =============== PAGE STYLES ===============-->
<link rel="stylesheet" href="<?=$assets; ?>static/css/edit-presentation.css">
<link rel="stylesheet" href="<?=$assets; ?>static/css/presentation.css">


<section class="section animated fade__in">

    <main class="presentation animated fade__in" style="transform: scale(0.57) translateY(120.125px) translateX(376.238px)">
        <?= View::factory('app/pages/presentation', array('presentaton' => $presentaton)); ?>
        <div class="presentation__loader">
            <i class="fa fa-spinner fa-pulse fa-5x fa-fw presentation__loader-icon text-brand"></i>
        </div>
    </main>

    <div class="presentation-background"></div>


    <div class="slide-block col-xs-12">
        <div id="slide-block__1">
            <ul class="tabs__header">
                <li class="tabs__btn tabs__btn--active" data-toggle="tabs" data-block="slideContent">
                    Содержание
                </li>
            </ul>
            <div class="tabs__content fl_l">
                <div id="slideContent" class="tabs__block tabs__block--active">
                    <?= View::factory('app/blocks/slide-type/heading')?>
                    <?= View::factory('app/blocks/slide-type/image')?>
                    <?= View::factory('app/blocks/slide-type/paragraph')?>
                    <?= View::factory('app/blocks/slide-type/choices')?>
                </div>

            </div>
        </div>
    </div>

</section>

<!-- =============== PAGE SCRIPTS ===============-->
<script type="text/javascript" src="<?=$assets; ?>static/js/presentation.js"></script>
<script type="text/javascript" src="<?=$assets; ?>static/js/edit-presentation.js"></script>
<script>
    function ready() {
        pit.tabs.init({
            search: false,
            counter: false
        });
        pit.form.init();
        present.init({
            aside: false,
            slideNavigation: true,
            toggleInstruction: true,
            slideActions: false,
            keyboard: false
        });
        editPresent.init();
    }

    document.addEventListener("DOMContentLoaded", ready);
</script>