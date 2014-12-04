<?php

session_start();

require_once 'config' . DIRECTORY_SEPARATOR . 'config.db.local.php';
require_once 'config' . DIRECTORY_SEPARATOR . 'config.site.local.php';

date_default_timezone_set(_TIMEZONE);
setlocale(LC_TIME, _LOCALE);

require_once 'model.php';
require_once 'view.php';

$Model = new MainModel();
$View = new MainView();

$loging_in = false;
if (isset($_REQUEST['login'])) {
    $loging_in = true;
}

// Log in...
if ($loging_in) {
    $password = isset($_REQUEST['password']) ? trim($_REQUEST['password']) : null;
    $passwrods = $Model->getValidPasswords();

    $_SESSION['authorized_user'] = false;
    if (in_array(strtolower($password), $passwrods)) {
        $_SESSION['authorized_user'] = true;
    }

    header("Location: /");
    die();
}


if (!isset($_SESSION['authorized_user']) || !($_SESSION['authorized_user'])) {

    echo $View->login($Model->getContent('login'));
    die();
}

$action = null;
if (isset($_REQUEST['action'])) {
    $action = trim($_REQUEST['action']);
}

// Action
switch ($action) {
    case 'logout':
        session_destroy();
        header("Location: /");
        die();
        break;

    case 'post_comment':
        $comment_id = $Model->postComment();
        $Model->uploadFiles($comment_id);
        header("Location: /");
        die();
        break;

    default:
        $messages = $Model->getAllMessages();
        $messages_amount = count((array) $messages);

        echo $View->index($Model, $messages, $messages_amount);
        break;
}