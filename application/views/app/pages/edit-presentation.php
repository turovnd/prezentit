<section class="section animated fade__in">

    <main class="presentation animated fade__in" style="transform: scale(0.57) translateY(120.125px) translateX(376.238px)">

        <?= View::factory('app/pages/presentation', array('presentaton' => $presentaton)); ?>

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
                <span class="config__status-text config__status-text--saved">Сохранено</span>
                <span class="config__status-text config__status-text--updating">Сохранение</span>
                <span class="config__status-text config__status-text--error">Ошибка</span>
            </li>
        </ul>

        <ul id="configContent" class="config__content">

            <? foreach ($presentaton->slides as $slide) : ?>

                <li id="config_<?=$slide->id; ?>" class="config__item">

                    <?= View::factory('app/blocks/slide-config/' . $slide->view, array('slide' => $slide->content)); ?>

                </li>

            <? endforeach; ?>

        </ul>

    </div>

    <input type="hidden" id="presentation_id" value="<?= $presentaton->id; ?>">
    <input type="hidden" id="slides_order" value="<?= $presentaton->slides_order; ?>">

</section>