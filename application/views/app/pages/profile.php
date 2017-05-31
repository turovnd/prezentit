<div class="section__content clear-fix">
    <form class="col-xs-12" id="changeProfile">
        <h3 class="col-xs-12">Изменение основной информации</h3>

        <div class="form-group col-xs-12 col-md-8">
            <label for="profileName" class="form-group__label">Имя</label>
            <input id="profileName" type="text" name="name" class="form-group__control" value="<?=$profile->name; ?>">
        </div>

        <div class="form-group col-xs-12 col-md-8">
            <label class="form-group__label">Эл.почта</label>
            <p class="form-group__control" disabled><?=$profile->email; ?></p>
        </div>

        <div class="form-group col-xs-12 col-md-8">
            <input type="checkbox" id="newsletter" name="newsletter" class="checkbox" <? if($profile->newsletter == 1): echo "checked"; endif;?>>
            <label for="newsletter" class="checkbox-label">Подписка на информационную рассылку</label>
        </div>

        <div class="form-group col-xs-12 col-md-8 m-t-15">
            <input type="hidden" name="csrf" value="<?=Security::token(); ?>">
            <input type="hidden" name="id" value="<?=$profile->id?>">
            <button type="submit" class="btn btn--round btn--brand btn--scaled">
                Обновить информацию
            </button>
        </div>
    </form>

    <div class="col-xs-12">
        <div class="divider m-l-15 m-r-15"></div>
    </div>

    <form class="col-xs-12" id="changePassword">
        <h3 class="col-xs-12">Изменение пароля</h3>

        <div class="form-group col-xs-12 col-md-8">
            <label for="curPass" class="form-group__label">Текущий пароль</label>
            <input id="curPass" name="curPass" type="password" class="form-group__control">
        </div>

        <div class="form-group col-xs-12 col-md-8">
            <label for="newPass" class="form-group__label">Новый пароль</label>
            <input id="newPass" name="newPass" type="password" class="form-group__control">
        </div>

        <div class="form-group col-xs-12 col-md-8">
            <label for="newPass1" class="form-group__label">Подтверждения нового пароля</label>
            <input id="newPass1" name="newPass1" type="password" class="form-group__control">
        </div>

        <div class="form-group col-xs-12 col-md-8">
            <input type="hidden" name="csrf" value="<?=Security::token(); ?>">
            <input type="hidden" name="id" value="<?=$profile->id?>">
            <button type="submit" class="btn btn--round btn--brand btn--scaled">
                Изменить пароль
            </button>
        </div>
    </form>

</div>

<!-- =============== PAGE SCRIPTS ===============-->
<script type="text/javascript" src="<?=$assets;?>static/js/profile.js?v=<?= filemtime("assets/static/js/profile.js") ?>"></script>