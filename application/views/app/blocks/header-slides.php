<!-- =============== SECTION STYLES ===============-->
<link rel="stylesheet" href="<?=$assets; ?>static/css/header-slides.css">

<a href="<?=URL::site('/app'); ?>" class="header-app__brand fl_l">
    <?=$_SERVER['SITE_NAME'];?>
</a>

<div class="header__page fl_l">

    <div class="section__container">

        <h2 class="header__title fl_l">
            <span id="PresentName" class="header__title-text fl_l"><?= $presentaton->name; ?></span>
            <a id="editPresentNameBtn" role="button" class="header__title-btn-edit fl_l text-brand"><i class="fa fa-pencil" aria-hidden="true"></i></a>
            <div id="editPresentNameFrom" class="form-group hide">
                <div class="form-group__control-group presentation-name">
                    <input id="editPresentNameInput" type="text" class="form-group__control-group-input presentation-name__input" value="">
                    <a id="editPresentNameBtnSubmit" role="button" class="form-group__control-group-addon presentation-name__btn">
                        <i class="fa fa-check" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </h2>

        <ul class="header__menu fl_r hidden-xs">
            <li class="header__item">
                <a role="button" class="header__btn-icon text-brand">
                    <i class="fa fa-cog" aria-hidden="true"></i>
                </a>
            </li>
            <li class="header__item">
                <a href="<?= URL::site('app/s/' . $presentaton->uri); ?>" class="header__link btn btn--round btn--scaled">
                    <i class="fa fa-slideshare m-r-5" aria-hidden="true"></i>
                    Смотреть
                </a>
            </li>
        </ul>
        <div class="header__menu fl_r hidden-sm hidden-md hidden-lg">
            <a href="<?= URL::site('app/s/' . $presentaton->uri . '/mobile'); ?>" class="header__btn-icon text-brand">
                <i class="fa fa-mobile" aria-hidden="true"></i>
            </a>
            <a href="<?= URL::site('app/s/' . $presentaton->uri); ?>" class="header__btn-icon text-brand">
                <i class="fa fa-slideshare" aria-hidden="true"></i>
            </a>
            <a role="button" class="header__btn-icon text-brand">
                <i class="fa fa-cog" aria-hidden="true"></i>
            </a>
        </div>

    </div>
</div>

<!-- =============== SECTION STYLES ===============-->
<script type="text/javascript" src="<?=$assets; ?>static/js/header-slides.js"></script>