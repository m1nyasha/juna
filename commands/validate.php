<?php

/**
 * @param $data
 * @return bool
 * Функция возвращает true в случае, если $data равна empty
 */

function valid_required($data)
{
    if (empty($data)) return true;
}

/**
 * @param $data
 * @return bool
 * Функция возвращает true в случае, если $data имеет кириллицу
 */

function valid_en($data)
{
    if (preg_match('/[^A-Za-z0-9]+/', $data)) return true;
}

/**
 * @param $data
 * @return bool
 * Функция возвращает true в случае, если $data не проходит валидацию на EMAIL
 */

function valid_email($data)
{
    if (!filter_var($data, FILTER_VALIDATE_EMAIL)) return true;
}

/**
 * @param $data
 * @return bool
 * Функция equals_passwords отвечает за сравнение 2х паролей
 * Для того, чтобы функция работала корректно, второй пароль должен быть получен по ключу "password_confirm"
 */

function valid_equals_passwords($data)
{
    if ($data != $_POST['password_confirm']) return true;
}

function valid_full_name () {

}

/**
 * @param $rulesList
 * @param $data
 * @return array
 * Функция возвращает массив с ошибками полей, которые были провалидированны.
 * Список правил для валидации:
 * required - проверяет поле на пустоту
 * en - проверяет, чтобы поле состояло только из английских символов
 * email - проверяет поле на соответвие стандартам EMAIL
 * equals_passwords - сверяет поле со вторым полем под ключем "password_confirm"
 */

function valid_form($rulesList, $data)
{
    $fields = array_keys($rulesList);
    $errors = [];

    foreach ($fields as $field) {
        $fieldData = $data[$field];
        $rules = $rulesList[$field];
        foreach ($rules as $rule) {
            $function = 'valid_' . $rule;
            if ($function($fieldData) == true) $errors[$field][] = $rule;
        }
    }

    return $errors;

}