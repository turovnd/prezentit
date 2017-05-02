<?= View::factory('app/blocks/header-presentation'); ?>


<aside class="presentation__aside">

    <?= View::factory('app/blocks/aside-presentation'); ?>

</aside>

<button>open aside</button>

<div class="presentation__slides">

    <section class="presentation__slide">
        <?= View::factory('app/blocks/slide-presentation/heading'); ?>
    </section>

</div>