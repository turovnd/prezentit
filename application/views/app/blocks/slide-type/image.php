<div class="m-t-20">

    <div class="form-group">
        <label for="" class="form-group__label">Заголовок изображения</label>
        <input type="text" class="form-group__control" maxlength="90">
    </div>

    <div class="form-group">
        <div class="form-group__label">Фон изображения</div>
        <div class="m-t-5">
            <input id="imageFile" type="file" class="hide">
            <label for="imageFile" class="btn btn--brand btn--round"><i class="fa fa-upload m-r-5" aria-hidden="true"></i> выбрать файл</label>
        </div>
        <div class="m-t-10">
            <input id="imageInCenter" type="checkbox" class="m-t-5 checkbox">
            <label for="imageInCenter" class="checkbox-label">по центру слайда</label>
        </div>
        <div class="m-t-10">
            <input id="imageAsBackground" type="checkbox" class="m-t-5 checkbox">
            <label for="imageAsBackground" class="checkbox-label">на весь слайд</label>
        </div>
    </div>

    <div class="form-group clear-fix">
        <label for="" class="form-group__label">Реакции аудитории <i class="fa fa-question reaction-tooltip-icon" aria-hidden="true"></i></label>
        <div class="m-t-5 clear-fix">
            <div class="text-center fl_l m-r-20">
                <label for="reactionLikes" class="reactions__label">
                    <i class="fa fa-heart" aria-hidden="true"></i>
                </label>
                <input id="reactionLikes" type="checkbox" class="m-t-5 checkbox">
                <label for="reactionLikes" class="checkbox-label reactions__label-checkbox"></label>
            </div>
            <div class="text-center fl_l m-r-20">
                <label for="reactionQuestion" class="reactions__label">
                    <i class="fa fa-question" aria-hidden="true"></i>
                </label>
                <input id="reactionQuestion" type="checkbox" class="m-t-5 checkbox">
                <label for="reactionQuestion" class="checkbox-label reactions__label-checkbox"></label>
            </div>
            <div class="text-center fl_l m-r-20">
                <label for="reactionThumbsUp" class="reactions__label">
                    <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                </label>
                <input id="reactionThumbsUp" type="checkbox" class="m-t-5 checkbox">
                <label for="reactionThumbsUp" class="checkbox-label reactions__label-checkbox"></label>
            </div>
            <div class="text-center fl_l m-r-20">
                <label for="reactionThumbsDown"class="reactions__label">
                    <i class="fa fa-thumbs-down" aria-hidden="true"></i>
                </label>
                <input id="reactionThumbsDown" type="checkbox" class="m-t-5 checkbox">
                <label for="reactionThumbsDown" class="checkbox-label reactions__label-checkbox"></label>
            </div>
        </div>
    </div>
</div>
