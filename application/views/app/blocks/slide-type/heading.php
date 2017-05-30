<div class="form-group">

    <label for="heading_heading_<?=$slide->id; ?>" class="form-group__label">Заголовок</label>

    <div class="form-group__control-group">

        <input id="heading_heading_<?=$slide->id; ?>" type="text" class="form-group__control form-group__control-group-input js-ajax-edited" maxlength="90" placeholder="Заголовок" value="<?=$slide->heading; ?>" data-name="heading">

        <label class="form-group__control-group-addon bg-image <? echo $slide->image == (NULL || '') ? '' : 'bg-image--with-image'; ?>" title="Фоновая картинка">
            <i class="fa fa-image bg-image__icon" aria-hidden="true"></i>
            <i class="fa fa-close bg-image__close" aria-hidden="true"></i>
            <img src="<?=URL::site('uploads/slides/s_' . $slide->image); ?>" class="bg-image__image">
        </label>

    </div>

</div>

<div class="form-group">

    <label for="subheading_heading_<?=$slide->id; ?>" class="form-group__label">Подзаголовок</label>

    <textarea id="subheading_heading_<?=$slide->id; ?>" class="form-group__control js-ajax-edited" maxlength="150" rows="6" placeholder="Подзаголовок" data-name="subheading"><?=$slide->subheading; ?></textarea>

</div>