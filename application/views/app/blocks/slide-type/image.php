
<div class="form-group">

    <label for="heading_image_<?=$slide->id; ?>" class="form-group__label">Заголовок картинки</label>

    <input id="heading_image_<?=$slide->id; ?>" type="text" class="form-group__control js-ajax-edited" maxlength="90" placeholder="Заголовок картинки" value="<?=$slide->heading; ?>" data-id="<?=$slide->id; ?>" data-name="heading">

</div>

<div class="form-group">

    <div class="form-group__label">Картинка</div>

    <div class="m-t-5">
        <input id="imageInCenter" name="imageposition" type="radio" class="m-t-5 checkbox" checked>
        <label for="imageInCenter" class="checkbox-label">по центру слайда</label>
    </div>

    <div class="m-t-5">
        <input id="imageAsBackground" name="imageposition" type="radio" class="m-t-5 checkbox">
        <label for="imageAsBackground" class="checkbox-label">на весь слайд</label>
    </div>

    <div class="m-t-10">
        <input id="imageFile" type="file" class="hide">
        <label for="imageFile" class="btn btn--brand btn--round"><i class="fa fa-upload m-r-5" aria-hidden="true"></i> выбрать файл</label>
    </div>

</div>
