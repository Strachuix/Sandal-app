<?php
    session_start();

    require './../db_connect.php';
    require './../class/classUser.php';

    $User = new User();
    if(isset($_GET['action'])){
        switch($_GET['action']){
            case 'login':
                $res = $User -> login($_POST['login'], $_POST['password']);
                print_r($res?"success":"error");
                return json_encode($res?"success":"error");
                break;
            case 'logout':
                session_destroy();
                session_abort();

                return;
                break;
            case 'sign_in':
                $data = $_POST['data'];
                // print_r($data);
                $User->signUp($data);

            
                return;
                break;
            case 'update_user':
                $data = $_POST['data'];
                return $User->updateData($data);
                break;

        }
    }
?>