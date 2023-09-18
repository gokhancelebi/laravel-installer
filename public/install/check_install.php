<?php

if (!defined('INSTALLER')){
    exit;
}

function check_install(){
    if (file_exists(__DIR__ . '/../.env')) {
        return false;
    }
    #php version
    if (version_compare(PHP_VERSION, '8.0.0') < 0) {
        return false;
    }
    #symlink
    if (!function_exists('symlink')) {
        return false;
    }
    #storage
    if (!is_writable(__DIR__ . '/../../storage')) {
        return false;
    }
    #bootstrap/cache
    if (!is_writable(__DIR__ . '/../../bootstrap/cache')) {
        return false;
    }
    // check if env file exists
    if (!file_exists(__DIR__ . '/../../.env.example')) {
        echo 'Some files are missing. Please download the script again.';
        exit;
    }

    // required php extensions for laravel 10
    $required_extensions = [
        'bcmath',
        'ctype',
        'fileinfo',
        'json',
        'mbstring',
        'openssl',
        'pdo',
        'tokenizer',
        'xml',
    ];

    // check if all required extensions are installed
    foreach ($required_extensions as $extension) {
        if (!extension_loaded($extension)) {
            return false;
        }
    }

    return true;

}