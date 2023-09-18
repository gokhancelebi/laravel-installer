<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Database and webstite settings</title>
</head>
<body>
<?php

define('INSTALLER', true);

include __DIR__ . '/check_install.php';
include __DIR__ . '/install.php';

if (!check_install()) {
    header('Location: index.php');
    exit;
}



if(file_exists(__DIR__ . '/../../.env')){
    exit;
}

$error_message = '';

if (isset($_POST['install'])){
    $installed = install();
    if ($installed !== true){
        $error_message = $installed ;
    }else if ($installed === true){
        header('Location: completed.php');
        exit;
    }
}

?>
<form action="database.php" method="post" class="form">
    <!-- database and website settings -->
    <h1>
        Laravel Script Installer
    </h1>
    <div>
        <label for="db_host">Database host</label>
        <input type="text" name="db_host" id="db_host" value="localhost">
    </div>
    <div>
        <label for="db_name">Database name</label>
        <input type="text" name="db_name" id="db_name" value="blog">
    </div>
    <div>
        <label for="db_user">Database user</label>
        <input type="text" name="db_user" id="db_user" value="root">
    </div>
    <div>
        <label for="db_password">Database password</label>
        <input type="text" name="db_password" id="db_password" value="">
    </div>
    <div>
        <label for="app_url">Website URL</label>
        <input type="text" name="app_url" id="app_url" value="http://localhost">
    </div>
    <div>
        <label for="app_name">Website name</label>
        <input type="text" name="app_name" id="app_name" value="My Blog">
    </div>
    <?php if ($error_message): ?>
        <div style="color: red;text-align: center">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>
    <div>
        <button type="submit">Install</button>
    </div>
    <input type="hidden" name="install" value="yes">
</form>
<style>
    .form h1{
        text-align: center;
    }
    .form{
        width: 50%;
        margin: 0 auto;
        max-width: 600px;
        border: 1px solid #ccc;
        display: flex;
        flex-direction: column;

    }
    .form div{
        display: flex;
        flex-direction: column;
        padding: 10px;
    }
    .form div button{
        padding: 5px;
        margin-top: 5px;
        border: 1px solid #ccc;
    }
    .form div input{
        padding: 5px;
        margin-top: 5px;
        border: 1px solid #ccc;
    }
</style>
</body>
</html>