<div id="toggleInstruction" class="cursor-pointer" data-toggle="collapse" data-area="instruction" data-opened="false" onclick="document.getElementById('instruction').removeAttribute('data-height')">
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

<div class="presentation__slides">

    <section class="presentation__slide">
        <?= View::factory('app/blocks/slide-presentation/heading'); ?>
    </section>

</div>