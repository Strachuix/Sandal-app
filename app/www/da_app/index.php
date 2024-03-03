<?php
session_start();
require './db_connect.php';
require './class/classUser.php';

function myAutoloader($class)
{
    include 'class/' . $class . '.php';
}

spl_autoload_register('myAutoloader');
// Initialize or retrieve the User object
if (isset($_SESSION['user'])) {
    $User = unserialize($_SESSION['user']);
} else {
    $User = new User();
}

if (!$User->id) {
    // User is not logged in
    include "./sign/menu.php";
    require "./sign/sign_in.php";
} else {
    // User is logged in
    require "./menu.php";
    require "./functions/functions.php";

    $nav = isset($_GET['nav']) ? $_GET['nav'] : 'index';

    switch ($nav) {
        case 'index':
            require './main_page.php';
            break;

        case 'account_settings':
            require './forms/account_settings.php';
            break;

        case 'admin_panel':
            require './admin/templates/admin_main.php';
            break;

        case 'users_list':
            require './admin/templates/users_list.php';
            break;

        case 'my_groups':
            require './groups/my_groups.php';
            break;

        default:
            require './main_page.php';
            break;
    }
    require "./footer.php";
}
?>
</body>