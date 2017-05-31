
<div class="form-group">

    <label for="heading_image_<?=$slide->id; ?>" class="form-group__label">Заголовок картинки</label>

    <input id="heading_image_<?=$slide->id; ?>" type="text" class="form-group__control js-ajax-edited" maxlength="90" placeholder="Заголовок картинки" value="<?=$slide->heading; ?>" data-name="heading">

</div>

<div class="form-group">

    <div class="text-bold">Картинка</div>

    <div class="col-xs-7 p-l-0 p-r-0">
        <p class="m-t-5">
            <input id="image_center_image_<?=$slide->id; ?>" name="imageposition_<?=$slide->id; ?>" type="radio" class="m-t-5 checkbox" data-name="image_position" data-value="1" <? echo $slide->image_position == 1 ? 'checked' : ''; ?>>
            <label for="image_center_image_<?=$slide->id; ?>" class="checkbox-label">по центру слайда</label>
        </p>
        <p class="m-t-5">
            <input id="image_back_image_<?=$slide->id; ?>" name="imageposition_<?=$slide->id; ?>" type="radio" class="m-t-5 checkbox" data-name="image_position" data-value="2" <? echo $slide->image_position == 2 ? 'checked' : ''; ?>>
            <label for="image_back_image_<?=$slide->id; ?>" class="checkbox-label">на весь слайд</label>
        </p>
    </div>
    <div class="col-xs-5">
        <label class="bg-image image-type <? echo $slide->image == (NULL || '') ? '' : 'bg-image--with-image'; ?>" title="Выбрать файл" value="<?=$slide->image?>" data-name="image">
            <i class="fa fa-image bg-image__icon" aria-hidden="true"></i>
            <i class="fa fa-close bg-image__close" aria-hidden="true"></i>
            <img src="<?=URL::site('uploads/slides/m_' . $slide->image); ?>" class="bg-image__image">
        </label>
    </div>

</div>
