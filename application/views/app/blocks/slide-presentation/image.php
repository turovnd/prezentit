<? if ($slide->image_position == 2) : ?>

    <div class="presentation__slide-background-image" style="opacity: 1; background-image: url(<?= URL::site('uploads/slides/o_' . $slide->image); ?>)"></div>

<? endif; ?>

<div class="slide-image">

    <? if ($slide->image_position == 1) : ?>

        <div class="slide-image__image" style="background-image: url(<?= URL::site('uploads/slides/o_' . $slide->image); ?>)"></div>

    <? endif; ?>

    <h1 class="slide-image__title <? echo $slide->image_position == 2 ? 'slide-image__title--bottom' : ''; ?>"> <?=$slide->heading; ?> </h1>

</div>
