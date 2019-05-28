<?php
require_once 'commands/main.php';
require_once 'vendor/status.php';
getLib('rb');
require_once 'commands/db.php';

/*
 * Получаем нормальное имя контроллера и экшена, проверяя их наличие
 */

$controllerName = (empty(getUrl(0))) ? 'MainController' : ucfirst(getUrl(0)) . 'Controller';
$actionName = (empty(getUrl(1))) ? 'actionIndex' : 'action' . ucfirst(getUrl(1));

/*
 * Производим роутинг
 */

if (file_exists('app/controllers/' . $controllerName . '.php')) {
    require_once 'app/controllers/' . $controllerName . '.php';

    //Данное правило переписывает роутинг специально для контроллера posts
    $actionName = ($controllerName == 'PostsController' && ($actionName != 'actionIndex')) ? 'actionIndex' : $actionName;

    if (function_exists($actionName)) {
        $actionName();
    } else {
        resCode(404);
        render('404');
    }
} else {
    resCode(404);
    render('404');
}