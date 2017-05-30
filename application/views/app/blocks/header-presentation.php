<header class="presentation__header">
    <span class="presentation__header-text">Перейдите на</span>
    <b>www.prezentit.ru</b>
    <span class="presentation__header-text">и используйте код</span>
    <span class="presentation__code"><?= $code; ?></span>
</header>


<div id="instruction" class="collapse presentation__instruction">

    <ul class="presentation__instruction-content container">
        <li class="presentation__instruction-step">
            <img src="<?=$assets; ?>static/img/welcome/graphphone.png" alt="Graph Phone" class="presentation__instruction-image">
            <p class="presentation__instruction-text">
                <span class="presentation__instruction-number bg-brand">1</span>
                Возьмите телефон
            </p>
        </li>
        <li class="presentation__instruction-step">
            <img src="<?=$assets; ?>static/img/welcome/sitelink.png" alt="Graph Phone" class="presentation__instruction-image">
            <p class="presentation__instruction-text">
                <span class="presentation__instruction-number bg-brand">2</span>
                Перейдите по ссылке
            </p>
        </li>
        <li class="presentation__instruction-step">
            <img src="<?=$assets; ?>static/img/welcome/entercode.png" alt="Graph Phone" class="presentation__instruction-image">
            <p class="presentation__instruction-text">
                <span class="presentation__instruction-number bg-brand">3</span>
                Введите код <span class="presentation__code"><?= $code; ?></span> <br> и оценивайте
            </p>
        </li>
    </ul>
</div>