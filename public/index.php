<?php


if (!file_exists(__DIR__ . '/../.env') && is_dir(__DIR__ . '/install/')){
    header('Location: /install/');
    exit;
}

echo "Hello World!";