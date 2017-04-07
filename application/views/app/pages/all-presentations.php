<!-- =============== PAGE STYLES ===============-->
<link rel="stylesheet" href="<?=$assets; ?>vendor/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="<?=$assets; ?>static/css/all-presentations.css">


<div class="section__content clear-fix">

    <div class="section__container m-t-30">
        <button id="newPresentation" class="btn btn--brand btn--round btn--scaled presentation__btn-new">
            <i aria-hidden="true" class="fa fa-plus"></i>
            Новая презентация
            <input id="newPresentFormCSRF" type="hidden" name="csrf" value="<?=Security::token(); ?>">
        </button>
        <div class="presentations__search form-group">
            <div class="form-group__control-group">
                <label for="searchInput" class="form-group__control-group-addon">
                    <i aria-hidden="true" class="fa fa-search"></i>
                </label>
                <input type="text" id="searchInput" class="form-group__control form-group__control-group-input" placeholder="Поиск презентации" required="">
            </div>
        </div>
    </div>

    <div class="section__container">

        <table class="presentations">
            <thead class="presentations__header">
                <tr>
                    <th>
                        Название презентации
                    </th>
                    <th style="width: 200px">
                        Последнее изменение
                    </th>
                    <th style="width: 150px"></th>
                </tr>
            </thead>

            <tbody class="presentations__body">
                <tr class="presentations__row">
                    <td class="presentations__title">
                        <a href="" class="text-brand">НАзвание очень большое для презентации</a>
                    </td>
                    <td class="presentations__time">
                        30 Декабря 2017
                    </td>
                    <td class="presentations__actions">
                        <a href="" class="text-brand"><i aria-hidden="true" class="fa fa-share-alt"></i></a>
                        <a href="" class="text-brand"><i aria-hidden="true" class="fa fa-play-circle-o"></i></a>
                        <a href="" class="text-brand"><i aria-hidden="true" class="fa fa-copy"></i></a>
                        <a href="" class="text-danger"><i aria-hidden="true" class="fa fa-trash"></i></a>
                        <a role="button" class="text-brand presentations__actions-toggle"><i aria-hidden="true" class="fa fa-ellipsis-h"></i></a>
                    </td>
                    <td class="presentations__actions-mobile">
                        <a href="" class="text-brand"><i aria-hidden="true" class="fa fa-share-alt"></i></a>
                        <a href="" class="text-brand"><i aria-hidden="true" class="fa fa-play-circle-o"></i></a>
                        <a href="" class="text-brand"><i aria-hidden="true" class="fa fa-copy"></i></a>
                        <a href="" class="text-danger"><i aria-hidden="true" class="fa fa-trash"></i></a>
                        <a role="button" class="text-brand presentations__actions-close"><i aria-hidden="true" class="fa fa-close"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>


    </div>

</div>


<!-- =============== PAGE SCRIPTS ===============-->
<script type="text/javascript" src="<?=$assets; ?>vendor/sweetalert2/sweetalert2.min.js"></script>
<script type="text/javascript" src="<?=$assets; ?>static/js/all-presentations.js"></script>
