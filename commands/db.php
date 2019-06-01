<?php

/**
 * Подключение к базе данных происходит с помощью бибилотеки RedBeanPHP
 * Изменить данные для подключения базы можно в файле /vendor/config.php
 */

R::setup( 'mysql:host='. $config['db']['host'] .';dbname=' . $config['db']['db_name'],
    $config['db']['username'], $config['db']['password']);

if ($config['db']['status'] == true) {
    if (R::testConnection() == false) {
        pattern('База данных', 'произошла ошибка во время подключения к базе данных, проверьте правильность введенных данных в файле /vendor/config.php');
        die();
    }
}

