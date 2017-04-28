<div class="container">

    <a href="<?=URL::site('/'); ?>" class="header__brand fl_l">
        <?=$GLOBALS['SITE_NAME'];?>
    </a>

    <ul class="header__menu fl_r">
        <li class="header__item">
           <a href="<?=URL::site('why'); ?>" class="header__link hidden-xs">Почему <?=$GLOBALS["SITE_NAME"]; ?></a>
        </li>
        <li class="header__item">
            <a href="<?=URL::site('how-to'); ?>" class="header__link hidden-xs">Как работает</a>
        </li>
        <li class="header__item">
            <a href="<?= URL::site('login')?>" class="header__link hidden-xs">Войти</a>
        </li>
        <li class="header__item">
            <a href="<?= URL::site('signup')?>" class="header__link btn btn--round btn--scaled hidden-xs">Регистрация</a>
        </li>
        <li class="header__item">
            <a href="<?= URL::site('signup')?>" class="header__link hidden-sm hidden-md hidden-lg">Регистрация</a>
        </li>
    </ul>

</div>