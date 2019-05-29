<?php

getModel('hello');

function actionIndex()
{
    render('index', ["hello" => hello()]);
}