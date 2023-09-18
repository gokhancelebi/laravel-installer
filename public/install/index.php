<?php

/*
 * Laravel script installer for shared hosting
 * Will check if the .env file exists and if not will redirect to the installer
 * Will check php version is 8.0 or higher
 * Will check if simlink is enabled
 * Will check if the storage folder is writable
 * Will check if the bootstrap/cache folder is writable
 * 
 * 
 */

define('INSTALLER', true);

$can_install = true;

include __DIR__ . '/check_install.php';
include  __DIR__ . '/install.php';

if(file_exists(__DIR__ . '/../../.env')){
    exit;
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel Script Installer</title>
</head>
<body>
 <div class="container">

     <h1>Laravel Script Installer</h1>
     <table>
         <tr>
             <td>Is PHP version higher than 8.0</td>
             <td>
                 <?php
                 if (version_compare(PHP_VERSION, '8.0.0') >= 0) {
                     echo '<span style="color: green">Yes</span>';
                 } else {
                     echo '<span style="color: red">No</span>';
                 }
                 ?>
             </td>
         </tr>
         <tr>
             <td>Is symlink enabled</td>
             <td>
                 <?php
                 if (function_exists('symlink')) {
                     echo '<span style="color: green">Yes</span>';
                 } else {
                     echo '<span style="color: red">No</span>';
                 }
                 ?>
             </td>
         </tr>
         <tr>
             <td>Is storage folder writable</td>
             <td>
                 <?php
                 if (is_writable(__DIR__ . '/../../storage')) {
                     echo '<span style="color: green">Yes</span>';
                 } else {
                     echo '<span style="color: red">No</span>';
                 }
                 ?>
             </td>
         </tr>
         <tr>
             <td>Is bootstrap/cache folder writable</td>
             <td>
                 <?php
                 if (is_writable(__DIR__ . '/../../bootstrap/cache')) {
                     echo '<span style="color: green">Yes</span>';
                 } else {
                     echo '<span style="color: red">No</span>';
                 }
                 ?>
             </td>
         </tr>
         <?php
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
         foreach ($required_extensions as $extension) {
         ?>
         <tr>
             <td>Is <?php echo $extension; ?> extension installed</td>
             <td>
                 <?php
                 if (extension_loaded($extension)) {
                     echo '<span style="color: green">Yes</span>';
                 } else {
                     echo '<span style="color: red">No</span>';
                 }
                 ?>
             </td>
             <?php
             }
             ?>

         <tr>
             <td>Can install</td>
             <td>
                 <?php
                 if ($can_install) {
                     echo '<span style="color: green">Yes</span>';
                 } else {
                     echo '<span style="color: red">No</span>';
                 }
                 ?>
             </td>
         </tr>
         <tr>
             <td colspan="2" class="install-button">
                 <?php
                 if (check_install()) {
                     echo '<a href="database.php">Step 2 >> </a>';
                 }else{
                     # refresh
                     ?>
                     <button type="button" onclick="location.reload()">Refresh</button>
                     <?php
                 }
                 ?>
             </td>
     </table>
 </div>
<style>
    .container{
        width: 50%;
        margin: 0 auto;
        max-width: 600px;
        border: 1px solid #ccc;
        display: flex;
        flex-direction: column;
    }
    .container h1{
        text-align: center;
    }
    .container table{
        width: 100%;
    }

    .container table td{
        padding: 10px;
        border: 1px solid #ccc;
    }
    .container table td:first-child{
        width: 50%;
    }
    .container table td:last-child{
        width: 50%;
    }
    .container table tr:nth-child(odd){
        background-color: #f1f1f1;
    }
    .container table tr:nth-child(even){
        background-color: #fff;
    }
    .container table tr:last-child{
        background-color: #ccc;
    }
    .install-button{
        padding: 10px;
        text-align: center;
    }
    .install-button a{
        padding: 10px 20px;
        margin-top: 20px;
        border: 1px solid #ccc;
        background-color: rgba(5,59,142,0.83);
        color: #fff;
        text-decoration: none;

    }

</style>
</body>
</html>
