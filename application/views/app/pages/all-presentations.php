<!-- =============== PAGE STYLES ===============-->
<link rel="stylesheet" href="<?=$assets; ?>static/css/all-presentations.css?v=<?= filemtime("assets/static/css/all-presentations.css") ?>">


<div class="section__content">

    <div class="section__container m-t-30">
        <button id="newPresent" class="btn btn--brand btn--round btn--scaled presentation__btn-new" data-toggle="modal" data-area="presentModal">
            <i aria-hidden="true" class="fa fa-plus"></i>
            Новая презентация
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

                    <tr class="presentations__row" id="row<?=$presentation->id; ?>">
                        <td class="presentations__title">
                            <a href="<?= URL::site('app/s/' . $presentation->uri . '/edit'); ?>" class="text-brand"><?=$presentation->name; ?></a>
                        </td>
                        <td class="presentations__time">
                            <?=$presentation->dt_update; ?>
                        </td>
                        <td class="presentations__actions">
                            <a href="<?= URL::site('app/s/' . $presentation->uri); ?>" class="text-brand">
                                <i aria-hidden="true" class="fa fa-slideshare"></i>
                            </a>
                            <a role="button" onclick="allPresent.deletePresentation(this)" data-id="<?=$presentation->id; ?>" class="text-danger">
                                <i aria-hidden="true" class="fa fa-trash"></i>
                            </a>
                            <a role="button" class="text-brand presentations__actions-toggle">
                                <i aria-hidden="true" class="fa fa-ellipsis-h"></i>
                            </a>
                        </td>
                        <td class="presentations__actions-mobile">
                            <a href="<?= URL::site('app/s/' . $presentation->uri); ?>" class="text-brand">
                                <i aria-hidden="true" class="fa fa-slideshare"></i>
                            </a>
                            <a role="button" onclick="allPresent.deletePresentation(this)" data-id="<?=$presentation->id; ?>" class="text-danger">
                                <i aria-hidden="true" class="fa fa-trash"></i>
                            </a>
                            <a role="button" class="text-brand presentations__actions-close">
                                <i aria-hidden="true" class="fa fa-close"></i>
                            </a>
                        </td>
                    </tr>
                <? endforeach; ?>
            </tbody>
        </table>


    </div>

    <form class="modal" id="presentModal" tabindex="-1">
        <div class="modal__content modal__content--small">
            <div class="modal__wrapper">
                <div class="modal__header">
                    <button type="button" class="modal__title-close" data-close="modal">
                        <i class="fa fa-close" aria-hidden="true"></i>
                    </button>
                    <h4 id="modalInfoHeading" class="modal__title">
                        Новая презентация
                    </h4>
                </div>
                <div id="modalInfoContent" class="modal__body">
                    <div class="form-group m-b-0">
                        <label for="newPresentName" class="form-group__label">Введите название презентации</label>
                        <input id="newPresentName" type="text" name="name" class="form-group__control" maxlength="256">
                    </div>
                    <input type="hidden" name="csrf" value="<?=Security::token(); ?>">
                </div>
                <div class="modal__footer">
                    <button type="submit" class="btn btn--brand m-r-0">Создать</button>
                </div>
            </div>
        </div>
    </form>

</div>


<!-- =============== PAGE SCRIPTS ===============-->
<script type="text/javascript" src="<?=$assets; ?>vendor/moment/moment.min.js?v=<?= filemtime("assets/vendor/moment/moment.min.js") ?>"></script>
<script type="text/javascript" src="<?=$assets; ?>vendor/moment/locale/ru.js?v=<?= filemtime("assets/vendor/moment/locale/ru.js") ?>"></script>
<script type="text/javascript" src="<?=$assets; ?>static/js/all-presentations.js?v=<?= filemtime("assets/static/js/all-presentations.js") ?>"></script>
