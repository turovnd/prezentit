<div id="toggleInstruction" class="presentation__header-wrapper" data-toggle="collapse" data-area="instruction" data-opened="false" onclick="document.getElementById('instruction').removeAttribute('data-height')">
    <?= View::factory('app/blocks/header-presentation'); ?>
</div>

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


<div class="presentation__slides">

    <section class="presentation__slide" style="background: red">
        <?= View::factory('app/blocks/slide-presentation/heading'); ?>
    </section>
    <section class="presentation__slide" style="background: blue">
        <?= View::factory('app/blocks/slide-presentation/heading'); ?>
    </section>
    <section class="presentation__slide" style="background: green">
        <?= View::factory('app/blocks/slide-presentation/heading'); ?>
    </section>

</div>