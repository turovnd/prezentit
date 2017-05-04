
<div class="presentation__aside-open">
    <a role="button" class="presentation__aside-open-btn">
        <i class="fa fa-cog" aria-hidden="true"></i>
    </a>
</div>

<aside class="presentation__aside">

    <?= View::factory('app/blocks/aside-presentation', array('presentaton' => $presentaton)); ?>

</aside>

<div class="presentation__navigation-btns">
    <a role="button" class="presentation__navigation-btn presentation__navigation-btn--left">
        <i class="fa fa-angle-left" aria-hidden="true"></i>
    </a>
    <a role="button" class="presentation__navigation-btn presentation__navigation-btn--right">
        <i class="fa fa-angle-right" aria-hidden="true"></i>
    </a>
</div>

<div id="toggleInstruction" class="presentation__header-wrapper" data-toggle="collapse" data-area="instruction" data-opened="false" onclick="document.getElementById('instruction').removeAttribute('data-height')">
    <?= View::factory('app/blocks/header-presentation'); ?>
</div>

<div class="presentation__slides">

    <div class="presentation__brand-icon text-brand">
        <?=$GLOBALS['SITE_NAME'];?>
    </div>

    <?= View::factory('app/blocks/slide-presentation/heading'); ?>
    <?= View::factory('app/blocks/slide-presentation/image'); ?>
    <?= View::factory('app/blocks/slide-presentation/paragraph'); ?>
    <?= View::factory('app/blocks/slide-presentation/choices'); ?>

</div>


<div class="presentation__progress">
    <span class="presentation__progress-bar"></span>
</div>