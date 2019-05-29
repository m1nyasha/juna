<?php

if (empty($config['SECRET_KEY'])) {
    pattern('SECRET KEY', 'не корректный секретный ключ, проверьте правильность введенных данных в файле /vendor/config.php');
}