<!-- =============== PAGE STYLES ===============-->
<link rel="stylesheet" href="<?=$assets; ?>vendor/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="<?=$assets; ?>static/css/all-presentations.css">


<div class="section__content clear-fix animated fade__in">

    <div class="section__container m-t-30">
        <button id="newPresent" class="btn btn--brand btn--round btn--scaled presentation__btn-new">
            <i aria-hidden="true" class="fa fa-plus"></i>
            Новая презентация
            <input id="newPresentFormCSRF" type="hidden" name="csrf" value="<?=Security::token(); ?>">
        </button>
        <div class="presentations__search form-group">
            <div class="form-group__control-group">
                <label for="searchPresentInput" class="form-group__control-group-addon">
                    <i aria-hidden="true" class="fa fa-search"></i>
                </label>
                <input type="text" id="searchPresentInput" class="form-group__control form-group__control-group-input" placeholder="Поиск презентации" required="">
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
                <? foreach ($presentations as $presentation) : ?>

                    <tr class="presentations__row">
                        <td class="presentations__title">
                            <a href="<?= URL::site('app/s/' . $presentation->uri . '/edit'); ?>" class="text-brand"><?=$presentation->name; ?></a>
                        </td>
                        <td class="presentations__time">
                            <?=$presentation->dt_update; ?>
                        </td>
                        <td class="presentations__actions">
                            <a role="button" class="text-brand presentation__share" data-code="<?=$presentation->code; ?>"><i aria-hidden="true" class="fa fa-share-alt"></i></a>
                            <a href="<?= URL::site('app/s/' . $presentation->uri); ?>" class="text-brand"><i aria-hidden="true" class="fa fa-slideshare"></i></a>
                            <a href="<?= URL::site('app/s/' . $presentation->uri . '/mobile'); ?>" class="text-brand"><i aria-hidden="true" class="fa fa-mobile"></i></a>
                            <a role="button" data-id="<?=$presentation->id; ?>" class="text-danger presentation__delete"><i aria-hidden="true" class="fa fa-trash"></i></a>
                            <a role="button" class="text-brand presentations__actions-toggle"><i aria-hidden="true" class="fa fa-ellipsis-h"></i></a>
                        </td>
                        <td class="presentations__actions-mobile">
                            <a role="button" class="text-brand presentation__share-mobile" data-code="<?=$presentation->code; ?>"><i aria-hidden="true" class="fa fa-share-alt"></i></a>
                            <a href="<?= URL::site('app/s/' . $presentation->uri); ?>" class="text-brand"><i aria-hidden="true" class="fa fa-slideshare"></i></a>
                            <a href="<?= URL::site('app/s/' . $presentation->uri . '/mobile'); ?>" class="text-brand"><i aria-hidden="true" class="fa fa-mobile"></i></a>
                            <a role="button" data-id="<?=$presentation->id; ?>" class="text-danger presentation__delete"><i aria-hidden="true" class="fa fa-trash"></i></a>
                            <a role="button" class="text-brand presentations__actions-close"><i aria-hidden="true" class="fa fa-close"></i></a>
                        </td>
                    </tr>
                <? endforeach; ?>
            </tbody>
        </table>


    </div>

</div>


<!-- =============== PAGE SCRIPTS ===============-->
<script type="text/javascript" src="<?=$assets; ?>vendor/moment/moment.min.js"></script>
<script type="text/javascript" src="<?=$assets; ?>vendor/moment/locale/ru.js"></script>
<script type="text/javascript" src="<?=$assets; ?>static/js/all-presentations.js"></script>

<script>
    allPresent.init();
</script>
