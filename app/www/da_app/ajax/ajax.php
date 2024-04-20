<?php
    require './../db_connect.php';
    require './../class/classUser.php';
    session_start();

    if (isset($_SESSION['user'])) {
        $User = unserialize($_SESSION['user']);
    } else {
        $User = new User();
    }

    function generateString($length = 25){
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }


    if(isset($_GET['action']) || isset($_POST['action'])){
        $action = isset($_GET['action'])?$_GET['action']:$_POST['action'];

        switch($action){
            case 'load_meetings':
                $day = $_POST['day'];
                $meetings = $User->getMeetings($day);
                $out = json_encode($meetings);
                echo $out;
                break;
            case 'join_group':
                $group_id = $_POST['group_id'];
                $result = $User->joinGroup($group_id);
                echo $result;
                break;
            case 'show_groups':
                echo json_encode($User->getGroups());
                break;
            case 'show_leadered_groups':
                echo json_encode($User->getLeaderedGroups());
                break;
        }
    }else{
        return false;
    }

?>