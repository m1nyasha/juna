<!doctype html>
<html lang="ru">
<head>
    <title>Just Framework</title>
    <?= renderPart('head') ?>
</head>
<body>
<section class="hello">
    <div class="hello-box animated fadeIn">
        <p class="hello__text">Just PHP Framework </p>
        <h1 class="hello__title"><?= $data['hello'] ?></h1>

    </div>
    <p class="successful"><b>Framework</b> is successfully installed, you can get to work</p>
</section>
</body>
</html>