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
            $user->$field = password_hash($data[$field]['body'] . $config['SECRET_KEY'], PASSWORD_DEFAULT);
        }

    }

    if ($errors != []) {
        return json_encode($errors);
    } else {
        if (R::store($user)) {
            http_response_code(200);
            return json_encode(["status" => true]);
        } else {
            $errors['status'] = false;
            $errors['server'] = 'Error save entry';
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

function user_authorization($login, $password) {
    $config = include 'vendor/config.php';
    $table = $config['user_auth']['table'];
    $login_column = $config['user_auth']['columns']['login'];
    $user = R::findOne($table, "WHERE $login_column = ?", [$login]);
    return (password_verify($password . $config['SECRET_KEY'], $user[$config['user_auth']['columns']['password']])) ? true : false;
}