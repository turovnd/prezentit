<div class="presentation__slide-background-image" style="background-image: url(<?= URL::site('uploads/slides/o_' . $slide->image); ?>)"></div>

<div class="background-opacity--light" style="background: rgba(255,255,255,.85);"></div>


<div class="presentation__content slide-choices">

    <h1 class="slide-choices__title"> <?= $slide->heading; ?> </h1>

    <? if ($slide->image != "") : ?>

        <div class="slide-choices__block">

            <div class="slide-choices__image animated fade__in" style="background-image: url(<?= URL::site('uploads/slides/o_' . $slide->image); ?>)"></div>

        </div>

    <? endif; ?>

    <input type="hidden" class="results-in-percents" value="<?= $slide->results_in_percents; ?>">

    <div class="slide-choices__block">

        <div class="slide-choices__content animated <? echo $slide->image != "" ? '' : 'fade__in'; ?>">

            <?
            $defaultAnswers = '[{"text": "", "image": ""}, {"text": "", "image": ""}]';

            $answers = json_decode($slide->answers) != NULL ? json_decode($slide->answers) : json_decode($defaultAnswers);
            ?>

            <? foreach ($answers as $answer) : ?>

                <div class="slide-choices__option-wrapper">

                    <div class="slide-choices__option-score" data-score="<?= 0; ?>"> <? echo $slide->results_in_percents ? 0 . "%" : 0; ?> </div>

                    <? if ($answer->image != "") : ?>

                        <img class="slide-choices__option-image" src="<?=URL::site('uploads/slides/answers/b_' . $answer->image);?>">

                    <? endif; ?>

                    <div class="slide-choices__option-bar bg-brand"></div>

                    <div class="slide-choices__option-content"> <?=$answer->text; ?> </div>

                </div>

            <? endforeach; ?>

        </div>

    </div>

    <? if ($slide->image != "") : ?>

        <div class="slide-choices__action animated fade__in">

            <button role="button" class="btn btn--round btn--scaled btn--brand slide-choices__action-btn" data-status="image">
                <i class="fa fa-angle-down slide-choices__action-icon" aria-hidden="true"></i>
                <span class="slide-choices__action-text">Показать результаты</span>
            </button>

        </div>

    <? endif; ?>
</div>


<div class="presentation__reactions-wrapper">
    <div class="presentation__reaction">
        <div class="presentation__reaction-votes">2</div>
        <i class="fa fa-users presentation__reaction-icon" aria-hidden="true"></i>
    </div>
</div>
