<?php
    require './../db_connect.php';
    require './../class/classUser.php';

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
                $out = '';
                $meetings = $User->getMeetings();
                foreach ($meetings as $meeting) {
                  $out .='
                    <div class="col-xl-12">
                      <div class="card bg-orange" style="cursor:pointer;" group_id="' . $meeting['group_id'] . '">
                        <div class="card-body p-3">
                          <div class="d-flex flex-row justify-content-between">
                            <h5 class="card-title m-0">' . $meeting['group_name'] . '</h5>
                            <small>' . $meeting['time'] . '</small>
                          </div>
                        </div>
                      </div>
                    </div>';
                }
                echo $out;
                break;
        }
    }else{
        return false;
    }

?>