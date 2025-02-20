<?php

/**
 * Функция отвечает за регистрацию пользователей
 * @param $data - принимает массив данных, который может состоять из ключей type, body, path, uniq
 * @return false|string
 */

function user_registration($data)
{
    $config = include 'vendor/config.php';
    $user = R::dispense($config['user_auth']['table']);
    $fields = array_keys($data);
    $errors = [];
    $config = include 'vendor/config.php';

    $column_login = $config['user_auth']['columns']['login'];
    $column_password = $config['user_auth']['columns']['password'];

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
            $user->$column_password = password_hash($data[$field]['body'] . $config['SECRET_KEY'], PASSWORD_DEFAULT);
        } elseif ($data[$field]['type'] == 'login') { //password
            $check_username = R::findOne($config['user_auth']['table'], "WHERE $column_login = ?", [$data[$field]['body']]);
            if (isset($check_username)) {
                $errors['status'] = false;
                $errors["errors"] = "uniq_login";
            } else {
                $user->$column_login = $data[$field]['body'];
            }
        }

    }

    if ($errors != []) {
        return json_encode($errors);
    } else {
        if (R::store($user)) {
            resCode(200);
            return json_encode(["status" => true]);
        } else {
            $errors['status'] = false;
            $errors['errors'] = 'Error save entry';
            return json_encode($errors);
        }
    }

}

/**
 * Авторизация пользователя
 * @param $login
 * @param $password
 * @return bool
 */

function user_authorization($login, $password)
{
    $config = include 'vendor/config.php';
    $table = $config['user_auth']['table'];
    $login_column = $config['user_auth']['columns']['login'];
    $user = R::findOne($table, "WHERE $login_column = ?", [$login]);
    return (password_verify($password . $config['SECRET_KEY'], $user[$config['user_auth']['columns']['password']])) ? true : false;
}

/**
 * @param $login
 * @return bool
 */

function check_auth_user($login)
{
    $config = include 'vendor/config.php';
    $table = $config['user_auth']['table'];
    $column_login = $config['user_auth']['columns']['login'];
    $check = R::findOne($table, "WHERE $column_login = ?", [$login]);
    return ($check) ? true : false;
}

/**
 * @param $login
 * @return NULL|\RedBeanPHP\OODBBean
 */

function load_user($login)
{
    $config = include 'vendor/config.php';
    $table = $config['user_auth']['table'];
    $column_login = $config['user_auth']['columns']['login'];
    $user = R::findOne($table, "WHERE $column_login = ?", [$login]);
    return $user;
}

/**
 * @param $key
 */

function logout($key)
{
    unset($_SESSION[$key]);
    session_destroy();
}

/**
 * @param $login
 * @return NULL|\RedBeanPHP\OODBBean
 */

function get_auth_user ($login) {
    $config = include 'vendor/config.php';
    $table = $config['user_auth']['table'];
    $column_login = $config['user_auth']['columns']['login'];
    $user = R::findOne($table, "WHERE $column_login = ?", [$_SESSION[$login]]);
    return $user;
}