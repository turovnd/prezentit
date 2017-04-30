<!-- =============== SECTION STYLES ===============-->
<link rel="stylesheet" href="<?=$assets; ?>static/css/aside-slides.css">

<div class="aside-app__brand">
    <?=$_SERVER['SITE_NAME'];?>
</div>

<div class="aside__menu">
    <a class="aside__item aside__item--active">
        <span class="aside__item-number">1</span>
        <span class="aside__item-action">
            <i class="fa fa-trash aside__item-action-icon text-danger" aria-hidden="true"></i>
        </span>
        <?= View::factory('app/blocks/slide-aside/heading')?>
    </a>

    <a class="aside__item">
        <span class="aside__item-number">2</span>
        <span class="aside__item-action">
            <i class="fa fa-trash aside__item-action-icon text-danger" aria-hidden="true"></i>
        </span>
        <?= View::factory('app/blocks/slide-aside/image')?>
    </a>

    <a class="aside__item">
        <span class="aside__item-number">3</span>
        <span class="aside__item-action">
            <i class="fa fa-trash aside__item-action-icon text-danger" aria-hidden="true"></i>
        </span>
        <?= View::factory('app/blocks/slide-aside/paragraph')?>
    </a>

    <a class="aside__item">
        <span class="aside__item-number">4</span>
        <span class="aside__item-action">
            <i class="fa fa-trash aside__item-action-icon text-danger" aria-hidden="true"></i>
        </span>
        <?= View::factory('app/blocks/slide-aside/multiply_choice')?>
    </a>

</div>

<div class="aside-nav">
    <a class="aside-nav__item">
        <i class="fa fa-plus aside-nav__item-icon" aria-hidden="true"></i>
        Новый слайд
    </a>
    <a href="<?= URL::site('app'); ?>" class="aside-nav__item">
        <i class="fa fa-home aside-nav__item-icon" aria-hidden="true"></i>
        Все презентации
    </a>
</div>
