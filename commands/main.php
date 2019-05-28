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
 * Функция отвечает за регистрацию пользователей
 * Аргумент - $data принимает массив данных, который может состоять из ключей type, body, path, uniq
 * Аргумент - $table отвечает за название таблицы, в которой будут сохранятся пользователи
 * @param $data
 * @param $table
 */

function user_registration($data, $table)
{
    $user = R::dispense($table);
    $fields = array_keys($data);
    $errors = [];

    foreach ($fields as $field) {

        if ($data[$field]['type'] == 'text') { // text
            $user->$field = $data[$field]['body'];
        } elseif ($data[$field]['type'] == 'file') { //file

            $dir = '';

            if (isset($data[$field]['uniq']) && $data[$field]['uniq'] == true) {
                $dir = $data[$field]['path'] . '/' . time() . '_' . $_FILES[$field]['name'];
            } else {
                $dir = $data[$field]['path'] . '/' . $_FILES[$field]['name'];
            }

            if (move_uploaded_file($_FILES[$field]['tmp_name'], $dir)) {
                $user->$field = $dir;
            } else {
                $errors['status'] = false;
                $errors[$field] = 'Error upload file';
            }

        } elseif ($data[$field]['type'] == 'password') { //password
            $user->$field = password_hash($data[$field]['body'], PASSWORD_DEFAULT);
        }

    }

    if ($errors != []) {
        echo json_encode($errors);
    } else {
        if (R::store($user)) {
            http_response_code(200);
            echo json_encode(["status" => true]);
        } else {
            $errors['status'] = false;
            $errors['server'] = 'Error save entry';
            echo json_encode($errors);
        }
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
    header('Location: patterns/index.php?title=' . $title . '&message=' . $message);
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