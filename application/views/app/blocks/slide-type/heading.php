<div class="form-group">

    <label for="heading_heading_<?=$slide->id; ?>" class="form-group__label">Заголовок</label>

    <div class="form-group__control-group">

        <input id="heading_heading_<?=$slide->id; ?>" type="text" class="form-group__control form-group__control-group-input js-ajax-edited" maxlength="90" placeholder="Заголовок" value="<?=$slide->heading; ?>" data-id="<?=$slide->id; ?>" data-name="heading">

        <label for="bgImage" class="form-group__control-group-addon cursor-pointer" title="Фоновая картинка">
            <i class="fa fa-image" aria-hidden="true"></i>
            <input id="bgImage" type="file" class="hide">
        </label>

    </div>

</div>

<div class="form-group">

    <label for="subheading_heading_<?=$slide->id; ?>" class="form-group__label">Подзаголовок</label>

    <textarea id="subheading_heading_<?=$slide->id; ?>" class="form-group__control js-ajax-edited" maxlength="150" rows="6" placeholder="Подзаголовок" data-id="<?=$slide->id; ?>" data-name="subheading"><?=$slide->subheading; ?></textarea>

</div>