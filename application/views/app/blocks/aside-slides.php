<!-- =============== SECTION STYLES ===============-->
<link rel="stylesheet" href="<?=$assets; ?>static/css/aside-slides.css">

<div class="aside-app__brand">
    <?=$GLOBALS['SITE_NAME'];?>
</div>

<div class="aside__menu">

    <? foreach ($slides as $slideKey => $slide) : ?>

        <a id="aside_<?=$slide->id; ?>" role="button" class="aside__item">

            <span class="aside__item-number"><?=$slideKey + 1; ?></span>

            <span class="aside__item-action">

                <i id="delete_<?=$slide->id; ?>" class="fa fa-trash aside__item-action-icon text-danger js-delete-slide" aria-hidden="true"></i>

            </span>

            <?= View::factory('app/blocks/slide-aside/' . $slide->view, array('slide' => $slide->content)); ?>

        </a>

    <? endforeach; ?>

</div>

<div class="aside-nav">
    <a role="button" class="aside-nav__item js-new-slide">
        <i class="fa fa-plus aside-nav__item-icon" aria-hidden="true"></i>
        Новый слайд
    </a>
    <a href="<?= URL::site('app'); ?>" class="aside-nav__item">
        <i class="fa fa-home aside-nav__item-icon" aria-hidden="true"></i>
        Все презентации
    </a>
</div>
