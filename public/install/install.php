<?php

if (!defined('INSTALLER')){
    exit;
}
function windows_os()
{
    return PHP_OS_FAMILY === 'Windows';
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
    $env_example = str_replace('DB_HOST=127.0.0.1', 'DB_HOST=' . $db_host, $env_example);
    $env_example = str_replace('DB_DATABASE=', 'DB_DATABASE=' . $db_name, $env_example);
    $env_example = str_replace('DB_USERNAME=', 'DB_USERNAME=' . $db_user, $env_example);
    $env_example = str_replace('DB_PASSWORD=', 'DB_PASSWORD=' . $db_password, $env_example);

    #language= APP_DEBUG=true false
    $env_example = str_replace('APP_DEBUG=true', 'APP_DEBUG=false', $env_example);

    #APP_ENV=local
    $env_example = str_replace('APP_ENV=local', 'APP_ENV=production', $env_example);

    #APP_KEY=
    $env_example = str_replace('APP_KEY=', 'APP_KEY=base64:'.base64_encode(random_bytes(32)), $env_example);

    file_put_contents(__DIR__ . '/../../.env', $env_example);


    // symlink storage

    $target = __DIR__ . '/../../storage/app/public/';
    $link = __DIR__ . '/../../public/storage/';

    if (! windows_os()) {
        return symlink($target, $link);
    }

    $mode = is_dir($target) ? 'J' : 'H';

    exec("mklink /{$mode} ".escapeshellarg($link).' '.escapeshellarg($target));

    return true;

    # migrate database
}
