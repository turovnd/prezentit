<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Ошибка <?= $code; ?>. Неверный запрос</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel='stylesheet' href="<?=URL::base() . 'assets/static/css/error.css'; ?>">
	</head>
	<body class="valign error_block">
		<div class="center">
            <h1 class="h1 error_title">Prezit</h1>
			<p class="error_text"><b>Ошибка <?= $code; ?>.</b> <?= $message; ?></p>
			<a class="error_link text_link" onclick = "window.history.back()">Назад</a>
			<a href="/" class="error_link text_link">Главная</a>
		</div>
	</body>
</html>
