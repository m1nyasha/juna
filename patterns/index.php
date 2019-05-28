<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Отладка приложение Just One Framework</title>
    <link rel="stylesheet" href="/libs/bootstrap.min.css">
    <link rel="stylesheet" href="/patterns/assets/css/main.css">
</head>
<body>
    <div class="box">
        <h2 class="box__title"><?= $_GET['title'] ?></h2>
        <p class="box__text">Сообщение: <?= $_GET['message'] ?></p>
        <a href="/">Вернуться назад</a>
    </div>
    <img src="/patterns/assets/img/header-cube-small-yellow.png" class="pattern-bottom">
    <img src="/patterns/assets/img/header-cube-big-blue.png" class="pattern-top">
    <div class="framework">Just One Framework</div>
</body>
</html>