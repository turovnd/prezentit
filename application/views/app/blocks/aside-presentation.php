<nav class="presentation__aside-wrapper">

    <ul class="presentation__aside-menu">
        <li class="aside__item">
            <a role="button" class="aside__link" onclick="present.toggleFullScreen()">
                <i class="fa fa-expand" aria-hidden="true"></i>
                Во весь экран
            </a>
        </li>
        <li class="aside__item">
            <a role="button" class="aside__link">
                <i class="fa fa-eye-slash" aria-hidden="true"></i>
                Скрыть результаты
            </a>
        </li>
        <li class="aside__item">
            <a role="button" class="aside__link presentation__aside-link">
                <i class="fa fa-question" aria-hidden="true"></i>
                Помощь
                <i class="fa fa-angle-right fa--right" aria-hidden="true"></i>
            </a>
            <nav class="presentation__addition-wrapper">
                <ul class="presentation__addition-menu">
                    <li class="presentation__addition-item">
                        <span class="presentation__addition-text">
                            Помощь
                        </span>
                    </li>
                    <li class="presentation__addition-item">
                        <a role="button" class="presentation__addition-btn" onclick="present.toggleInstruction()">
                            <i class="fa fa-info" aria-hidden="true"></i>
                            Инструкции
                        </a>
                    </li>
                    <li class="presentation__addition-item">
                        <a role="button" class="presentation__addition-btn">
                            <i class="fa fa-keyboard-o" aria-hidden="true"></i>
                            Горячие клавиши
                        </a>
                    </li>
                </ul>
            </nav>
        </li>
    </ul>

    <ul class="presentation__aside-menu presentation__aside-menu--bottom">
        <li class="aside__item presentation__aside-item--bottom">
            <a href="<?= URL::site('app'); ?>" class="aside__link presentation__aside-link--bottom">
                <i class="fa fa-home" aria-hidden="true"></i>
                Домой
            </a>
        </li>
        <li class="aside__item presentation__aside-item--bottom">
            <a href="<?= URL::site('app/s/' . $presentaton->uri . '/edit'); ?>" class="aside__link presentation__aside-link--bottom">
                <i class="fa fa-edit" aria-hidden="true"></i>
                Изменить
            </a>
        </li>
    </ul>

</nav>




<!--<ul class="presentation__aside-menu">-->
<!--    <li class="aside__item">-->
<!--        <a href="--><?//=URL::site('app'); ?><!--" class="aside__link">-->
<!--            <i class="fa fa-cubes" aria-hidden="true"></i>-->
<!--            Во весь экран-->
<!--        </a>-->
<!--    </li>-->


<!--</ul>-->