<?php

if (!defined('INSTALLER')){
    exit;
}
function install(){

    if (!isset($_POST['install'])){
        return false;
    }

    $db_host = $_POST['db_host'];
    $db_name = $_POST['db_name'];
    $db_user = $_POST['db_user'];
    $db_password = $_POST['db_password'];
    $app_url = $_POST['app_url'];
    $app_name = $_POST['app_name'];

    $env_example = file_get_contents(__DIR__ . '/../../.env.example');

    # check database connection
    try {
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
    } catch (PDOException $e) {
        return 'Connection failed: ' . $e->getMessage();
    }

    # create .env files
    $env_example = str_replace('APP_URL=http://localhost', 'APP_URL=' . $app_url, $env_example);
    $env_example = str_replace('APP_NAME="Laravel"', 'APP_NAME="' . $app_name . '"', $env_example);
    $env_example = str_replace('DB_HOST=', 'DB_HOST=' . $db_host, $env_example);
    $env_example = str_replace('DB_DATABASE=', 'DB_DATABASE=' . $db_name, $env_example);
    $env_example = str_replace('DB_USERNAME=', 'DB_USERNAME=' . $db_user, $env_example);
    $env_example = str_replace('DB_PASSWORD=', 'DB_PASSWORD=' . $db_password, $env_example);

    file_put_contents(__DIR__ . '/../../.env', $env_example);


    return true;

    # migrate database
}