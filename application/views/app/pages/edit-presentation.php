<!-- =============== PAGE STYLES ===============-->
<link rel="stylesheet" href="<?=$assets; ?>frontend/modules/css/edit-presentation.css">
<link rel="stylesheet" href="<?=$assets; ?>frontend/modules/css/presentation.css">


<section class="section animated fade__in">

    <main class="presentation animated fade__in" style="transform: scale(0.57) translateY(120.125px) translateX(376.238px)">
        <?= View::factory('app/pages/presentation', array('presentaton' => $presentaton)); ?>
        <div class="presentation__loader">
            <i class="fa fa-spinner fa-pulse fa-5x fa-fw presentation__loader-icon text-brand"></i>
        </div>
    </main>

    <div class="presentation-background"></div>
    
    <div class="config">

        <ul class="config__header">
            <li class="config__btn">
                Содержание
            </li>
            <li class="fl_r config__status">
                <span class="config__status-icon">
                    <i class="fa fa-spinner fa-pulse"></i>
                    <i class="fa fa-check"></i>
                    <i class="fa fa-close"></i>
                </span>
                <span class="config__status-text">Сохранено</span>
            </li>
        </ul>

        <ul id="configContent" class="config__content">

            <? foreach ($slides as $slide) : ?>

                <li id="config_<?=$slide->id; ?>" class="config__item">

                    <?= View::factory('app/blocks/slide-type/' . $slide->view, array('slide' => $slide->content)); ?>

                </li>

            <? endforeach; ?>

        </ul>

    </div>

    <input type="hidden" id="presentation_id" value="<?= $presentaton->id; ?>">
    <input type="hidden" id="slides_order" value="<?= $presentaton->slides_order; ?>">

</section>

<!-- =============== PAGE SCRIPTS ===============-->
<script type="text/javascript" src="<?=$assets; ?>frontend/modules/js/presentation.js"></script>
<script type="text/javascript" src="<?=$assets; ?>frontend/modules/js/edit-presentation.js"></script>
<script>
    function ready() {
        pit.tabs.init({
            search: false,
            counter: false
        });
        pit.form.init();
        present.init({
            aside: false,
            slideNavigation: false,
            toggleInstruction: false,
            slideActions: false,
            keyboard: false
        });
        editPresent.init();
    }

    document.addEventListener("DOMContentLoaded", ready);
</script>