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

function getRM()
{
    return $_SERVER['REQUEST_METHOD'];
}

/**
 * Подключаем команду вне main0
 * @param $name
 */

function getCommand($name)
{
    if (!file_exists('commands/' . $name . '.php')) {
        pattern('MODEL', 'вы пытаетесь отобразить не существующую модель');
    }
    require_once 'commands/' . $name . '.php';
}

/**
 * Функция отвечает за добавление данных в базу данных
 * Примечаение: столбец "id" добавляется автоматически
 * @param $data - принимает массив данных например - ["name_column" => $body]
 * @param $table
 * @return false|string
 */

function insertDB($data, $table)
{
    $config = include 'vendor/config.php';
    if ($config['db']['status'] == false) {
        pattern('insert DB', 'проверьте подключения к базе данных в /vendor/config.php');
    }
    $keys = array_keys($data);
    $insert = R::dispense($table);
    foreach ($keys as $key) {
        $insert->$key = $data[$key];
    }
    return (R::store($insert)) ? json_encode(["status" => true]) : json_encode(["status" => false]);
}

/**
 * Функция для загрузки изображения
 * @param $data = $_FILES
 * @param $rules - принимает 2 параметра format и size
 * @param $image_name - название файла в $_FILES
 * @param $path - путь загрузки
 * @return false|string
 */

function image_upload($data, $rules, $image_name, $path)
{
    $res = [];
    $format = false;
    $size = false;
    foreach ($rules['format'] as $rule) {
        $format = ($data[$image_name]['type'] == $rule) ? true : $format;
    }
    $size = ($data[$image_name]['size'] > $rules['size']) ? false : true;

    if ($size == true && $format == true) {
        $dir = $path . time() . '_' . $data[$image_name]['name'];
        if (move_uploaded_file($data[$image_name]['tmp_name'], $dir)) {
            $res['status'] = true;
            $res['path'] = $dir;
        } else {
            $res['status'] = false;
            $res['image'] = false;
        }
    } else {
        $res['status'] = false;
        if ($size == false) {
            $res['size'] = false;
        } elseif ($format == false) {
            $res['format'] = false;
        }
    }

    return json_encode($res);
}

/**
 * @param $table
 * @param $column
 * @param $data
 * @return bool
 */

function check_filed_DB($table, $column, $data)
{
    $check = R::findOne($table, "WHERE $column = ?", [$data]);
    return ($check) ? true : false;
}

/**
 * @param $array
 * @return false|string
 */

function json($array)
{
    header('Content-type: json/application');
    return json_encode($array);
}

/**
 * @param $link
 */

function redirect($link)
{
    header("Location: $link");
}