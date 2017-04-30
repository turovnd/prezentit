<!-- =============== SECTION STYLES ===============-->
<link rel="stylesheet" href="<?=$assets; ?>static/css/edit-presentation.css">

<div class="section__content clear-fix animated fade__in">

    <div class="presentation-wrapper">

    </div>

    <div class="slide-block col-xs-12">
        <div id="slide-block__1">
            <ul class="tabs__header">
                <li class="tabs__btn" data-toggle="tabs" data-block="slideType">
                    Тип
                </li>
                <li class="tabs__btn tabs__btn--active" data-toggle="tabs" data-block="slideContent">
                    Содержание
                </li>
            </ul>
            <div class="tabs__content fl_l">
                <div id="slideType" class="tabs__block">
                    <?= View::factory('app/blocks/slide-type/default')?>
                </div>
                <div id="slideContent" class="tabs__block tabs__block--active">
                    <?= View::factory('app/blocks/slide-type/heading')?>
<!--                    --><?//= View::factory('app/blocks/slide-type/image')?>
                </div>

            </div>
        </div>
    </div>

</div>

<script>
    function ready() {
        pit.tabs.init({
            search: false,
            counter: false
        });
    }

    document.addEventListener("DOMContentLoaded", ready);
</script>