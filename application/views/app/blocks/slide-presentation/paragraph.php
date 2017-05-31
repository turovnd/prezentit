<div class="presentation__slide-background-image" style="background-image: url(<?= URL::site('uploads/slides/o_' . $slide->image); ?>)"></div>

<? if ($slide->image_background == 1) : ?>

    <div class="background-opacity--light"></div>

<? else: ?>

    <div class="background-opacity--dark"></div>

<? endif; ?>

<div class="presentation__content presentation__content--center">

    <h1 class="presentation__content-heading <? echo $slide->image_background == 1 ? 'presentation__text--light' : 'presentation__text--dark'; ?>"> <?=$slide->heading; ?> </h1>

    <h3 class="presentation__content-text <? echo $slide->image_background == 1 ? 'presentation__text--light' : 'presentation__text--dark'; ?>"> <?=$slide->paragraph; ?> </h3>

</div>