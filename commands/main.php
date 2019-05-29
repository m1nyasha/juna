<?php

/**
 * @param $code
 * Функция возвращает HTTP код запроса
 */

function resCode($code)
{
    http_response_code($code);
}

/**
 * Функция позволяет вывести страницу из имеющихся в Views
 * @param $viewName
 */

function render($viewName, $data = [])
{
    if (file_exists('app/views/' . $viewName . '.php')) {
        include 'app/views/' . $viewName . '.php';
    } else {
        resCode(404);
    }

}

/**
 * Функция позволяет вывести часть из имеющихся в Views
 * @param $partName
 */

function renderPart($partName)
{
    include 'app/views/parts/' . $partName . '.php';
}

/**
 * Получение URL
 * Преобразование URL в массив для обработки Controller и Action
 * @param $number
 * @return mixed
 */

function getUrl($number)
{
    $url = trim(mb_strtolower($_GET['q']));
    $urlArray = explode('/', $url);
    return $urlArray[$number];
}

/**
 * Функция включает в себя массив библиотек, которые можно подключить в любой части приложения
 * @param $name
 */

function getLib($name)
{
    $libs = [
        "rb" => [
            "type" => "php",
            "path" => "libs/rb.php"
        ],
        "vue" => [
            "type" => "js",
            "path" => "/libs/vue.min.js"
        ],
        "jquery" => [
            "type" => "js",
            "path" => "/libs/jquery-3.4.1.min.js"
        ],
        "bootstrap" => [
            "type" => "css",
            "path" => "/libs/bootstrap.min.css"
        ],
        "flexbox" => [
            "type" => "css",
            "path" => "/libs/flex-box.min.css"
        ],
        "animated" => [
            "type" => "css",
            "path" => "/libs/animated.css"
        ]
    ];

    if ($libs[$name]['type'] == 'php') {
        require_once $libs[$name]['path'];
    } elseif ($libs[$name]['type'] == 'js') {
        echo '<script src="' . $libs[$name]['path'] . '"></script>';
    } elseif ($libs[$name]['type'] == 'css') {
        echo '<link rel="stylesheet" href="' . $libs[$name]['path'] . '">';
    }

}

/**
 * Функция возвращает отфильтрованныую строку по htmlspecialchars и trim
 * @param $str
 * @return string
 */

function str_filter($str)
{
    return htmlspecialchars(trim($str));
}

/**
 * Отображение отладочного сообщения
 * @param $title
 * @param $message
 */

function pattern($title, $message)
{
    require_once 'patterns/index.php';
    die();
}

/**
 * Функция для отображения моделей
 * @param $name
 */

function getModel($name)
{
    if (!file_exists('app/models/' . $name . '.php')) {
        pattern('MODEL', 'вы пытаетесь отобразить не существующую модель');
    }
    require_once 'app/models/' . $name . '.php';
}

/**
 * Функция для отображения правил
 * @param $name
 */

function getRule($name)
{
    if (!file_exists('vendor/rules/' . $name . '.php')) {
        pattern('RULES', 'вы пытаетесь отобразить не существующее правило');
    }
    require_once 'vendor/rules/' . $name . '.php';
}

/**
 * Получаем request метод
 * @return mixed
 */

function getRM () {
    return $_SERVER['REQUEST_METHOD'];
}

function getCommand($name) {
    if (!file_exists('commands/' . $name . '.php')) {
        pattern('MODEL', 'вы пытаетесь отобразить не существующую модель');
    }
    require_once 'commands/' . $name . '.php';
}