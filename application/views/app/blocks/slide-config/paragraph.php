<div class="form-group">

    <label for="heading_paragraph_<?=$slide->id; ?>" class="form-group__label">Заголовок</label>

    <div class="form-group__control-group">

        <input id="heading_paragraph_<?=$slide->id; ?>" type="text" class="form-group__control form-group__control-group-input js-ajax-edited" maxlength="90" placeholder="Заголовок" value="<?=$slide->heading; ?>" data-name="heading">

        <label class="form-group__control-group-addon bg-image <? echo $slide->image == (NULL || '') ? '' : 'bg-image--with-image'; ?>" title="Фоновая картинка" value="<?=$slide->image?>" data-name="image">
            <i class="fa fa-image bg-image__icon" aria-hidden="true"></i>
            <i class="fa fa-close bg-image__close" aria-hidden="true"></i>
            <img src="<?=URL::site('uploads/slides/s_' . $slide->image); ?>" class="bg-image__image">
        </label>

    </div>

</div>

<div class="form-group">

    <label for="paragraph_paragraph_<?=$slide->id; ?>"  class="form-group__label">Параграф</label>

    <textarea id="paragraph_paragraph_<?=$slide->id; ?>" class="form-group__control js-ajax-edited" maxlength="300" rows="6" placeholder="Параграф" data-name="paragraph"><?=$slide->paragraph; ?></textarea>

</div>

<div class="form-group">

    <div class="text-bold">Цвет текста</div>

    <div class="m-t-5">

        <span class="">
            <input id="image_background_dark_paragraph_<?=$slide->id; ?>" name="image_background_<?=$slide->id; ?>" type="radio" class="m-t-5 checkbox" data-name="image_background" data-value="1" <? echo $slide->image_background == 1 ? 'checked' : ''; ?>>
            <label for="image_background_dark_paragraph_<?=$slide->id; ?>" class="checkbox-label">темный</label>
        </span>

        <span class="m-l-15">
            <input id="image_background_light_paragraph_<?=$slide->id; ?>" name="image_background_<?=$slide->id; ?>" type="radio" class="m-t-5 checkbox" data-name="image_background" data-value="2" <? echo $slide->image_background == 2 ? 'checked' : ''; ?>>
            <label for="image_background_light_paragraph_<?=$slide->id; ?>" class="checkbox-label">светлый</label>
        </span>

    </div>
</div>
