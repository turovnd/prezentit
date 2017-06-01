<a role="button" class="presentation__aside-open">
    <span class="presentation__aside-open-btn">
        <i class="fa fa-cog" aria-hidden="true"></i>
    </span>
</a>

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

    <?= View::factory('app/blocks/header-presentation', array('code' => $presentaton->code)); ?>

</div>

<div class="presentation__slides">

    <div class="presentation__brand-icon text-brand"> <?= $GLOBALS['SITE_NAME']; ?> </div>

    <? foreach ($presentaton->slides as $slide) : ?>

        <section id="slide_<?=$slide->id; ?>" class="presentation__slide <? echo $slide->view != 'choices' ? 'presentation__slide--items-center' : ''; ?>">

            <?= View::factory('app/blocks/slide-presentation/' . $slide->view, array('slide' => $slide->content)); ?>

        </section>

    <? endforeach; ?>

</div>

<input type="hidden" id="slides_order" value="<?=$presentaton->slides_order?>">

<div class="presentation__progress">
    <span class="presentation__progress-bar"></span>
</div>