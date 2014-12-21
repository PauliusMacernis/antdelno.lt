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
    $_SESSION['password']        = null;
    if (in_array(strtolower($password), $passwrods)) {
        $_SESSION['authorized_user'] = true;
        $_SESSION['password']        = $password;
    }

    $action = 'loggedInGoToIndex';
    
}

$action = null;
if (isset($_REQUEST['action'])) {
    $action = trim($_REQUEST['action']);
}

if (!isset($_SESSION['authorized_user']) || !($_SESSION['authorized_user'])) {
    $action = 'loginScreen';
}


// BEGIN. Already logged into web, log this fact into log-visits.log
$log_file = fopen(_VISITS_LOG_FILE, "a+");
fwrite($log_file, 
        "\n " . date("Y-m-d H:i:s") 
        . "\n IP:               " . $_SERVER['REMOTE_ADDR']
        . "\n Public password:  " . (isset($_SESSION['password']) ? $_SESSION['password'] : (isset($_REQUEST['password']) ? $_REQUEST['password'] : "-"))
        . "\n Action:           " . (isset($action) ? $action : "default")
        . "\n User agent:       " . $_SERVER['HTTP_USER_AGENT'] 
        . "\n"
        );
fclose($log_file);
// END. Already logged into web, log this fact into log-visits.log


// Action
switch ($action) {
    case 'loggedInGoToIndex':
        header("Location: /");
        die();
    
    case 'loginScreen':
        echo $View->login($Model->getContent('login'));
        die();
    
    case 'logout':
        session_destroy();
        header("Location: /");
        die();

    case 'post_comment':
        $comment_id = $Model->postComment();
        $Model->uploadFiles($comment_id);
        header("Location: /");
        die();
    
    default:
        $messages = $Model->getAllMessages();
        $messages_amount = count((array) $messages);

        echo $View->index($Model, $messages, $messages_amount);
        break;
}