<?php
require_once "./../db_connect.php";
    switch($_POST['api']){
        case 'get_users_list':
            $out = [];
            $where = "";
            if(isset($_POST['filters']) && count($_POST['filters']) > 0){
                $where = "WHERE";
                foreach(json_decode($_POST['filters']) AS $filter => $value){
                    $where .=" $filter = '%$value%' AND";
                }
                //remove last 3 chars from filter
                $where = substr($where, -3);
            }
            $sql = "SELECT id, username, role, name, surname, birthday, email, phone FROM users $where";
            $res = mysqli_query($GLOBALS['connect'], $sql);
            while($row = mysqli_fetch_array($res)){
                array_push($out, $row);
            }
            echo json_encode($out);
            break;
    }
?>