<div class="aside-app__brand">
    <?=$GLOBALS['SITE_NAME'];?>
</div>

<ul class="aside__menu">
    <li class="aside__item">
       <a href="<?=URL::site('app'); ?>" class="aside__link">
           <i class="fa fa-cubes" aria-hidden="true"></i>
           Презентации
       </a>
    </li>
    <li class="aside__item">
        <a href="<?=URL::site('app/profile'); ?>" class="aside__link">
            <i class="fa fa-user" aria-hidden="true"></i>
            Профиль
        </a>
    </li>
    <li class="aside__item">
        <a role="button" class="aside__link" data-toggle="collapse" data-area="helpCollapse" data-opened="false">
            <i class="fa fa-question" aria-hidden="true"></i>
            Помощь
            <i class="fa fa-angle-down fa--right" aria-hidden="true"></i>
        </a>
        <ul id="helpCollapse" class="aside__collapse collapse">
            <li class="aside__collapse-item">
                <a href="<?=URL::site('how-to' ); ?>" class="aside__collapse-link">
                    Как использовать
                </a>
            </li>
            <li class="aside__collapse-item">
                <a href="<?=URL::site('faq' ); ?>" class="aside__collapse-link">
                    Поддержка
                </a>
            </li>
        </ul>
    </li>
    <li class="aside__item">
        <a href="<?=URL::site('logout' ); ?>" class="aside__link">
            <i class="fa fa-sign-out" aria-hidden="true"></i>
            Выйти
        </a>
    </li>
</ul>